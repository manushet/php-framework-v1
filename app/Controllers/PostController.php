<?php

namespace App\Controllers;

use Framework\Http\Response;

class PostController extends Controller
{
    public function show(int $id): Response
    {        
        $content = "<h2>Post Controller : show post #{$id} content</h2>";

        return new Response($content, 200, []);
    }
}