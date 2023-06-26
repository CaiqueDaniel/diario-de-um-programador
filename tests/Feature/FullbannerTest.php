<?php

namespace Tests\Feature;

use App\Models\{FullBanner, User};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Interfaces\{CRUDTest, SoftDeleteTest};
use Tests\TestCase;

class FullbannerTest extends TestCase implements CRUDTest, SoftDeleteTest
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
        $response = $this->get('/painel/fullbanners/adicionar');

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.fullbanner.form');
    }

    public function test_creation(): void
    {
        $title = $this->faker->name();
        $link = $this->faker->url();
        $position = 1;

        $response = $this->post('/painel/fullbanners', [
            'title' => $title,
            'link' => $link,
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'position' => $position
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Fullbanner criado com sucesso');

        $this->assertDatabaseHas(FullBanner::class, ['title' => $title, 'link' => $link, 'postion' => $position]);

        /** @var FullBanner $banner */
        $banner = FullBanner::query()->where('title', 'like', $title)->first();

        $this->assertNotNull($banner->image);
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

        $response = $this->delete("/painel/fullbanners/{$banner->id}");

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Fullbanner excluído com sucesso');

        $this->assertDatabaseMissing(FullBanner::class, $banner->toArray());
    }

    public function test_update(): void
    {
        $banner = new FullBanner([
            'title' => $this->faker->name(),
            'link' => $this->faker->url(),
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'position' => 1
        ]);

        $banner->save();

        $this->assertDatabaseHas(FullBanner::class, $banner->toArray());

        $title = $this->faker->name();
        $link = $this->faker->url();
        $position = 2;

        $response = $this->put("/painel/fullbanners/{$banner->id}", [
            'title' => $title,
            'link' => $link,
            'image' => UploadedFile::fake()->create($this->faker->name() . '.jpg'),
            'position' => $position
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('message', 'Fullbanner alterado com sucesso');

        $this->assertDatabaseHas(FullBanner::class, ['title' => $title, 'link' => $link, 'postion' => $position]);

        /** @var FullBanner $banner */
        $banner = FullBanner::query()->where('title', 'like', $title)->first();

        $this->assertNotNull($banner->image);
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

        $this->assertDatabaseHas(FullBanner::class, $banner->toArray());

        $modelData = $banner->toArray();

        unset($modelData['deleted_at']);

        $this->patch("/painel/fullbanners/{$banner->id}/ativar")->assertOk();
        $this->assertDatabaseHas(FullBanner::class, $modelData);

        $banner = FullBanner::withoutTrashed()->find($banner->id);

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
        $this->patch("/painel/fullbanners/{$banner->id}/desativar")->assertOk();

        $banner = FullBanner::withTrashed()->find($banner->id);

        $this->assertTrue($banner->trashed());
    }
}
