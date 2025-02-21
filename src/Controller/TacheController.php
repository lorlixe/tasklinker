<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\ProjetRepository;
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
    public function index(Request $request, TacheRepository $repository, Projet $projet): Response
    {
        $taches = [];
        $array = $repository->findAll();

        foreach ($array as $element) {
            if ($element->getProjet()->getId() === $projet->getId()) {
                $taches[] = $element;
            }
        }
        return $this->render('projet/show.html.twig', [
            'controller_name' => 'Projet',
            'taches' => $taches,
            'projet' => $projet
        ]);
    }



    #[Route('projet/{projet_id}/tache/{tache_id}/supprimer', name: 'app_tache_remove', requirements: ['id' => '\d+'],  methods: ['GET', 'POST'])]
    public function remove(?int $tache_id,  int $projet_id, EntityManagerInterface $manager): Response
    {
        $tache = $manager->getRepository(Tache::class)->find($tache_id);

        if (!$tache) {
            return $this->redirectToRoute('app_projet_show', [
                'id' => $projet_id,
            ]);
        }

        $this->entityManager->remove($tache);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_projet_show', [
            'id' => $projet_id,
        ]);
    }


    #[Route('projet/{projet_id}/tache/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
    #[Route('projet/{projet_id}/tache/{tache_id}/edit', name: 'app_tache_edit', requirements: ['tache_id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?int $tache_id, Request $request, EntityManagerInterface $manager, int $projet_id): Response
    {
        // Récupérer le projet à partir de l'ID
        $projet = $manager->getRepository(Projet::class)->find($projet_id);



        if (!$projet) {
            throw $this->createNotFoundException("Projet introuvable !");
        }

        // Si la tâche n'existe pas encore, on lui assigne le projet
        if ($tache_id) {
            $tache = $manager->getRepository(Tache::class)->find($tache_id);
        }
        $tache ??= new Tache();
        if (!$tache->getProjet()) {
            $tache->setProjet($projet);
        }

        // Créer le formulaire
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tache);
            $manager->flush();

            return $this->redirectToRoute('app_projet_show', [
                'id' => $projet->getId(),
            ]);
        }

        return $this->render('tache/new.html.twig', [
            'controller_name' => 'Tache',
            'form' => $form,
            'tache_id' => $tache->getId(),
            'projet_id' => $projet_id,

        ]);
    }
}
