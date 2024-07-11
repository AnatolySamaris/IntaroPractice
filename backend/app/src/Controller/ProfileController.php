<?php

namespace App\Controller;


//use App\Entity\User;
//use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
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
    private function callApi(string $method, string $url, array|string $query=null, array $headers=null, array|string $body=null): array
    {
        if (is_null($headers)) {
            $headers = [
                'X-API-Key' => $this->getParameter('api_key'),
                'Content-Type' => ($method == 'GET') ? 'application/json' : 'application/x-www-form-urlencoded',
            ];
        }

        try {
            $response = $this->httpClient->request($method, $url, [
                'query' => $query,
                'headers' => $headers,
                'body' => $body,
            ]);
    
            if ($response->getStatusCode() != 200) {
                throw new \Exception('Failed to fetch data: ' . $response->getContent());
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
     * Базовая валидация параметров.
     */
    private function validateParam(string|int|float $param, bool $email=false, bool $phone=false): bool
    {
        if (is_null($param)) {
            return false;
        }
        if (is_string($param)) {
            $param = trim($param);
            if (strlen($param) == 0) {
                return false;
            } else {
                if ($email || $phone) {
                    $reg = '';
                    if ($email) {
                        $reg = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/';
                    } else if ($phone) {
                        $reg = "/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/";
                        return true;    // !!!!!
                    }
                    if (preg_match($reg, $param)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        } else if ($param < 0) {
            return false;
        } else {
            return true;
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
                    'birthday' => $customer['birthday'],
                    'address' => $customer['address']['text']
                ];
                
                foreach ($customer['phones'] as $phone) {
                    $data['phones'][]['number'] = $phone['number'];
                }

                return $this->json($data, 200);

            } else {
                return $this->json(['message' => $response['message']], 500);
            }
        } else {
            return $this->json(['message' => 'User not found.'], 404);
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
            return $this->json(['message' => 'User not found.'], 404);
        }
    }

    /**
     * Изменяем личные данные пользователя.
     * При отправке запроса можно отправлять только те данные, которые изменяются
     * (например, только поле firstName с новым значением).
     * Работает с полями firstName, lastName, patronymic, phones, email, birthday, sex, address.
     * 
     * phones передавать в строке, разделяя знаком ";" без пробелов, если значений несколько.
     * 
     * При успешном запросе возвращает объект пользователя с измененными полями.
     * При ошибке запроса возвращает ответ вида {'message': $error_message}
     */
    #[Route('/info/{id}', name: 'edit_profile_info', methods: ['post'])]
    public function editProfileInfo(int $id, Request $request): JsonResponse
    //public function getProfile(int $id, Request $request, EntityManagerInterface $doctrine): JsonResponse
    {
        //$user = $doctrine->getRepository(User::class)->find($id);
        $user = 'not null';
        if ($user) {

            // Проверяем на наличие лишних параметров
            $check_params_array = array(
                'firstName', 'lastName', 'patronymic', 'phones', 'email', 'birthday', 'sex', 'address'
            );
            foreach ($request->request->keys() as $key) {
                if (!in_array($key, $check_params_array)) {
                    return $this->json([
                        'message' => 'Invalid parameter key: ' . $key,
                    ], 400);
                }
            }

            // Валидируем
            foreach ($request->request->all() as $key => $value) {
                if (($key == 'firstName' && !$this->validateParam($value)) ||
                    ($key == 'sex' && !in_array($value, ['male', 'female'])) ||
                    ($key == 'email' && !$this->validateParam($value, email: true)) ||
                    ($key == 'phones' && !$this->validateParam($value, phone: true))
                ) {
                    return $this->json(['message' => 'Invalid parameter value.'], 400);
                }
            }

            // Стягиваем данные юзера, меняем необходимые поля, выполняем POST запрос
            //$externalId = $user->getExternalId();
            $externalId = $this->getParameter('temp_externalId');
            $url = 'https://popova.retailcrm.ru/api/v5/customers/' . $externalId;
            $response = $this->callApi('GET', $url);

            if ($response['ok']) {
                $customer = $response['data']['customer'];

                // Если новое значение не задано - ставим значение, которое было.
                // Если такого поля вообще не было - ставим его со значением пустой строки
                $customer['firstName'] = $request->request->get('firstName', $customer['firstName'] ?? '');
                $customer['lastName'] = $request->request->get('lastName', $customer['lastName'] ?? '');
                $customer['patronymic'] = $request->request->get('patronymic', $customer['patronymic'] ?? '');
                $customer['sex'] = $request->request->get('sex', $customer['sex'] ?? '');
                $customer['email'] = $request->request->get('email', $customer['email'] ?? '');
                $customer['birthday'] = $request->request->get('birthday', $customer['birthday'] ?? '');
                $customer['address']['text'] = $request->request->get('address', $customer['address']['text'] ?? '');

                if ($request->request->has('phones')) {
                    $phones = array();
                    foreach (explode(';', $request->request->get('phones')) as $phone) {
                        if (strlen($phone) > 0) {
                            $phones[] = array('number' => $phone);
                        }
                    }
                    $customer['phones'] = $phones;
                }


                //return $this->json($customer, 200);

                $serializer = new Serializer(
                    [new ObjectNormalizer()],
                    [new JsonEncoder()]
                );

                $customer_json = $serializer->serialize($customer, 'json');

                //return $this->json($customer_json);
                
                $body = http_build_query(
                    $customer,
                    encoding_type: PHP_QUERY_RFC3986
                );

                $body2 = urlencode(json_encode($customer));

                return $this->json(['enc' => $body, 'enc2' => $body2, 'serialized' => $customer_json, 'orig' => $customer]);

                $url = 'https://popova.retailcrm.ru/api/v5/customers/'.$externalId.'/edit';

                $response = $this->httpClient->request("POST", $url, [
                    'headers' => [
                        'X-API-Key' => $this->getParameter('api_key'),
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    //'query' => $body,
                    'body' => [
                        'by' => 'externalId',
                        'site' => $this->getParameter('site_name'),
                        'customer' => $body2
                    ],
                ]);
                return $this->json(['answer' => $response->getContent()]);
                
                //return $this->json($body);
                
                $url = 'https://popova.retailcrm.ru/api/v5/customers/'.$externalId.'/edit';
                //$body = $customer;
                //$response = $this->callApi('POST', $url, body: $body);
                $response = $this->callApi('POST', $url, body: $body);
                if ($response['ok']) {
                    return $this->json($customer, 200);
                } else {
                    return $this->json(['message' => $response['message']], 500);
                }
            } else {
                return $this->json(['message' => $response['message']], 500);
            }
        } else {
            return $this->json(['message' => 'User not found.'], 404);
        }
    }
}
