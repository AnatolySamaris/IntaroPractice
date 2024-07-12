<?php

namespace App\Controller;

use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Enum\PaginationLimit;
use RetailCrm\Api\Model\Filter\Orders\OrderFilter;
use RetailCrm\Api\Model\Request\Orders\OrdersRequest;

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

#[Route('/api/profile')]
class ProfileController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    #[Route('/info/{uuid}', name: 'get_profile_info', methods: ['get'])]
    public function getProfileInfo(string $uuid): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );
        try {
            $response = $crmClient->customers->get($uuid);

            return $this->json($response->customer);

        } catch (ApiExceptionInterface $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                $exception->getStatusCode()
            );
        }
    }


    #[Route('/history/{uuid}', name: 'get_profile_history', methods: ['get'])]
    public function getProfileHistory(string $uuid, Request $request): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );
        try {
            $orders_request = new OrdersRequest();
            $orders_request->filter = new OrderFilter();
            $orders_request->filter->customerExternalId = $uuid;
            $orders_request->limit = PaginationLimit::LIMIT_20;
            $orders_request->page = $request->query->get('page', 1); 
            $response = $crmClient->orders->list($orders_request);
            return $this->json([
                'pagination' => $response->pagination,
                'orders' => $response->orders
            ]);
        } catch (ClientExceptionInterface | ApiExceptionInterface $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                $exception->getStatusCode()
            );
        }
    }
}
