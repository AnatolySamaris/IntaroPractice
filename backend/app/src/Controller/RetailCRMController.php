<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RetailCRMController extends AbstractController
{
    private $httpClient;
    //Нижнее белье
    private $ID_Underwear=20;

    //Аксессуары
    private $ID_Accessories=19;

    //Ремни
    private $ID_Belts=26;
    //Ремни Мужские
    private $ID_Men_Belts=31;
    //Ремни Женские
    private $ID_Women_Belts=30;

    //Обувь
    private $ID_Shoes=21;

    //Пантолеты
    private $ID_Pantolets=27;
    //Тапочки
    private $ID_Slippers=28;
    //Туфли
    private $ID_Low_Shoes=29;
    //Туфли Женские
    private $ID_Women_Low_Shoes=32;
    //Туфли Мужские
    private $ID_Men_Low_Shoes=33;
    //Платья
    private $ID_Dresses=22;
    //Спортивная Одежда
    private $ID_Sportswear=23;
    //Футболки
    private $ID_T_shirts=24;
    //Штаны
    private $ID_Trousers=25;
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @Route("/retailcrm/orders", name="retailcrm_orders")
     */
    public function getOrders(): JsonResponse
    {
        $response = $this->httpClient->request('GET', 'https://popova.retailcrm.ru/api/v5/orders', [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
        ]);


        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception('Failed to fetch data: ' . $statusCode);
        }
        $content = $response->getContent();
        $data = json_decode($content, true);
        //dump($content);
        // Дополнительная проверка данных
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
        }
        // Вывод данных в отладочной консоли Symfony
        dump($data);
        return new JsonResponse($data);
    }



    //История заказов конкретного клиента
    /**
     * @Route("/retailcrm/customer/{email}/orders", name="retailcrm_customer_orders")
     */
    public function getCustomerOrders(string $email): JsonResponse
    {
        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/orders", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'filter[email]' => $email,
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception('Не удалось получить данные: ' . $statusCode);
        }

        $content = $response->getContent();
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Некорректный JSON ответ: ' . json_last_error_msg());
        }

      //  dump($data);
        return new JsonResponse($data);
    }


    //Профиль пользователя (информация о конкретном пользователе)
    /**
     * @Route("/retailcrm/user/{email}/profile", name="retailcrm_user_profile")
     */
    public function getUserProfile(string $email): JsonResponse
    {

        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/customers", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'filter[email]' => $email,
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception('Не удалось получить данные: ' . $statusCode);
        }

        $content = $response->getContent();
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Некорректный JSON ответ: ' . json_last_error_msg());
        }

        //dump($data);
        return new JsonResponse($data);
    }


    //Страница товара
    /**
     * @Route("/retailcrm/product/{productId}/{color}/{size}", name="retailcrm_product_details")
     */
    public function getProductDetails(string $productId, string $color, string $size): JsonResponse
    {
        // Выполняем запрос к API с передачей параметров фильтрации
        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/store/products", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'filter[externalId]' => $productId,
                'filter[properties][color]' => $color,
                'filter[properties][size]' => $size,
            ],
        ]);

        // Проверяем статус ответа
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception('Не удалось получить данные: ' . $statusCode);
        }

        // Получаем контент ответа
        $content = $response->getContent();
        $data = json_decode($content, true);

        // Проверяем наличие ошибок при декодировании JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Некорректный JSON ответ: ' . json_last_error_msg());
        }

        // Фильтруем массив offers, оставляем только нужный товар по цвету и размеру
        if (isset($data['products'][0]['offers'])) {
            $filteredOffers = array_filter($data['products'][0]['offers'], function($offer) use ($color, $size) {
                return isset($offer['properties']['color']) && $offer['properties']['color'] === $color
                    && isset($offer['properties']['size']) && $offer['properties']['size'] === $size;
            });

            // Переиндексируем массив, чтобы он начинался с 0
            $filteredOffers = array_values($filteredOffers);

            // Заменяем массив offers на отфильтрованный
            $data['products'][0]['offers'] = $filteredOffers;
        }
        //dump($data);
        // Возвращаем JSON ответ с отфильтрованными данными
        return new JsonResponse($data);
    }



    //Категории
    /**
     * @Route("/retailcrm/сategory", name="retailcrm_сategory")
     */
    public function getCategory(): JsonResponse
    {
        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/store/product-groups", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                //'filter[email]' => $email,
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception('Не удалось получить данные: ' . $statusCode);
        }

        $content = $response->getContent();
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Некорректный JSON ответ: ' . json_last_error_msg());
        }

        //dump($data);
        return new JsonResponse($data);
    }


    /**
     * @Route("/retailcrm/product/{productId}", name="retailcrm_product")
     */
    public function getProduct(string $productId): JsonResponse
    {
        // Выполняем запрос к API с передачей параметров фильтрации
        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/store/products", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'filter[externalId]' => $productId,
                //'filter[properties][color]' => $color,
                //'filter[properties][size]' => $size,
            ],
        ]);

        // Проверяем статус ответа
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception('Не удалось получить данные: ' . $statusCode);
        }

        // Получаем контент ответа
        $content = $response->getContent();
        $data = json_decode($content, true);

        // Проверяем наличие ошибок при декодировании JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Некорректный JSON ответ: ' . json_last_error_msg());
        }


        //dump($data);
        // Возвращаем JSON ответ с отфильтрованными данными
        return new JsonResponse($data);
    }
    ///////////////////////////////////////////////////////////////////Продукты категории

    /**
     * @Route("/retailcrm/products/{groupId}", name="retailcrm_products_category")
     */
    public function getProducts_category(string $groupId): JsonResponse
    {
        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/store/products", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'filter[groupExternalId]' => $groupId,
                //'filter[properties][size]' => 'S',
                //'filter[properties][color]' => 'белый',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \Exception('Не удалось получить данные: ' . $statusCode);
        }

        $content = $response->getContent();
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Некорректный JSON ответ: ' . json_last_error_msg());
        }

        // Инициализация массива продуктов
        $products = $data['products'] ?? [];

        foreach ($products as &$product) {
            $colors = [];
            $sizes = [];

            foreach ($product['offers'] as $offer) {
                $properties = $offer['properties'] ?? [];

                if (isset($properties['color']) && !in_array($properties['color'], $colors)) {
                    $colors[] = $properties['color'];
                }

                if (isset($properties['size']) && !in_array($properties['size'], $sizes)) {
                    $sizes[] = $properties['size'];
                }
            }

            // Добавление массивов цветов и размеров к продукту
            $product['colors'] = $colors;
            $product['sizes'] = $sizes;
        }

        // Обновление данных продуктов
        $data['products'] = $products;

        //dump($data);

        return new JsonResponse($data);
    }


}

