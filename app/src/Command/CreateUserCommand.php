<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Создание нового пользователя',
)]
class CreateUserCommand extends Command
{
    private UserPasswordHasherInterface $passwordEncoder;
    private ManagerRegistry $doctrine;

    public function __construct(UserPasswordHasherInterface $passwordEncoder, ManagerRegistry $doctrine)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::OPTIONAL, 'Имя пользователя')
            ->addArgument('password', InputArgument::OPTIONAL, 'Пароль')
            ->addOption('admin', null, InputOption::VALUE_NONE, 'Роль')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');

        $entityManager = $this->doctrine->getManager();

        $user = new User();
        $user->setUsername($username);

        $hashedPassword = $this->passwordEncoder->hashPassword($user, $input->getArgument('password'));
        $user->setPassword($hashedPassword);

        if ($input->getOption('admin')) {
            $user->setRoles(['ROLE_ADMIN']);
        } else {
            $user->setRoles(['ROLE_USER']);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        $io->success("Пользователь $username создан");

        return Command::SUCCESS;
    }
}
