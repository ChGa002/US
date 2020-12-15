<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class USController extends AbstractController
{
    /**
     * @Route("/u/s", name="u_s")
     */
    public function index(): Response
    {
        return $this->render('us/index.html.twig', [
            'controller_name' => 'USController',
        ]);
    }
}
