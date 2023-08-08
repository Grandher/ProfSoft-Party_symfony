<?php

// src/Controller/ReceiptController.php
namespace App\Controller;

// ...
use App\Entity\Receipt;
use App\Form\ReceiptFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class ReceiptController extends AbstractController
{
    #[Route('/receipts', name: 'receipt_list')]
    public function listReceipts(ManagerRegistry $doctrine): Response
    {
        $receipts = $doctrine->getRepository(Receipt::class)->findAll();

        return $this->render('receipt/index.html.twig', [
            'receipts' => $receipts,
        ]);
    }
    #[Route('/receipt/new', name: 'new_receipt')]
    public function newReceipt(Request $request, ManagerRegistry $doctrine): Response
    {
        $receipt = new Receipt();
        $form = $this->createForm(ReceiptFormType::class, $receipt);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($receipt);
            $entityManager->flush();

            return $this->redirectToRoute('receipt_list');
        }

        return $this->render('receipt/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Добавить чек',
        ]);
    }
    #[Route('/receipt/{id}/edit', name: 'edit_receipt')]
    #[IsGranted('ROLE_ADMIN')]
    public function editReceipt(Request $request, Receipt $receipt, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ReceiptFormType::class, $receipt);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('receipt_list');
        }
        return $this->render('receipt/edit.html.twig', [
            'form' => $form,
            'title' => 'Редактировать чек',
        ]);
    }
    #[Route('/receipt/{id}/delete', name: 'delete_receipt')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteReceipt(Receipt $receipt, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($receipt);
        $entityManager->flush();

        return $this->redirectToRoute('receipt_list');
    }
}