<?php

namespace App\Controller;


//use App\Entity\User;
//use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api/v1/profile')]
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
    private function callApi(string $method, string $url, array $query=null, array $headers=null)
    {
        if (is_null($headers)) {
            $headers = [
                'X-API-Key' => $this->getParameter('api_key'),
                'Content-Type' => 'application/json',
            ];
        }

        try {
            $response = $this->httpClient->request($method, $url, [
                'query' => $query,
                'headers' => $headers,
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
     * Получаем личные данные юзера по его id, хранящемуся в нашей базе данных.
     * 
     * В случае успеха возвращает объект с полями 
     *  firstName, lastName, patronymic, sex, email, phones, birthday, address.
     * В случае ошибки возвращает ответ вида: {'message': $error_message}
     */
    #[Route('/info/{id}', name: 'get_profile_info', methods: ['get'])]
    public function getProfileInfo(int $id): JsonResponse
    //public function getProfile(int $id, EntityManagerInterface $doctrine): JsonResponse
    {
        //$user = $doctrine->getRepository(User::class)->find($id);
        $user = 'not null';
        if ($user) {
            //$externalId = $user->getExternalId();
            $externalId = $this->getParameter('temp_externalId');
            $url = 'https://popova.retailcrm.ru/api/v5/customers/' . $externalId;
            $response = $this->callApi('GET', $url);

            if ($response['ok']) {
                $customer = $response['data']['customer'];

                $data = [
                    'firstName' => $customer['firstName'],
                    'lastName' => $customer['lastName'] ?? '',
                    'patronymic' => $customer['patronymic'] ?? '',
                    'sex' => $customer['sex'],
                    'email' => $customer['email'],
                    'phones' => array_map(fn($phone) => $phone['number'], $customer['phones']),
                    'birthday' => $customer['birthday'],
                    'address' => $customer['address']['text'],
                ];
                

                return $this->json($data, 200);

            } else {
                return $this->json(['message' => $response['message']], 500);
            }
        } else {
            return $this->json(['message' => 'User not found.'], 400);
        }
    }

    /**
     * Получаем историю заказов юзера по его id, хранящемуся в нашей базе данных.
     * 
     * В случае успеха возвращает ответ вида:
     * {
     * 'pagination': {'limit': ...(20|50|100), 'totalCount': ..., 'currentPage': ..., 'totalPageCount': ...},
     * 'orders': [...]
     * } 
     * Массив orders содержит объекты заказов с полями number, createdAt, status, totalSum, items.
     * 
     * В случае ошибки возвращает ответ вида: {'message': $error_message}
     */
    #[Route('/history/{id}', name: 'get_profile_history', methods: ['get'])]
    public function getProfileHistory(int $id): JsonResponse
    //public function getProfile(int $id, EntityManagerInterface $doctrine): JsonResponse
    {
        //$user = $doctrine->getRepository(User::class)->find($id);
        $user = 'not null';
        if ($user) {
            //$externalId = $user->getExternalId();
            $externalId = $this->getParameter('temp_externalId');
            $url = 'https://popova.retailcrm.ru/api/v5/orders';
            $query = ['filter[customerExternalId]' => $externalId];
            $response = $this->callApi('GET', $url, $query);

            if ($response['ok']) {
                $data = array(
                    'pagination' => $response['data']['pagination']
                );
                $orders = $response['data']['orders'];
                $orders_data = array();

                foreach ($orders as $order) {
                    $orders_data[] = array(
                        'number' => $order['number'],
                        'createdAt' => $order['createdAt'],
                        'status' => $order['status'],
                        'totalSumm' => $order['totalSumm'],
                        'items' => $order['items']
                    );
                }

                // Можно отсортировать по createdAt, по убыванию
                usort($orders_data, function($a, $b) {
                    return strtotime($b['createdAt']) <=> strtotime($a['createdAt']);
                });

                $data['orders'] = $orders_data;

                return $this->json($data, 200);

            } else {
                return $this->json(['message' => $response['message']], 500);
            }
        } else {
            return $this->json(['message' => 'User not found.'], 400);
        }
    }

    #[Route('/info/{id}', name: 'edit_profile_info', methods: ['put', 'patch'])]
    public function editProfileInfo(int $id): JsonResponse
    //public function getProfile(int $id, EntityManagerInterface $doctrine): JsonResponse
    {
        //$user = $doctrine->getRepository(User::class)->find($id);
        $user = 'not null';
        if ($user) {
            $data = array();



            return $this->json($data, 200);
        } else {
            return $this->json(['message' => 'User not found.'], 400);
        }
    }
}
