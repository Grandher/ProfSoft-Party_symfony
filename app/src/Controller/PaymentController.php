<?php

// src/Controller/PaymentController.php
namespace App\Controller;

// ...
use App\Entity\Payment;
use App\Form\PaymentFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class PaymentController extends AbstractController
{
    #[Route('/payments', name: 'payment_list')]
    public function listPayments(ManagerRegistry $doctrine): Response
    {
        $payments = $doctrine->getRepository(Payment::class)->findAll();

        return $this->render('payment/index.html.twig', [
            'payments' => $payments,
        ]);
    }
    #[Route('/payment/new', name: 'new_payment')]
    public function newPayment(Request $request, ManagerRegistry $doctrine): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentFormType::class, $payment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('payment_list');
        }

        return $this->render('payment/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Добавить платеж',
        ]);
    }
    #[Route('/payment/{id}/edit', name: 'edit_payment')]
    #[IsGranted('ROLE_ADMIN')]
    public function editPayment(Request $request, Payment $payment, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PaymentFormType::class, $payment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('payment_list');
        }
        return $this->render('payment/edit.html.twig', [
            'form' => $form,
            'title' => 'Редактировать платеж',
        ]);
    }
    #[Route('/payment/{id}/delete', name: 'delete_payment')]
    #[IsGranted('ROLE_ADMIN')]
    public function deletePayment(Payment $payment, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($payment);
        $entityManager->flush();

        return $this->redirectToRoute('payment_list');
    }
}