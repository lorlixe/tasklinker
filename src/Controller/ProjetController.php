<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    #[Route('/', name: 'app_projet')]
    public function index(Request $request, ProjetRepository $repository): Response
    {
        $projets = $repository->findAll();
        return $this->render('projet/index.html.twig', [
            'controller_name' => 'Projet',
            'projets' => $projets
        ]);
    }


    #[Route('/{id}', name: 'app_projet_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Projet $projet): Response
    {

        return $this->forward('App\Controller\TacheController::index');
    }

    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_projet_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Projet $projet, Request $request, EntityManagerInterface $manager): Response
    {
        $projet ??= new Projet();
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($projet);
            $manager->flush();

            return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
        }
        return $this->render('projet/new.html.twig', [
            'controller_name' => 'Projet',
            'form' => $form,
        ]);
    }
}
