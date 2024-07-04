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

        dump($data);
        return new JsonResponse($data);
    }


    //Профиль пользователя (информация о конкретном пользователе)
    /**
     * @Route("/retailcrm/user/{userID}/profile", name="retailcrm_user_profile")
     */
    public function getUserProfile(string $userID): JsonResponse
    {

        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/customers/$userID", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
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

        dump($data);
        return new JsonResponse($data);
    }


    //Страница товара
    /**
     * @Route("/retailcrm/product/{productId}", name="retailcrm_product_details")
     */
    public function getProductDetails(string $productId): JsonResponse
    {
        $response = $this->httpClient->request('GET', "https://popova.retailcrm.ru/api/v5/store/products", [
            'headers' => [
                'X-API-Key' => 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'filter[externalId]' => $productId,
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

        dump($data);
        return new JsonResponse($data);
    }


}

