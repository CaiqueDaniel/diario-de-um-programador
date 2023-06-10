<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Cocur\Slugify\Slugify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->migrateFreshUsing();

        $this->user = new User([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make('123456'),
        ]);

        $this->user->save();

        $this->post('/login', [
            'email' => $this->user->email,
            'password' => '123456'
        ]);
    }

    public function test_list_categories(): void
    {
        $this->assertAuthenticatedAs($this->user);

        $response = $this->get('/painel/categorias/listar');
        $response
            ->assertOk()
            ->assertViewIs('pages.admin.category.listing');
    }

    public function test_load_category_create_form(): void
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
        $parent->permalink = $slugfy->slugify($parent->name);
        $parent->save();

        $this->assertDatabaseHas(Category::class, $parent->toArray());

        $name = $this->faker->userName();
        $response = $this->post('/painel/categorias', ['name' => $name, 'parent' => $parent->id]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria criada com sucesso');

        $this->assertDatabaseHas(Category::class, ['name' => $name]);
    }

    public function test_edit_simple_category(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->permalink = $slugfy->slugify($category->name);
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $name = $this->faker->userName();
        $response = $this->put("/painel/categorias/{$category->id}", ['name' => $name]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria editada com sucesso');

        $this->assertDatabaseHas(Category::class, ['name' => $name]);

        /** @var Category $editedCategory */
        $editedCategory = Category::where('name', 'like', $name)->first();

        $this->assertEquals($category->id, $editedCategory->id);
        $this->assertNotEquals($category->name, $editedCategory->name);
        $this->assertNotEquals($category->permalink, $editedCategory->permalink);
    }

    public function test_edit_nested_category_with_same_parent(): void
    {
        $slugfy = new Slugify();

        $firstParent = new Category(['name' => $this->faker->userName()]);
        $firstParent->permalink = $slugfy->slugify($firstParent->name);
        $firstParent->save();

        $this->assertDatabaseHas(Category::class, $firstParent->toArray());

        $category = new Category(['name' => $this->faker->userName()]);
        $category->permalink = $slugfy->slugify($category->name);
        $firstParent->children()->save($category);

        $this->assertDatabaseHas(Category::class, $category->toArray());
        $this->assertNotNull($category->parent()->first());

        $name = $this->faker->userName();
        $response = $this->put("/painel/categorias/{$category->id}", ['name' => $name, 'parent' => $firstParent->id]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria editada com sucesso');

        $this->assertDatabaseHas(Category::class, ['name' => $name]);

        /** @var Category $editedCategory */
        $editedCategory = Category::where('name', 'like', $name)->first();

        $this->assertEquals($category->id, $editedCategory->id);
        $this->assertEquals($firstParent->id, $category->parent()->first()->id);
        $this->assertNotEquals($category->name, $editedCategory->name);
        $this->assertNotEquals($category->permalink, $editedCategory->permalink);
    }

    public function test_edit_nested_category_with_diferent_parent(): void
    {
        $slugfy = new Slugify();

        $firstParent = new Category(['name' => $this->faker->userName()]);
        $firstParent->permalink = $slugfy->slugify($firstParent->name);
        $firstParent->save();

        $this->assertDatabaseHas(Category::class, $firstParent->toArray());

        $secondParent = new Category(['name' => $this->faker->userName()]);
        $secondParent->permalink = $slugfy->slugify($secondParent->name);
        $secondParent->save();

        $this->assertDatabaseHas(Category::class, $secondParent->toArray());

        $category = new Category(['name' => $this->faker->userName()]);
        $category->permalink = $slugfy->slugify($category->name);
        $firstParent->children()->save($category);

        $this->assertDatabaseHas(Category::class, $category->toArray());
        $this->assertNotNull($category->parent()->first());

        $name = $this->faker->userName();
        $response = $this->put("/painel/categorias/{$category->id}", ['name' => $name, 'parent' => $secondParent->id]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Categoria editada com sucesso');

        $this->assertDatabaseHas(Category::class, ['id' => $category->id]);

        /** @var Category $editedCategory */
        $editedCategory = Category::where('name', 'like', $name)->first();

        $this->assertEquals($category->id, $editedCategory->id);
        $this->assertEquals($secondParent->id, $editedCategory->parent()->first()->id);
        $this->assertNotEquals($category->name, $editedCategory->name);
        $this->assertNotEquals($category->permalink, $editedCategory->permalink);
    }

    public function test_edit_category_without_url_parameter(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->permalink = $slugfy->slugify($category->name);
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias", ['name' => $this->faker->userName()]);

        $response->assertStatus(405);
    }

    public function test_required_name(): void
    {
        $response = $this->post('/painel/categorias');
        $response
            ->assertRedirect()
            ->assertInvalid(['name']);

        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->permalink = $slugfy->slugify($category->name);
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias/{$category->id}");

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
        $category->permalink = $slugfy->slugify($category->name);
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias/{$category->id}", ['name' => $this->faker->userName(), 'parent' => 'abc']);

        $response
            ->assertRedirect()
            ->assertInvalid(['parent']);
    }

    public function test_setting_parent_as_itsself(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->permalink = $slugfy->slugify($category->name);
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        $response = $this->put("/painel/categorias/{$category->id}", ['name' => $this->faker->userName(), 'parent' => $category->id]);

        $response
            ->assertRedirect()
            ->assertInvalid(['parent']);
    }
}
