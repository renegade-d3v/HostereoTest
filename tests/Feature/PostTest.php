<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostTranslation;
use Tests\TestCase;

class PostTest extends TestCase
{

    /**
     * @return void
     */
    public function testIndexWithPagination(): void
    {
        Post::factory(50)->create();
        PostTranslation::factory(50)->create();

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('GET', '/api/posts', ['per_page' => 5, 'page' => 1]);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testIndexWithoutPagination(): void
    {
        Post::factory(5)->create();
        PostTranslation::factory(25)->create();

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('GET', '/api/posts');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testShowPost(): void
    {
        $post = Post::factory()->create();
        PostTranslation::factory()->create(['post_id' => $post->id, 'language_id' => 1]);

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('GET', '/api/posts/' . $post->id);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdatePost(): void
    {
        $post = Post::factory()->create();
        PostTranslation::factory()->create(['post_id' => $post->id, 'language_id' => 1]);

        $newData = ['title' => 'Updated Title'];

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('PUT', '/api/posts/' . $post->id, $newData);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testDeletePost(): void
    {
        $post = Post::factory()->create();
        PostTranslation::factory()->create(['post_id' => $post->id, 'language_id' => 1]);

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('DELETE', '/api/posts/' . $post->id);

        $response->assertStatus(200);
        $this->assertSoftDeleted($post);
    }

    /**
     * @return void
     */
    public function testSearchMethod(): void
    {
        Post::factory(50)->create();

        $value = 'Aut';
        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('GET', '/api/posts/search/'. $value);

        $response->assertStatus(200);
    }
}
