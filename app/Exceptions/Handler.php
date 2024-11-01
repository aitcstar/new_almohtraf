<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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

    public function render($request, Throwable $exception)
    {
        //dd($exception->getMessage() );

        // تحقق من أن الخطأ هو 404
        if ($exception instanceof NotFoundHttpException) {
            // عرض صفحة 404 المخصصة
            if($exception->getMessage() == "Unauthenticated."){
                return view('frontend.auth.login-client');
            }else{
                return response()->view('frontend.errors.errors', [], 404);

            }
        }

        // الرجوع إلى السلوك الافتراضي للأخطاء الأخرى
         //return response()->view('frontend.errors.errors', [], 404);
        return parent::render($request, $exception);
    }
}
