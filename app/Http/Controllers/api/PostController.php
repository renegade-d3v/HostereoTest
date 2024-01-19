<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Iterators\PostSearchIterator;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostRepository $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $posts = $this->postRepository->all($request->get('per_page'), $request->get('page'));

        return response()->json($posts);
    }

    /**
     * @param CreatePostRequest $request
     * @return JsonResponse
     */
    public function store(CreatePostRequest $request): JsonResponse
    {
        try {
            $post = $this->postRepository->create($request->validated());

            return response()->json($post, 201);
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $post = $this->postRepository->find($id);

            if (!$post) {
                return response()->json([], 404);
            }

            return response()->json($post);
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $post = $this->postRepository->update($id, $request->all());

            if (!$post) {
                return response()->json([], 404);
            }

            return response()->json();
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->postRepository->remove($id);

            if (!$deleted) {
                return response()->json([], 404);
            }

            return response()->json();
        } catch (Exception $e) {
            return response()->json([], 500);
        }
    }

    /**
     * @param string $value
     * @return JsonResponse
     */
    public function search(string $value): JsonResponse
    {
        $posts = $this->postRepository->getFilteredPosts($value);
        $iterator = new PostSearchIterator($posts);

        return response()->json($iterator);
    }
}
