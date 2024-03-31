<?php

namespace Framework\Http;

use Framework\Routing\Router;
use Framework\Http\{Request, Response};
use Framework\Http\Exceptions\HttpException;


class Kernel
{
    
    public function __construct(
        private Router $router
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            [$handler, $params] = $this->router->dispatch($request);

            return call_user_func_array($handler, $params);
        } 
        catch (HttpException $e) {
            return new Response($e->getMessage(), $e->getStatusCode()); 
        } 
        catch (\Throwable $e) {
            return new Response($e->getMessage(), 500);
        }            
    }
}