<?php

namespace App\Controller\Api;

// TODO: comment
use App\Entity\Product;
use App\Helper\DTO\CRUD\ProductDTO;
use App\Helper\DTO\Response\ProductResponseDTO;
use App\Service\ProductService;
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
use Symfony\Component\Serializer\SerializerInterface;

#[OA\Tag(name: 'Products')]
#[IsGranted('ROLE_USER')]
class ProductApiController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly SerializerInterface $serializer,
    )
    {
    }

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
    #[Route('/getProducts', methods: Request::METHOD_GET)]
    public function getProducts(): JsonResponse
    {
        // TODO: Вся логика - в сервисном слое. Контроллер только для получения запроса, валидации
        // и отправки в сервисный слой с отдачей ответа.
        return $this->json($this->productService->getProducts(), Response::HTTP_OK);
    }

    // TODO: нет тела запроса.
    #[OA\Post(
        description: 'Добавление нового продукта',
        summary: 'Создание нового продукта',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: ProductDTO::class, groups: ['create']))
        ),
        responses: [
            new OA\Response(
            // TODO: 201 + код стайл.
            response: Response::HTTP_OK,
                description: 'Продукт создан'
            ),
        ]
    )]
    // TODO: если метод один - массив не нужен + лучше указывать через Request::METHOD_POST.
    #[Route('/newProduct', methods: ['POST'])]
    public function newProduct(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // TODO: логику в сервисный слой и делать каст ДТО с реквеста, а не брать весь реквест.
        $data = json_decode($request->getContent(), true);
        $productDTO = $this->serializer->serialize($data, ProductDTO::class, ['groups' => ['create']]);

        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setQuantity($data['quantity']);

        $entityManager->persist($product);
        $entityManager->flush();

        // TODO: 201
        return $this->json($product, status: Response::HTTP_CREATED);
    }

    // TODO: нет тела запроса + сменить заголовок на PATCH.
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
    // TODO: согласно REST в методе не нужно указание /edit, достаточно просто показать в типе запроса, что это PATCH/PUT.
    #[Route('/product/{id}/edit', methods: ['PUT'])]
    // TODO: базовый конструктор.
    public function editProduct(Request $request, Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // TODO: логика в сервисном слове, а не в контроллере.
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
                // TODO: 204
                response: Response::HTTP_NO_CONTENT,
                description: 'Продукт удалён'
            ),
        ]
    )]
    // TODO: тоже самое, не нужен delete в роуте.
    #[Route('/product/{id}/delete', methods: ['DELETE'])]
    public function deleteProduct(Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($product);
        $entityManager->flush();

        $responseArray = ['message' => 'Продукт успешно удалён'];
        // TODO: 204
        return $this->json($responseArray);
    }
}
