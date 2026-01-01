<?php

namespace App\Libraries;

use CodeIgniter\Debug\BaseExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class OAuthExceptionHandler extends BaseExceptionHandler implements ExceptionHandlerInterface
{
    protected ?string $viewPath = APPPATH . 'Views/errors/html/';

    public function handle(Throwable $exception, RequestInterface $request, ResponseInterface $response, int $statusCode, int $exitCode): void
    {
        $this->render($exception, $statusCode, $this->viewPath . "error_oauth.php");
    }
}