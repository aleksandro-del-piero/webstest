<?php

namespace App\Http\Middleware;

use App\Http\Response\Response;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiResponseMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $response = $next($request);

            if ($response->exception) {
                throw $response->exception;
            }

            return $response;
        } catch (ModelNotFoundException) {
            return Response::notFound();
        } catch (ValidationException $e) {
            return Response::unprocessableEntity(['errors' => $e->errors()], message: $e->getMessage());
        } catch (AuthenticationException $e) {
            return Response::unauthorized(message: $e->getMessage());
        } catch (HttpExceptionInterface $e) {
            return Response::error(status: $e->getStatusCode());
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
