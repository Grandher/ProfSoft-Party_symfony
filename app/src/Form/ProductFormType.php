<?php

namespace App\Form;

use App\Entity\Receipt;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('quantity')
            ->add('receipt', EntityType::class, [
                'class' => Receipt::class,
                'choice_label' => 'id',
                'label' => 'Выбрать существующий чек',
                //'required' => false, // Поле необязательное
                //'mapped' => false, // Не привязываем к полю сущности
            ])
            /*->add('receipt', ReceiptFormType::class, [
                'label' => false,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
