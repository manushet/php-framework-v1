<?php

namespace App\Controllers;

use Framework\Http\Response;
use Framework\Controller\AbstractController;

class PostController extends AbstractController
{
    public function show(int $id): Response
    {        
        return $this->render("post.html.twig", [
                "postID" => $id
            ]) ;
    }

    public function create(/*array $post*/): Response
    {      
        return $this->render("create-post.html.twig") ;  
    }
}