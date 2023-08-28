<?php
// TODO: удалить лишние комменты по всему проекту
// src/EventListener/SearchIndexer.php
namespace App\EventListener;

// TODO: объединение юзов. App\Entity\{Guser, Payment ...}
use App\Entity\Guest;
use App\Entity\Payment;
use App\Entity\Receipt;
use App\Entity\User;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

// TODO: ошибка в названии класса и названии файла
class SearchIndexer
{
    public function __construct(
        private readonly Security               $security,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    // методы слушателя получают аргумент, который дает вам доступ и к
    // сущности объекта события, и к сущности самого менеджера
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // если этот слушатель применяется только к определенным типам сущностей,
        // добавьте код для проверки сущности как можно раньше
        // TODO: вместо проверки каждой сущности сделать AuthorInterface, который будут имплементить сущности, которым нужно
        // записывать автора при создании
        if ($entity instanceof Product or $entity instanceof Payment
        or $entity instanceof Receipt or $entity instanceof Guest) {
            $user = $this->security->getUser();
            if ($user instanceof User) {
                $entity->setAuthor($user);
            }
        }

        $this->entityManager->flush();
    }
}
