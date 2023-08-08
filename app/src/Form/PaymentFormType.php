<?php

namespace App\Form;

use App\Entity\Payment;
use App\Entity\Guest;
use App\Form\GuestFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('amount')

            /*->add('guestDeclared', EntityType::class, [
                'class' => Guest::class,
                'choice_label' => 'name',
                'label' => 'Сделавший платеж',
                'multiple' => false,
            ])*/

            ->add('guestDeclared', GuestFormType::class, [
                'label' => false, // Уберите метку для формы гостя
            ])

            ->add('guestReceived', EntityType::class, [
                'class' => Guest::class,
                'choice_label' => 'name',
                'label' => 'Получивший платеж',
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
