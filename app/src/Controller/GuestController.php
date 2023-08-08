<?php

// src/Controller/GuestController.php
namespace App\Controller;

// ...
use App\Entity\Guest;
use App\Form\GuestFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class GuestController extends AbstractController
{
    #[Route('/guests', name: 'guest_list')]
    public function listGuests(ManagerRegistry $doctrine): Response
    {
        $guests = $doctrine->getRepository(Guest::class)->findAll();

        return $this->render('guest/index.html.twig', [
            'guests' => $guests,
        ]);
    }
    #[Route('/guest/new', name: 'new_guest')]
    public function newGuest(Request $request, ManagerRegistry $doctrine): Response
    {
        $guest = new Guest();
        $form = $this->createForm(GuestFormType::class, $guest);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($guest);
            $entityManager->flush();

            return $this->redirectToRoute('guest_list');
        }

        return $this->render('guest/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Добавить гостя',
        ]);
    }
    #[Route('/guest/{id}/edit', name: 'edit_guest')]
    #[IsGranted('ROLE_ADMIN')]
    public function editGuest(Request $request, Guest $guest, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(GuestFormType::class, $guest);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('guest_list');
        }
        return $this->render('guest/edit.html.twig', [
            'form' => $form,
            'title' => 'Редактировать гостя',
        ]);
    }
    #[Route('/guest/{id}/delete', name: 'delete_guest')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteGuest(Guest $guest, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($guest);
        $entityManager->flush();

        return $this->redirectToRoute('guest_list');
    }
}