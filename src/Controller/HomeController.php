<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use App\Repository\SuperHeroRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        MissionRepository $missionRepository,
        SuperHeroRepository $heroRepository,
        TeamRepository $teamRepository
    ): Response {
        $now = new \DateTime();

        $activeMissions = $missionRepository->createQueryBuilder('m')
            ->where('m.startAt <= :now')
            ->andWhere('m.endAt >= :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->getResult();

        $availableHeroes = $heroRepository->findBy(['isAvailable' => true]);
        $unavailableHeroes = $heroRepository->findBy(['isAvailable' => false]);

        $teams = $teamRepository->findAll();

        return $this->render('home/index.html.twig', [
            'active_missions' => $activeMissions,
            'available_heroes' => $availableHeroes,
            'unavailable_heroes' => $unavailableHeroes,
            'teams' => $teams,
            'missions_count' => count($activeMissions),
            'heroes_count' => count($availableHeroes) + count($unavailableHeroes),
            'teams_count' => count($teams),
        ]);
    }
}
