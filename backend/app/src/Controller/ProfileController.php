<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api/v1')]
class ProfileController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    /**
     * Вспомогательный метод для обращения к апи, все обработки ошибок запроса здесь.
     */
    private function callApi(string $method, string $url, array $headers=null)
    {
        if (is_null($headers)) {
            $headers = [
                'X-API-Key' => $this->getParameter('api_key'),
                'Content-Type' => 'application/json',
            ];
        }

        try {
            $response = $this->httpClient->request($method, $url, [
                'headers' => $headers
            ]);
    
            if ($response->getStatusCode() != 200) {
                throw new \Exception('Failed to fetch data: ' . $response->getStatusCode());
            }

            $data = json_decode($response->getContent(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
            }

            if (!$data['success']) {
                throw new \Exception('API respose is not successful: ' . $data['errorMsg']);
            }

            return array('ok' => true, 'data' => $data);

        } catch (\Throwable $th) {
            return array('ok' => false, 'message' => $th->getMessage());
        }
    }


    /**
     * Получаем профиль юзера по его id, хранящемуся в нашей базе данных.
     * 
     * В случае успеха возвращает ответ вида: ...
     * В случае ошибки возвращает ответ вида: {'message': $error_message}
     */
    #[Route('/profile/{id}', name: 'get_profile', methods: ['get'])]
    public function getProfile(int $id): JsonResponse
    //public function getProfile(int $id, EntityManagerInterface $doctrine): JsonResponse
    {
        
        //$user = $doctrine->getRepository(User::class)->find($id);
        $user = 'not null';

        if ($user) {
            //$externalId = $user->getExternalId();
            $externalId = $this->getParameter('TEMP_EXTERNALID');
            $url = 'https://popova.retailcrm.ru/api/v5/customers/' . $externalId;
            $response = $this->callApi('GET', $url);

            if ($response['ok']) {
                $data = array();
                $customer = $response['customer'];

                // Работаем с личными данными
                $firstName = $customer['firstName'];
                $lastName = isset($customer['lastname']) ? $customer['lastname'] : '';
                $patronymic = isset($customer['patronymic']) ? $customer['patronymic'] : '';
                $sex = $customer['sex'];
                $email = $customer['email'];
                $phones = array_map(fn($phone) => $phone['number'], $customer['phones']);
                $birthday = $customer['birthday'];
                $address = $customer['address']['text'];

                $data['personalInfo'] = [
                    $firstName, $lastName, $patronymic, $sex, $email, $phones, $birthday, $address
                ];


                // Работаем с историей заказов
                $url = 'https://popova.retailcrm.ru/api/v5/orders?filter[customerExternalId]=' . $externalId;
                $response = $this->callApi('GET', $url);

                if ($response['ok']) {
                    $orders = $response['orders'];
                    $orders_data = array();

                    foreach ($orders as $order) {
                        $number = $order['number'];
                        $createdAt = $order['createdAt'];
                        $status = $order['status'];
                        $totalSumm = $order['totalSumm'];
                        $items = $order['items'];
                        $orders_data[] = array($number, $createdAt, $status, $totalSumm, $items);
                    }

                    // Можно отсортировать по createdAt

                    $data['ordersHistory'] = $orders_data;

                } else {
                    return $this->json(['message' => $response['message']], 500);
                }

                return $this->json($data, 200);

            } else {
                return $this->json(['message' => $response['message']], 500);
            }
        } else {
            return $this->json(['message' => 'User not found.'], 400);
        }
    }
}
