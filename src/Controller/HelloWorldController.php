<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloWorldController extends AbstractController
{
    /**
     * @Route("/hello_world", name="hello_world")
     */
    public function index()
    {
        return $this->render('hello_world.html.twig', [
            'controller_name' => 'HelloWorldController',
        ]);
    }
}
