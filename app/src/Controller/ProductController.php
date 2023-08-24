<?php

// src/Controller/ProductController.php
namespace App\Controller;

// ...
use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[IsGranted('ROLE_USER')]
class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list', methods: ['GET'])]
    public function listProducts(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/new', name: 'new_product', methods: ['GET', 'POST'])]
    public function newProduct(Request $request, ManagerRegistry $doctrine): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Добавить продукт',
        ]);
    }

    #[Route('/product/{id}/edit', name: 'edit_product', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function editProduct(Request $request, Product $product, ManagerRegistry $doctrine): Response
    {
        // Создаем форму для редактирования продукта, передавая сущность $product
        $form = $this->createForm(ProductFormType::class, $product);

        // Обработка отправки формы
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Сохраняем изменения в базе данных
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            // Перенаправляем пользователя после успешного сохранения
            return $this->redirectToRoute('product_list');
        }
        // Рендерим шаблон для редактирования продукта
        return $this->render('product/edit.html.twig', [
            'form' => $form,
            'title' => 'Редактировать продукт',
        ]);
    }
    #[Route('/product/{id}/delete', name: 'delete_product', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteProduct(Product $product, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_list');
    }
}