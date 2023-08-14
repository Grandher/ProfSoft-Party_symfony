<?php
// src/EventListener/SearchIndexer.php
namespace App\EventListener;

use App\Entity\Guest;
use App\Entity\Payment;
use App\Entity\Receipt;
use App\Entity\User;
use App\Entity\Product;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

class SearchIndexer
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    // методы слушателя получают аргумент, который дает вам доступ и к
    // сущности объекта события, и к сущности самого менеджера
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // если этот слушатель применяется только к определенным типам сущностей,
        // добавьте код для проверки сущности как можно раньше
        if ($entity instanceof Product or $entity instanceof Payment
        or $entity instanceof Receipt or $entity instanceof Guest) {
            $user = $this->security->getUser();
            if ($user instanceof User) {
                $entity->setAuthor($user);
            }
        }

        $entityManager = $args->getObjectManager();
        $entityManager->flush();
    }

}