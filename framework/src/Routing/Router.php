<?php

namespace Framework\Routing;

use FastRoute\Dispatcher;
use Framework\Http\Request;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

use Framework\Http\Exceptions\RouteNotFoundException;
use Framework\Http\Exceptions\MethodNotAllowedException;
use Framework\Http\Exceptions\UnknownControllerOrActionException;

class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        return $this->extractRouteInfo($request);
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) { 
            $routes = require_once(BASE_PATH . '/routes/web.php');
                
            foreach($routes as $route) {
                $routeCollector->addRoute( ...$route);
            }
        }); 
        
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getSanitizedServerUri()
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                if (is_array($routeInfo[1])) {
                    [$controller, $action] = $routeInfo[1];
        
                    if (method_exists($controller, $action)) {           
                        return [[new $controller(), $action], $routeInfo[2]];
                    } else {
                        $exception = new UnknownControllerOrActionException("Uknown controller {$controller} or action {$action} invoked");
                        $exception->setStatusCode(404);
                        throw $exception;
                    }
                } 
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
}