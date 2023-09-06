<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Cocur\Slugify\Slugify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Fixture\WithLoggedSuperAdmin;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithLoggedSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupUserWithSessionByTest($this);
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
        $slugfy = new Slugify();

        DB::transaction(function () use ($slugfy) {
            for ($i = 0; $i < 10; $i++) {
                $title = $this->faker->name();

                $post = new Post();
                $post->setTitle($title)
                    ->setSubtitle($this->faker->text())
                    ->setArticle($this->faker->text())
                    ->setPermalink($slugfy->slugify($title))
                    ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

                $this->user->posts()->save($post);
            }
        });

        /** @var Post $post */
        $post = Post::all()->first();
        $response = $this->get("/painel/artigos/listar?search={$post->getTitle()}");

        $response
            ->assertOk()
            ->assertViewHas('response', function (LengthAwarePaginator $data) use ($post) {
                /** @var Post[] $items */
                $items = $data->items();

                return $items[0]->getId() == $post->getId();
            });
    }

    public function test_search_without_results(): void
    {
        $slugfy = new Slugify();

        DB::transaction(function () use ($slugfy) {
            for ($i = 0; $i < 10; $i++) {
                $title = $this->faker->name();

                $post = new Post();
                $post->setTitle($title)
                    ->setSubtitle($this->faker->text())
                    ->setArticle($this->faker->text())
                    ->setPermalink($slugfy->slugify($title))
                    ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

                $this->user->posts()->save($post);
            }
        });

        $response = $this->get("/painel/artigos/listar?search=invalid");

        $response
            ->assertOk()
            ->assertViewHas('response', fn(LengthAwarePaginator $data) => empty($data->items()));
    }

    public function test_enabling_item(): void
    {
        $slugfy = new Slugify();
        $title = $this->faker->name();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($slugfy->slugify($title))
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $this->user->posts()->save($post);

        $post->delete();
        $post->save();

        $this->assertDatabaseHas(Post::class, ['id' => $post->getId()]);

        $response = $this->patch("/painel/artigos/{$post->getId()}/ativar");
        $response->assertOk();

        /** @var Post $post */
        $post = Post::query()->find($post->getId());
        $this->assertFalse($post->trashed());
    }

    public function test_disabling_item(): void
    {
        $slugfy = new Slugify();
        $title = $this->faker->name();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($slugfy->slugify($title))
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $this->user->posts()->save($post);

        $this->assertDatabaseHas(Post::class, ['id' => $post->getId()]);

        $response = $this->patch("/painel/artigos/{$post->getId()}/desativar");
        $response->assertOk();

        /** @var Post $post */
        $post = Post::withTrashed()->find($post->getId());
        $this->assertTrue($post->trashed());
    }

    public function test_update(): void
    {
        $slugfy = new Slugify();
        $title = $this->faker->name();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($slugfy->slugify($title))
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $this->user->posts()->save($post);

        $title = $this->faker->name();
        $subtitle = $this->faker->text();
        $article = $this->faker->text();

        $response = $this->put("/painel/artigos/{$post->getId()}", [
            'title' => $title,
            'subtitle' => $subtitle,
            'article' => $article,
            'thumbnail' => UploadedFile::fake()->create($this->faker->name() . '.jpg')
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Artigo editado com sucesso');

        $this->assertDatabaseHas(Post::class, ['title' => $title, 'subtitle' => $subtitle, 'article' => $article]);

        /** @var Post $post $post */
        $post = Post::where('title', 'like', $title)->first();

        $this->assertNotNull($post->getPermalink());
        $this->assertNotNull($post->getThumbnail());
    }

    public function test_view_enabled_and_published_post(): void
    {
        $title = $this->faker->title();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($title)
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $this->user->posts()->save($post);

        $post->publish();

        $this->assertDatabaseHas(Post::class, ['id' => $post->getId()]);

        $response = $this->get(route('web.post.view', ['slug' => $post->getPermalink()]));

        $response->assertOk();
        $response->assertViewIs('pages.web.post.post');
    }

    public function test_view_disabled_and_published_post(): void
    {
        $title = $this->faker->title();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($title)
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $this->user->posts()->save($post);

        $post->publish();
        $post->delete();

        $this->assertDatabaseHas(Post::class, ['id' => $post->getId()]);

        $response = $this->get(route('web.post.view', ['slug' => $post->getPermalink()]));

        $response->assertNotFound();
    }

    public function test_view_unpublished_post(): void
    {
        $title = $this->faker->title();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($title)
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $this->user->posts()->save($post);

        $this->assertDatabaseHas(Post::class, ['id' => $post->getId()]);

        $response = $this->get(route('web.post.view', ['slug' => $post->getPermalink()]));

        $response->assertNotFound();
    }

    public function test_view_unexistent_post(): void
    {
        $title = $this->faker->title();

        $post = new Post();
        $post->setTitle($title)
            ->setSubtitle($this->faker->text())
            ->setArticle($this->faker->text())
            ->setPermalink($title)
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'));

        $response = $this->get(route('web.post.view', ['slug' => $post->getPermalink()]));

        $response->assertNotFound();
    }
}
