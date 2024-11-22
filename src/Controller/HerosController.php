<?php

namespace App\Controller;

use App\Entity\SuperHero;
use App\Entity\Power;
use App\Form\SuperHeroType;
use App\Repository\SuperHeroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/heros')]
class HerosController extends AbstractController
{
    #[Route('/', name: 'app_heros_index', methods: ['GET'])]
    public function index(Request $request, SuperHeroRepository $heroRepository): Response
    {
        $availability = $request->query->get('availability');
        $energyLevel = $request->query->get('energyLevel');

        $queryBuilder = $heroRepository->createQueryBuilder('h');

        if ($availability !== null) {
            $queryBuilder->andWhere('h.isAvailable = :availability')
                ->setParameter('availability', $availability);
        }

        if ($energyLevel !== null) {
            $queryBuilder->andWhere('h.energyLevel >= :energyLevel')
                ->setParameter('energyLevel', $energyLevel);
        }

        $heroes = $queryBuilder->getQuery()->getResult();

        return $this->render('heros/index.html.twig', [
            'heroes' => $heroes,
        ]);
    }

    #[Route('/new', name: 'app_heros_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $hero = new SuperHero();
        $form = $this->createForm(SuperHeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('heroes_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $hero->setImageName($newFilename);
            }

            $newPower = $form->get('newPower')->getData();
            if ($newPower) {
                $entityManager->persist($newPower);
                $hero->addPower($newPower);
            }

            $entityManager->persist($hero);
            $entityManager->flush();

            return $this->redirectToRoute('app_heros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('heros/new.html.twig', [
            'hero' => $hero,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_heros_show', methods: ['GET'])]
    public function show(SuperHero $hero): Response
    {
        return $this->render('heros/show.html.twig', [
            'hero' => $hero,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_heros_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SuperHero $hero, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(SuperHeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('heroes_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $hero->setImageName($newFilename);
            }

            $newPower = $form->get('newPower')->getData();
            if ($newPower) {
                $entityManager->persist($newPower);
                $hero->addPower($newPower);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_heros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('heros/edit.html.twig', [
            'hero' => $hero,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_heros_delete', methods: ['POST'])]
    public function delete(Request $request, SuperHero $hero, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $hero->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hero);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_heros_index', [], Response::HTTP_SEE_OTHER);
    }
}
