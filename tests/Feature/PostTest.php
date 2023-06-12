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
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->migrateFreshUsing();

        $user = new User([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make('123456'),
        ]);

        $user->save();

        $this->post('/login', [
            'email' => $user->email,
            'password' => '123456'
        ]);
    }

    public function test_list_posts(): void
    {
        $response = $this->get('/painel/artigos/listar');

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.post.listing');
    }

    public function test_load_posts_create_form(): void
    {
        $response = $this->get('/painel/artigos/criar');

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.post.form');
    }

    public function test_create_post(): void
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

        $this->assertNotNull($post->permalink);
        $this->assertNotNull($post->thumbnail);
    }

    public function test_create_with_category_post(): void
    {
        $slugfy = new Slugify();
        $category = new Category(['name' => $this->faker->userName()]);
        $category->permalink = $slugfy->slugify($category->name);
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
            'categories' => [$category->id]
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Artigo criado com sucesso');

        $this->assertDatabaseHas(Post::class, ['title' => $title, 'subtitle' => $subtitle, 'article' => $article]);

        /** @var Post $post $post */
        $post = Post::with('categories')->where('title', 'like', $title)->first();

        $this->assertNotNull($post->permalink);
        $this->assertNotNull($post->thumbnail);
        $this->assertNotEmpty($post->getRelation('categories'));
        $this->assertCount(1, $post->getRelation('categories'));
    }
}
