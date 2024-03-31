<?php

namespace App\Controllers;

use Framework\Http\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $content = '<h2>Home Controller : index page</h2>';

        return new Response($content, 200, []);
    } 
}