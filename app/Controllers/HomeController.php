<?php

namespace App\Controllers;

use Framework\Http\Response;
use Framework\Controller\AbstractController;


class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render("home.html.twig", [
            "youtubeChannel" => '@youtubeChannelLink'
        ]) ;
    } 
}