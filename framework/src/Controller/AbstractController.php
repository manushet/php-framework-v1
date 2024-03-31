<?php

namespace Framework\Controller;

use Framework\Http\Response;
use Twig\Environment;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container): void 
    {
        $this->container = $container;
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        /**
         * @var Environment $twig
         */
        $twig = $this->container->get('twig'); 

        $content = $twig->render($view, $parameters);

        $response ??= new Response(); 

        return $response->setContent($content);
    }
}