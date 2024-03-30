<?php

namespace Framework\Http;

use Framework\Http\{Request, Response};

class Kernel
{
    public function handle(Request $request): Response
    {
        $content = '<h2>Hello, World!</h2>';

        return new Response($content, 200, []);
    }
}