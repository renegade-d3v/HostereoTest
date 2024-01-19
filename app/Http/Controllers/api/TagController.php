<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use App\Repositories\TagRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagRepository $tagRepository;

    public function __construct(TagRepository $repository)
    {
        $this->tagRepository = $repository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $posts = $this->tagRepository->all($request->get('per_page'), $request->get('page'));

        return response()->json($posts);
    }

    /**
     * @param TagRequest $request
     * @return JsonResponse
     */
    public function store(TagRequest $request): JsonResponse
    {
        try {
            $post = $this->tagRepository->create($request->validated());

            return response()->json($post, 201);
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $tag = $this->tagRepository->find($id);

            if (!$tag) {
                return response()->json([], 404);
            }

            return response()->json($tag);
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }

    /**
     * @param TagRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(TagRequest $request, string $id): JsonResponse
    {
        try {
            $tag = $this->tagRepository->update($id, $request->validated());

            if (!$tag) {
                return response()->json([], 404);
            }

            return response()->json();
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $deleted = $this->tagRepository->remove($id);

            if (!$deleted) {
                return response()->json([], 404);
            }

            return response()->json();
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }
}
