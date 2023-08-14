<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function listUsers(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        return $this->render('users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/giveAdmin', name: 'give_admin')]
    public function giveAdmin(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $userRepository = $entityManager->getRepository(User::class);

        $user = $userRepository->find($this->getUser());

        if ($user) {
            $adminRole = ['ROLE_ADMIN'];
            $user->setRoles($adminRole);

            $entityManager->flush();
        }

        return $this->redirectToRoute('user_list');
    }
}
