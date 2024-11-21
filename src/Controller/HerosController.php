<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HerosController extends AbstractController
{
    #[Route('/heros', name: 'app_heros')]
    public function index(): Response
    {
        return $this->render('heros/index.html.twig');
    }
}
