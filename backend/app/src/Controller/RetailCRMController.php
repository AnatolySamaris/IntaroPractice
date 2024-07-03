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
}
