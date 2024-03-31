<?php

namespace Framework\Http;

use Framework\Routing\Router;
use League\Container\Container;
use Framework\Http\{Request, Response};
use Framework\Http\Exceptions\HttpException;


class Kernel
{

    private ?string $appMode = null; 
    
    public function __construct(
        private Router $router,
        private Container $container
    )
    {
        $this->appMode = $container->get('APP_MODE');
    }

    public function handle(Request $request): Response
    {
        try {
            [$handler, $params] = $this->router->dispatch($request, $this->container);

            return call_user_func_array($handler, $params);
        } 
        catch (HttpException $e) {
            return $this->createExceptionResponse($e); 
        }          
    }

    private function createExceptionResponse(\Exception $e): Response
    {        
        if (in_array($this->appMode, ['test', 'local', 'dev'])) {
            throw $e;
        }
        
        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        } 

        return new Response('An unexpected server error occured', 500);
    }
}