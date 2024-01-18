<?php

namespace App\Repositories;

use App\Models\Tag;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TagRepository
{
    private Tag $model;

    /**
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * @param $perPage
     * @param $pageNumber
     * @return Collection
     * @throws Exception
     */
    public function all($perPage = null, $pageNumber = null): Collection
    {
        $query = $this->model->whereHas('posts.translations', function ($query) {
            $query->where('language_id', getLanguageId());
        });

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
        return $this->model->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function update(int $id, array $data): ?Model
    {
        $tag = $this->find($id);
        $tag->update($data);

        return $tag;
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function remove(int $id): ?bool
    {
        return $this->find($id)->delete();
    }
}
