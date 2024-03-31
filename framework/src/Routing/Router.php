<?php

namespace Framework\Routing;

use FastRoute\Dispatcher;
use Framework\Http\Request;

use FastRoute\RouteCollector;
use League\Container\Container;

use function FastRoute\simpleDispatcher;
use Framework\Http\Exceptions\RouteNotFoundException;
use Framework\Http\Exceptions\MethodNotAllowedException;
use Framework\Http\Exceptions\UnknownControllerOrActionException;

class Router implements RouterInterface
{
    private array $routes = [];
    
    public function dispatch(Request $request, Container $container): array
    {
        [$handler, $params] = $this->extractRouteInfo($request);
        
        if (is_array($handler)) {
            [$controllerId, $action] = $handler;
           
            $controller = $container->get($controllerId); 

            if (method_exists($controller, $action)) {           
                return [[$controller, $action], $params];
            } else {
                $exception = new UnknownControllerOrActionException("Uknown controller {$controller} or action {$action} invoked");
                $exception->setStatusCode(404);
                throw $exception;
            }
        } 

        return [$handler, $params];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) { 
            foreach($this->routes as $route) {
                $routeCollector->addRoute( ...$route);
            }
        }); 
        
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getSanitizedServerUri()
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowed_methods = implode(', ', $routeInfo[1]);
                
                $exception = new MethodNotAllowedException("These methods are only allowed: [{$allowed_methods}]");
                $exception->setStatusCode(405);
                throw $exception; 
            case Dispatcher::NOT_FOUND:
                $exception = new RouteNotFoundException("Route {$request->getSanitizedServerUri()} not found");
                $exception->setStatusCode(404);
                throw $exception;
            default:
                return [];
        }
    }

    public function registerRoutes(array $routes): void
    {
        $this->routes = $routes;
    }
}