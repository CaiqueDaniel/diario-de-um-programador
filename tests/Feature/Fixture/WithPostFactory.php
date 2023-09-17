<?php

namespace Tests\Feature\Fixture;

use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;

trait WithPostFactory
{
    use WithFaker;

    public function factoryPost(): Post
    {
        $post = new Post([
            'title' => $this->faker->text(20),
            'subtitle' => $this->faker->text(),
            'article' => $this->faker->text()
        ]);

        return $post
            ->setThumbnail(UploadedFile::fake()->create($this->faker->name() . '.jpg'))
            ->setPermalink($post->getTitle());
    }
}
