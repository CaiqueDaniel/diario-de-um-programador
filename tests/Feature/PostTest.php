<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Cocur\Slugify\Slugify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Interfaces\CRUDTest;
use Tests\Feature\Interfaces\SoftDeleteTest;
use Tests\TestCase;

class PostTest extends TestCase implements CRUDTest, SoftDeleteTest
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

    public function test_listing(): void
    {
        $response = $this->get('/painel/artigos/listar');

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.post.listing');
    }

    public function test_load_form_create(): void
    {
        $response = $this->get('/painel/artigos/criar');

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.post.form');
    }

    public function test_creation(): void
    {
        Storage::fake('local');

        $title = $this->faker->name();
        $subtitle = $this->faker->text();
        $article = $this->faker->text();

        $response = $this->post('/painel/artigos', [
            'title' => $title,
            'subtitle' => $subtitle,
            'article' => $article,
            'thumbnail' => UploadedFile::fake()->create($this->faker->name() . '.jpg')
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Artigo criado com sucesso');

        $this->assertDatabaseHas(Post::class, ['title' => $title, 'subtitle' => $subtitle, 'article' => $article]);

        /** @var Post $post $post */
        $post = Post::where('title', 'like', $title)->first();

        $this->assertNotNull($post->getPermalink());
        $this->assertNotNull($post->getThumbnail());
    }

    public function test_creation_with_category(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->setPermalink($slugfy->slugify($category->getName()));
        $category->save();

        $this->assertDatabaseHas(Category::class, $category->toArray());

        Storage::fake('local');

        $title = $this->faker->name();
        $subtitle = $this->faker->text();
        $article = $this->faker->text();

        $response = $this->post('/painel/artigos', [
            'title' => $title,
            'subtitle' => $subtitle,
            'article' => $article,
            'thumbnail' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'categories' => [$category->getId()]
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Artigo criado com sucesso');

        $this->assertDatabaseHas(Post::class, ['title' => $title, 'subtitle' => $subtitle, 'article' => $article]);

        /** @var Post $post $post */
        $post = Post::with('categories')->where('title', 'like', $title)->first();

        $this->assertNotNull($post->getPermalink());
        $this->assertNotNull($post->getThumbnail());
        $this->assertNotEmpty($post->getRelation('categories'));
        $this->assertCount(1, $post->getRelation('categories'));
    }

    public function test_deletion(): void
    {
        $title = $this->faker->name();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($title)
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $this->user->posts()->save($post);

        $this->assertDatabaseHas(Post::class, ['id' => $post->getId()]);

        $response = $this->delete(route('admin.post.destroy', ['post' => $post->getId()]));

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Artigo removido com sucesso');

        $this->assertDatabaseMissing(Post::class, ['id' => $post->getId()]);
    }

    public function test_search_with_results(): void
    {
        // TODO: Implement test_search_with_results() method.
    }

    public function test_search_without_results(): void
    {
        // TODO: Implement test_search_without_results() method.
    }

    public function test_enabling_item(): void
    {
        // TODO: Implement test_enabling_item() method.
    }

    public function test_disabling_item(): void
    {
        // TODO: Implement test_disabling_item() method.
    }

    public function test_update(): void
    {
        // TODO: Implement test_update() method.
    }
}
