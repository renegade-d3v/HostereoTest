<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;

class TagTest extends TestCase
{

    /**
     * @return void
     */
    public function testIndexWithPagination(): void
    {
        Tag::factory(50)->create();

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('GET', '/api/tags', ['per_page' => 5, 'page' => 1]);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testIndexWithoutPagination(): void
    {
        Tag::factory(50)->create();

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('GET', '/api/tags');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testShowTag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('GET', '/api/tags/' . $tag->id);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdateTag(): void
    {
        $tag = Tag::factory()->create();

        $newData = ['name' => 'NewTagName'];

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('PUT', '/api/tags/' . $tag->id, $newData);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testDeleteTag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->withHeaders(['Content-Language' => 'ua'])
            ->json('DELETE', '/api/tags/' . $tag->id);

        $response->assertStatus(200);
        $this->assertSoftDeleted($tag);
    }
}
