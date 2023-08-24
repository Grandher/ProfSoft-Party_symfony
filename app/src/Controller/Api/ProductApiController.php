<?php

namespace App\Controller\Api;

// ...
use App\Entity\Product;
use App\Helper\DTO\Response\ProductResponseDTO;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Products')]
#[IsGranted('ROLE_USER')]
class ProductApiController extends AbstractController
{
    #[OA\Get(
        description: 'Отображение всех продуктов',
        summary: 'Список всех продуктов',
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Все продукты',
                content: new OA\JsonContent(ref: new Model(type: ProductResponseDTO::class, groups: ['getList']))
            ),
        ]
    )]
    #[Route('/getProducts', methods: ['GET'])]
    public function getProducts(ManagerRegistry $doctrine): JsonResponse
    {
        $products = $doctrine->getRepository(Product::class)->findAll();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[OA\Post(
        description: 'Добавление нового продукта',
        summary: 'Создание нового продукта',
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Продукт создан'
            ),
        ]
    )]
    #[Route('/newProduct', methods: ['POST'])]
    public function newProduct(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setQuantity($data['quantity']);

        $entityManager->persist($product);
        $entityManager->flush();

        return $this->json($product);
    }

    #[OA\Put(
        description: 'Редактирование продукта',
        summary: 'Изменение продукта',
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Продукт изменён'
            ),
        ]
    )]
    #[Route('/product/{id}/edit', methods: ['PUT'])]
    public function editProduct(Request $request, Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product->setName($data['name']);
        $product->setPrice($data['price']);

        $entityManager->flush();

        return $this->json($product);
    }
    #[OA\Delete(
        description: 'Удаление продукта',
        summary: 'Удаление продукта',
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Продукт удалён'
            ),
        ]
    )]
    #[Route('/product/{id}/delete', methods: ['DELETE'])]
    public function deleteProduct(Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($product);
        $entityManager->flush();

        $responseArray = ['message' => 'Продукт успешно удалён'];
        return $this->json($responseArray);
    }
}