<?php

use Framework\Controller\AbstractController;
use Framework\Http\Kernel;
use Framework\Routing\Router;
use League\Container\Container;
use Symfony\Component\Dotenv\Dotenv;
use Framework\Routing\RouterInterface;
use League\Container\ReflectionContainer;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$viewsPath = BASE_PATH . '/views';

$container = new Container();

$container->delegate(new ReflectionContainer());

// Service Parameters

$dotenv = new Dotenv();

$dotenv->load(BASE_PATH . '/.env');

$appMode = getenv('APP_MODE') ?? 'dev';
$container->add('APP_MODE', new StringArgument($appMode));

$databaseUrl = getenv('DATABASE_URL');

$routes = require_once(BASE_PATH . '/routes/web.php');

// Services

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$container->addShared('twig-loader', FilesystemLoader::class)->addArgument(new StringArgument($viewsPath));

$container->addShared('twig', Environment::class)->addArgument('twig-loader');

$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);

return $container;