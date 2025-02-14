<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EmployeController extends AbstractController
{

    public function __construct(

        private EntityManagerInterface $entityManager,
    ) {}

    #[Route('/employe', name: 'app_employe_index', methods: ['GET'])]
    public function index(Request $request, EmployeRepository $repository): Response
    {
        $employes = $repository->findAll();
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'Employe',
            'employes' => $employes
        ]);
    }

    // #[Route('/{id}', name: 'app_employe_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    // public function show(?Employe $employe): Response
    // {
    //     return $this->render('employe/show.html.twig', [
    //         'employe' => $employe,
    //     ]);
    // }

    #[Route('/{id}/employe/supprimer', name: 'app_employe_remove', requirements: ['id' => '\d+'],  methods: ['GET', 'POST'])]
    public function remove(?Employe $employe): Response
    {
        $this->entityManager->remove($employe);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_employe_index');
    }


    #[Route('employe/new', name: 'app_employe_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/employe/edit', name: 'app_employe_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Employe $employe, Request $request, EntityManagerInterface $manager): Response
    {
        $employe ??= new Employe();
        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($employe);
            $manager->flush();

            return $this->redirectToRoute('app_employe_index');
        }
        return $this->render('employe/new.html.twig', [
            'controller_name' => 'Employe',
            'form' => $form,
            'employe' => $employe
        ]);
    }
}
