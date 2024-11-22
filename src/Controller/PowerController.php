<?php

namespace App\Controller;

use App\Entity\Power;
use App\Form\PowerType;
use App\Repository\PowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/power')]
class PowerController extends AbstractController
{
    #[Route('/new', name: 'app_power_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $power = new Power();
        $form = $this->createForm(PowerType::class, $power);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($power);
            $entityManager->flush();

            $this->addFlash('success', 'Le pouvoir a été créé avec succès.');
            return $this->redirectToRoute('app_power_index');
        }

        return $this->render('power/new.html.twig', [
            'power' => $power,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_power_index', methods: ['GET'])]
    public function index(PowerRepository $powerRepository): Response
    {
        return $this->render('power/index.html.twig', [
            'powers' => $powerRepository->findAll(),
        ]);
    }
}
