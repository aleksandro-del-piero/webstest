<?php

use App\Http\Controllers\Api\V1\Auth\PersonalAccessTokenController;
use App\Http\Controllers\Api\V1\NewsCommentController;
use Illuminate\Support\Facades\Route;

/**
 * @apiDefine NotFoundError
 *            404 Not Found
 *
 * @apiError (NotFoundError) {Object} data Data
 * @apiError (NotFoundError) {String} message Error description
 * @apiError (NotFoundError) {Boolean} success Success status
 */

/**
 * @apiDefine AuthirizationError
 *            401 Unauthorized
 *
 * @apiHeader {String="Bearer :token"} Authorization Replace <code>:token</code> with supplied Auth Token
 *
 * @apiError (AuthirizationError) {String} message Error description
 */

/**
 * @apiDefine ValidationError
 *            422 Unprocessable Entity
 *
 * @apiError (ValidationError) {Boolean} success Always `false`
 * @apiError (ValidationError) {String} message Error message
 * @apiError (ValidationError) {Object} data Container for the validation errors
 * @apiError (ValidationError) {Object} data.errors Object with fields and their validation errors
 * @apiError (ValidationError) {String[]} [data.errors.:field] Array of error messages for a specific field
 *
 */

/**
 * @apiDefine ThrottleError
 *            429 Too Many Requests
 *
 * @apiError (ThrottleError) {String} message Throttle message
 */

/**
 * @api {get} /sanctum/csrf-cookie Get CSRF-TOKEN
 *
 * @apiGroup Auth
 *
 */

Route::prefix('v1')->group(function () {
    /**
     * @api {post} /v1/personal-access-tokens Create new auth bearer token
     *
     * @apiGroup Auth
     *
     * @apiBody {String} email Email
     * @apiBody {String} password Password
     *
     * @apiSuccess {Object} data Response data
     * @apiSuccess {String} data.token Token
     * @apiSuccess {String} message
     * @apiSuccess {Boolean} success
     *
     * @apiUse ValidationError
     */
    Route::post('personal-access-tokens', [PersonalAccessTokenController::class, 'store']);

    /**
     * @api {get} /v1/news/:news/comments Comments list for selected news
     *
     * @apiGroup Comments
     *
     * @apiParam {news} Unique news identifier
     *
     * @apiHeader {String} Authorization Bearer token для авторизации
     *
     * @apiQuery {Number} [user_id] User id (optional)
     * @apiQuery {Number} [text] Text for search (optional)
     * @apiQuery {Number} [limit] The number of items per page (optional). Default limit=5, max=20
     * @apiQuery {Number} [page] Page (optional). Default page=1
     *
     * @apiSuccess {Object[]} data
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.comment
     * @apiSuccess {Object} data.user
     * @apiSuccess {Number} data.user.id
     * @apiSuccess {String} data.user.name
     * @apiSuccess {String} data.user.email
     * @apiSuccess {String} data.published_at
     * @apiSuccess {Number} data.rating
     *
     * @apiSuccess {Object} paginator Pagination data
     * @apiSuccess {Number} paginator.per_page Number of items per page
     * @apiSuccess {Number} paginator.current_page Current page
     * @apiSuccess {Number} paginator.last_page Last page
     * @apiSuccess {Number} paginator.total Total number of items
     * @apiSuccess {Boolean} paginator.has_more Are there more pages
     *
     * @apiSuccess {Boolean} success
     * @apiSuccess {String} message
     *
     * @apiUse NotFoundError
     */

    /**
     * @api {get} /v1/news/:news/comments/:comment Show comment details
     *
     * @apiGroup Comments
     *
     * @apiParam {Number} news Unique news identifier
     * @apiParam {Number} comment Unique comment identifier
     *
     * @apiHeader {String} Authorization Bearer token для авторизации
     *
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.comment
     * @apiSuccess {Object} data.user
     * @apiSuccess {Number} data.user.id
     * @apiSuccess {String} data.user.name
     * @apiSuccess {String} data.user.email
     * @apiSuccess {String} data.published_at
     * @apiSuccess {Number} data.rating
     *
     * @apiSuccess {Boolean} success
     * @apiSuccess {String} message
     *
     * @apiUse NotFoundError
     */

    /**
     * @api {post} /v1/news/:news/comments Create new comment
     *
     * @apiGroup Comments
     *
     * @apiParam {news} unique news identifier
     *
     * @apiBody {String} comment
     *
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id
     * @apiSuccess {String} data.comment
     * @apiSuccess {Object} data.user
     * @apiSuccess {Number} data.user.id
     * @apiSuccess {String} data.user.name
     * @apiSuccess {String} data.user.email
     * @apiSuccess {String} data.published_at
     * @apiSuccess {Number} data.rating
     *
     * @apiSuccess {Boolean} success
     * @apiSuccess {String} message
     *
     * @apiUse ValidationError
     * @apiUse NotFoundError
     */

    /**
     * @api {put} /v1/news/:news/comments/:comment Update comment
     *
     * @apiGroup Comments
     *
     * @apiParam {Number} news Unique news identifier
     * @apiParam {Number} comment Unique comment identifier
     *
     * @apiBody {String} comment
     *
     * @apiSuccess {Object} data
     *
     * @apiSuccess {Boolean} success
     * @apiSuccess {String} message
     *
     * @apiUse ValidationError
     * @apiUse NotFoundError
     */

    /**
     * @api {delete} /v1/news/:news/comments/:comment Delete comment
     *
     * @apiGroup Comments
     *
     * @apiParam {Number} news Unique news identifier
     * @apiParam {Number} comment Unique comment identifier
     *
     * @apiSuccess {Object} data
     *
     * @apiSuccess {Boolean} success
     * @apiSuccess {String} message
     *
     * @apiUse NotFoundError
     */
    Route::middleware(['auth.token_or_session'])->group(function () {
        Route::apiResource('news.comments', NewsCommentController::class)
            ->scoped();

        /**
         * @api {delete} /v1/personal-access-tokens Logout user. Delete token.
         *
         * @apiGroup Auth
         *
         * @apiSuccess {Object} data Response data
         * @apiSuccess {String} message
         * @apiSuccess {Boolean} success
         *
         */
        Route::delete('personal-access-tokens', [PersonalAccessTokenController::class, 'destroy']);
    });

    Route::get('test', function () {
        event(new \App\Events\MyEvent('hello world'));
        return response()->json(['event' => 'hello world']);
    });
});
