<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostTranslation;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PostRepository
{
    private Post $model;
    private PostTranslation $postTranslation;

    /**
     * @param Post $post
     * @param PostTranslation $postTranslation
     */
    public function __construct(Post $post, PostTranslation $postTranslation)
    {
        $this->model = $post;
        $this->postTranslation = $postTranslation;
    }

    /**
     * @param $perPage
     * @param $pageNumber
     * @return Collection
     */
    public function all($perPage = null, $pageNumber = null): Collection
    {
        $query = $this->model->translated();

        if ($perPage !== null && $pageNumber !== null) {
            return $query->paginate($perPage, ['*'], 'page', $pageNumber);
        }

        return $query->get();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): Model|null
    {
        return $this->model->translated()->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @return Model|null
     * @throws Exception
     */
    public function create(array $data): ?Model
    {
        $post = $this->model->create();
        $post->save();

        $postData = [
            'post_id' => $post->id,
            'language_id' => getLanguageId()
        ];

        $data = array_merge($data, $postData);

        $this->postTranslation->create($data);

        return $this->find($post->id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function update(int $id, array $data): ?Model
    {
        $post = $this->find($id);

        $post->translations()->update($data);

        $post->save();

        return $post;
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function remove(int $id): ?bool
    {
        return $this->find($id)->delete();
    }

    /**
     * @param string $value
     * @return Collection
     */
    public function getFilteredPosts(string $value): Collection
    {
        $query = $this->model->translated();

        if ($value) {
            $query->where(function ($query) use ($value) {
                $query->whereHas('translations', function ($translationQuery) use ($value) {
                    $translationQuery->where('title', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%')
                        ->orWhere('content', 'like', '%' . $value . '%');
                });
            });
        }

        return $query->get();
    }
}
