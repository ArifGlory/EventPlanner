<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Yajra\DataTables\Exceptions\Exception;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException && $request->wantsJson()) {
            return $this->responseApi(202, false, 'Data yang anda cari tidak ditemukan.');
        }
        if ($e instanceof NotFoundHttpException && $request->wantsJson()) {
            return $this->responseApi(404, false, 'Not found.');
        }
        if ($e instanceof AuthenticationException && $request->wantsJson()) {
            return $this->responseApi(401, false, 'Anda belum login.');
        }

        if ($request->wantsJson() && $e instanceof ValidationException) {
            return $this->responseApi(202, false, implode(',', collect($e->errors())->first()),env('APP_DEBUG') ? ['trace' => $e->getTrace()] : []);
        }

        if ($request->wantsJson() && $e instanceof AuthorizationException) {
            return $this->responseApi(202, false, 'Maaf anda  tidak memiliki akses ke url ini.', env('APP_DEBUG') ? ['message' => $e->getMessage(), 'trace' => $e->getTrace()] : []);
        }

        if ($request->wantsJson()) {
            return $this->responseApi(500, false, 'Server Error.',config('app.debug') ? ['message' => $e->getMessage(), 'trace' => $e->getTrace()] : []);
        }
        
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return redirect('/');
        }
        if ($e instanceof Exception) {
            return response([
                'draw'            => 0,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ],
                'error'           => 'Laravel Error Handler',
            ]);
        }

        return parent::render($request, $e);
    }
}
