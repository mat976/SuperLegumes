<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/teams')]
class TeamsController extends AbstractController
{
    #[Route('/', name: 'app_teams_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('teams/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_teams_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teams/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_teams_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('teams/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_teams_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teams/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_teams_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
    }
}
