<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\CommentCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Comment\CommentRequest;
use App\Http\Requests\Api\V1\Comment\IndexRequest;
use App\Http\Resources\Api\V1\Comment\CommentResource;
use App\Http\Response\Response;
use App\Http\Transformers\Api\V1\CommentTransformer;
use App\Models\Comment;
use App\Models\News;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Gate;

class NewsCommentController extends Controller
{
    /**
     * Show comments for selected news
     *
     * @param IndexRequest $request
     * @param CommentRepository $commentRepository
     * @param CommentTransformer $commentTransformer
     * @param News $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        IndexRequest       $request,
        CommentRepository  $commentRepository,
        CommentTransformer $commentTransformer,
        News               $news
    )
    {
        return Response::paginator(
            $commentTransformer->handle(
                $commentRepository->get(
                    $request->getDto()
                )
            )
        );
    }

    /**
     * Create new comment for news
     *
     * @param CommentRequest $request
     * @param CommentRepository $commentRepository
     * @param News $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentRequest $request, CommentRepository $commentRepository, News $news)
    {
        $comment = $commentRepository->create($request->getDto());

        event(new CommentCreated($comment));

        return Response::created(CommentResource::make($comment)->toArray(request()));
    }

    /**
     * Show comment details
     *
     * @param News $news
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(News $news, Comment $comment)
    {
        if (!$comment->isPublished()) {
            Response::notFound();
        }

        return Response::success(CommentResource::make($comment)->toArray(request()));
    }

    /**
     * Update comment
     *
     * @param CommentRepository $commentRepository
     * @param CommentRequest $request
     * @param News $news
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CommentRepository $commentRepository, CommentRequest $request, News $news, Comment $comment)
    {
        if (Gate::denies('update', $comment)) {
            return Response::forbidden();
        }

        $commentRepository->update($comment, $request->getDto());

        return Response::noContent();
    }

    /**
     * Delete selected comment
     *
     * @param CommentRepository $commentRepository
     * @param News $news
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CommentRepository $commentRepository, News $news, Comment $comment)
    {
        if (Gate::denies('delete', $comment)) {
            return Response::forbidden();
        }

        $commentRepository->delete($comment);

        return Response::noContent();
    }
}
