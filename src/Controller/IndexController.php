<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class IndexController extends MyBaseController
{
    /**
     * @Route("/", name="home", methods="GET")
     */
    public function index(): Response
    {

        return $this->render('index.html.twig'); 

     }
	
}
