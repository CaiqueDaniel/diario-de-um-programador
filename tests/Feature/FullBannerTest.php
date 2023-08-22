<?php

namespace Tests\Feature;

use App\Models\{FullBanner, User};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FullBannerTest extends TestCase
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

    public function test_listing(): void
    {
        $response = $this->get('/painel/fullbanners/listar');

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.fullbanner.listing');
    }

    public function test_load_form_create(): void
    {
        $response = $this->get('/painel/fullbanners/criar');

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.fullbanner.form');
    }

    public function test_creation(): void
    {
        $title = $this->faker->name();
        $link = $this->faker->url();

        $response = $this->post('/painel/fullbanners', [
            'title' => $title,
            'link' => $link,
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Fullbanner criado com sucesso');

        $this->assertDatabaseHas(FullBanner::class, ['title' => $title, 'link' => $link]);

        /** @var FullBanner $banner */
        $banner = FullBanner::query()->where('title', 'like', $title)->first();

        $this->assertNotNull($banner->getImage());
    }

    public function test_deletion(): void
    {
        $banner = new FullBanner([
            'title' => $this->faker->name(),
            'link' => $this->faker->url(),
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'position' => 1
        ]);

        $banner->save();

        $this->assertDatabaseHas(FullBanner::class, $banner->toArray());

        $response = $this->delete("/painel/fullbanners/{$banner->getId()}");

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Fullbanner excluído com sucesso');

        $this->assertDatabaseMissing(FullBanner::class, $banner->toArray());
    }

    public function test_update(): void
    {
        $position = 1;

        $banner = new FullBanner([
            'title' => $this->faker->name(),
            'link' => $this->faker->url(),
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'position' => $position
        ]);

        $banner->save();

        $this->assertDatabaseHas(FullBanner::class, $banner->toArray());

        $title = $this->faker->name();
        $link = $this->faker->url();

        $response = $this->put("/painel/fullbanners/{$banner->getId()}", [
            'title' => $title,
            'link' => $link,
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg')
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Fullbanner alterado com sucesso');

        $this->assertDatabaseHas(FullBanner::class, ['title' => $title, 'link' => $link, 'position' => $position]);

        /** @var FullBanner $banner */
        $banner = FullBanner::query()->where('title', 'like', $title)->first();

        $this->assertNotNull($banner->getTitle());
    }

    public function test_enabling_item(): void
    {
        $banner = new FullBanner([
            'title' => $this->faker->name(),
            'link' => $this->faker->url(),
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'position' => 1
        ]);

        $banner->save();
        $banner->delete();
        $banner->save();

        $this->assertDatabaseHas(FullBanner::class, ['title' => $banner->getTitle()]);

        $modelData = $banner->toArray();

        unset($modelData['deleted_at']);

        $this->patch("/painel/fullbanners/{$banner->getId()}/ativar")->assertOk();
        $this->assertDatabaseHas(FullBanner::class, $modelData);

        $banner = FullBanner::withoutTrashed()->find($banner->getId());

        $this->assertFalse($banner->trashed());
    }

    public function test_disabling_item(): void
    {
        $banner = new FullBanner([
            'title' => $this->faker->name(),
            'link' => $this->faker->url(),
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'position' => 1
        ]);

        $banner->save();

        $this->assertDatabaseHas(FullBanner::class, $banner->toArray());
        $this->patch("/painel/fullbanners/{$banner->getId()}/desativar")->assertOk();

        $banner = FullBanner::withTrashed()->find($banner->getId());

        $this->assertTrue($banner->trashed());
    }

    public function test_search_with_results(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < 10; $i++) {
                $banner = new FullBanner([
                    'title' => $this->faker->name(),
                    'link' => $this->faker->url(),
                    'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
                    'position' => $i + 1
                ]);

                $banner->save();
            }
        });

        /** @var FullBanner $banner */
        $banner = FullBanner::all()->first();
        $response = $this->get("/painel/fullbanners/listar?search={$banner->getTitle()}");

        $expected = new Collection();
        $expected->add($banner);

        $response
            ->assertOk()
            ->assertViewHas('response', function (LengthAwarePaginator $data) use ($banner) {
                /** @var FullBanner[] $items */
                $items = $data->items();

                return $items[0]->getId() == $banner->getId();
            });
    }

    public function test_search_without_results(): void
    {
        DB::transaction(function () {
            for ($i = 0; $i < 10; $i++) {
                $banner = new FullBanner([
                    'title' => $this->faker->name(),
                    'link' => $this->faker->url(),
                    'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
                    'position' => $i + 1
                ]);

                $banner->save();
            }
        });

        $response = $this->get("/painel/fullbanners/listar?search=invalid");

        $response
            ->assertOk()
            ->assertViewHas('response', fn(LengthAwarePaginator $data) => empty($data->items()));
    }
}
