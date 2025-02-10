<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TacheController extends AbstractController
{
    public function __construct(

        private EntityManagerInterface $entityManager,
    ) {}

    #[Route('/tache', name: 'app_tache_index', methods: ['GET'])]
    public function index(Request $request, TacheRepository $repository): Response
    {
        $taches = $repository->findAll();
        return $this->render('projet/show.html.twig', [
            'controller_name' => 'Projet',
            'taches' => $taches
        ]);
    }


    #[Route('/{id}/supprimer', name: 'app_tache_remove', requirements: ['id' => '\d+'],  methods: ['GET', 'POST'])]
    public function remove(?Tache $tache): Response
    {
        $this->entityManager->remove($tache);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_tache_index');
    }


    #[Route('tache/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_tache_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Tache $tache, Request $request, EntityManagerInterface $manager): Response
    {
        $tache ??= new Tache();
        $form = $this->createForm(TacheType::class, $tache);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tache);
            $manager->flush();

            return $this->redirectToRoute('app_tache_show', ['id' => $tache->getId()]);
        }
        return $this->render('tache/new.html.twig', [
            'form' => $form,
        ]);
    }
}
