<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Form\MissionAssignType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/missions')]
class MissionsController extends AbstractController
{
    #[Route('/', name: 'app_missions_index', methods: ['GET'])]
    public function index(MissionRepository $missionRepository): Response
    {
        return $this->render('missions/index.html.twig', [
            'missions' => $missionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_missions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('app_missions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('missions/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_missions_delete', methods: ['POST'])]
    public function delete(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mission->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_missions_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/mission/{id}/assign', name: 'app_mission_assign')]
    public function assign(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionAssignType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mission);
            $entityManager->flush();

            $this->addFlash('success', 'La mission a été assignée avec succès.');
            return $this->redirectToRoute('app_mission_show', ['id' => $mission->getId()]);
        }

        return $this->render('missions/assign.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_missions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_missions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('missions/edit.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_missions_show', methods: ['GET'])]
    public function show(Mission $mission): Response
    {
        return $this->render('missions/show.html.twig', [
            'mission' => $mission,
        ]);
    }
}
