<?php

namespace Tests\Feature;

use App\Models\Category;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Fixture\WithLoggedSuperAdmin;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithLoggedSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupUserWithSessionByTest($this);
    }

    public function test_listing(): void
    {
        $this->assertAuthenticatedAs($this->user);

        $response = $this->get('/painel/categorias/listar');
        $response
            ->assertOk()
            ->assertViewIs('pages.admin.category.listing');
    }

    public function test_load_form_create(): void
    {
        $this->assertAuthenticatedAs($this->user);

        $response = $this->get('/painel/categorias/criar');
        $response
            ->assertOk()
            ->assertViewIs('pages.admin.category.form');
    }

    public function test_create_simple_category(): void
    {
        $name = $this->faker->userName();
        $response = $this->post('/painel/categorias', ['name' => $name]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria criada com sucesso');

        $this->assertDatabaseHas(Category::class, ['name' => $name]);
    }

    public function test_create_nested_category(): void
    {
        $slugfy = new Slugify();
        $parent = new Category(['name' => $this->faker->userName()]);
        $parent->setPermalink($slugfy->slugify($parent->getName()));
        $parent->save();

        $this->assertDatabaseHas(Category::class, $parent->toArray());

        $name = $this->faker->userName();
        $response = $this->post('/painel/categorias', ['name' => $name, 'parent' => $parent->getId()]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria criada com sucesso');

        $this->assertDatabaseHas(Category::class, ['name' => $name]);
    }

    public function test_edit_simple_category(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $name = $this->faker->userName();
        $response = $this->put("/painel/categorias/{$category->getId()}", ['name' => $name]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria editada com sucesso');

        $this->assertDatabaseHas(Category::class, ['name' => $name]);

        /** @var Category $editedCategory */
        $editedCategory = Category::where('name', 'like', $name)->first();

        $this->assertEquals($category->getId(), $editedCategory->getId());
        $this->assertNotEquals($category->getName(), $editedCategory->getName());
        $this->assertNotEquals($category->getPermalink(), $editedCategory->getPermalink());
    }

    public function test_edit_nested_category_with_same_parent(): void
    {
        $slugfy = new Slugify();

        $firstParent = new Category(['name' => $this->faker->userName()]);
        $firstParent->setPermalink($slugfy->slugify($firstParent->getName()));
        $firstParent->save();

        $this->assertDatabaseHas(Category::class, $firstParent->toArray());

        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $firstParent->children()->save($category);

        $this->assertDatabaseHas(Category::class, $category->toArray());
        $this->assertNotNull($category->parent()->first());

        $name = $this->faker->userName();
        $response = $this->put("/painel/categorias/{$category->getId()}", ['name' => $name, 'parent' => $firstParent->getId()]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria editada com sucesso');

        $this->assertDatabaseHas(Category::class, ['name' => $name]);

        /** @var Category $editedCategory */
        $editedCategory = Category::query()->where('name', 'like', $name)->first();

        $this->assertEquals($category->getId(), $editedCategory->getId());
        $this->assertEquals($firstParent->getId(), $category->parent()->first()->getId());
        $this->assertNotEquals($category->getName(), $editedCategory->getName());
        $this->assertNotEquals($category->getPermalink(), $editedCategory->getPermalink());
    }

    public function test_edit_nested_category_with_diferent_parent(): void
    {
        $slugfy = new Slugify();

        $firstParent = new Category(['name' => $this->faker->userName()]);
        $firstParent->setPermalink($slugfy->slugify($firstParent->getName()));
        $firstParent->save();

        $this->assertDatabaseHas(Category::class, $firstParent->toArray());

        $secondParent = new Category(['name' => $this->faker->userName()]);
        $secondParent->setPermalink($slugfy->slugify($secondParent->getName()));
        $secondParent->save();

        $this->assertDatabaseHas(Category::class, $secondParent->toArray());

        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $firstParent->children()->save($category);

        $this->assertDatabaseHas(Category::class, $category->toArray());
        $this->assertNotNull($category->parent()->first());

        $name = $this->faker->userName();
        $response = $this->put("/painel/categorias/{$category->getId()}", ['name' => $name, 'parent' => $secondParent->getId()]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria editada com sucesso');

        $this->assertDatabaseHas(Category::class, ['id' => $category->getId()]);

        /** @var Category $editedCategory */
        $editedCategory = Category::query()->where('name', 'like', $name)->first();

        $this->assertEquals($category->getId(), $editedCategory->getId());
        $this->assertEquals($secondParent->getId(), $editedCategory->parent()->first()->getId());
        $this->assertNotEquals($category->getName(), $editedCategory->getName());
        $this->assertNotEquals($category->getPermalink(), $editedCategory->getPermalink());
    }

    public function test_edit_category_without_url_parameter(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias", ['name' => $this->faker->userName()]);

        $response->assertStatus(405);
    }

    public function test_disabling_item(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->patch("/painel/categorias/{$category->getId()}/desativar");
        $response->assertOk();

        /** @var Category $category */
        $category = Category::withTrashed()->where('id', '=', $category->getId())->first();
        $this->assertNotNull($category->deleted_at);
    }

    public function test_enabling_item(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));

        $category->save();
        $category->delete();
        $category->save();

        $modelData = $category->toArray();

        unset($modelData['deleted_at']);

        $this->assertDatabaseHas(Category::class, $modelData);

        $response = $this->patch("/painel/categorias/{$category->getId()}/ativar");
        $response->assertOk();

        /** @var Category $category */
        $category = Category::withTrashed()->where('id', '=', $category->getId())->first();
        $this->assertNull($category->deleted_at);
    }

    public function test_deletion(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->delete("/painel/categorias/{$category->getId()}");

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria excluída com sucesso');

        $this->assertDatabaseMissing(Category::class, $category->toArray());
    }

    public function test_required_name(): void
    {
        $response = $this->post('/painel/categorias');
        $response
            ->assertRedirect()
            ->assertInvalid(['name']);

        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias/{$category->getId()}");

        $response
            ->assertRedirect()
            ->assertInvalid(['name']);
    }

    public function test_invalid_parent(): void
    {
        $response = $this->post('/painel/categorias', ['name' => $this->faker->userName(), 'parent' => 'abc']);
        $response
            ->assertRedirect()
            ->assertInvalid(['parent']);

        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias/{$category->getId()}", ['name' => $this->faker->userName(), 'parent' => 'abc']);

        $response
            ->assertRedirect()
            ->assertInvalid(['parent']);
    }

    public function test_setting_parent_as_itsself(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias/{$category->getId()}", ['name' => $this->faker->userName(), 'parent' => $category->getId()]);

        $response
            ->assertRedirect()
            ->assertInvalid(['parent']);
    }

    public function test_search_with_results(): void
    {
        $slugfy = new Slugify();

        DB::transaction(function () use ($slugfy) {
            for ($i = 0; $i < 10; $i++) {
                $category = new Category(['name' => $this->faker->userName()]);
                $category->setPermalink($slugfy->slugify($category->getName()))->saveOrFail();
            }
        });

        $category = Category::all()->first();
        $response = $this->get("/painel/categorias/listar?search={$category->getName()}");

        $expected = new Collection();

        $expected->add($category);

        $response
            ->assertOk()
            ->assertViewHas('items', $expected);
    }

    public function test_search_without_results(): void
    {
        $slugfy = new Slugify();

        DB::transaction(function () use ($slugfy) {
            for ($i = 0; $i < 10; $i++) {
                $category = new Category(['name' => $this->faker->userName()]);
                $category->setPermalink($slugfy->slugify($category->getName()))->saveOrFail();
            }
        });

        $response = $this->get("/painel/categorias/listar?search=invalid");

        $response
            ->assertOk()
            ->assertViewHas('items', new Collection());
    }
}
