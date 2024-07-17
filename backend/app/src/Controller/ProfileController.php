<?php

namespace App\Controller;

use App\Form\ProfileType;

use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Enum\PaginationLimit;
use RetailCrm\Api\Model\Filter\Orders\OrderFilter;
use RetailCrm\Api\Model\Request\Orders\OrdersRequest;
use RetailCrm\Api\Model\Entity\Customers\Customer;
use RetailCrm\Api\Model\Entity\Customers\CustomerPhone;
use RetailCrm\Api\Model\Entity\Customers\CustomerAddress;
use RetailCrm\Api\Model\Request\Customers\CustomersEditRequest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


#[Route('/api/profile/')]
class ProfileController extends AbstractController
{

    public function __construct()
    {
    }


    #[Route('info/{uuid}', name: 'get_profile_info', methods: ['get'])]
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

    #[Route('info/{uuid}', name: 'edit_profile_info', methods: ['post'])]
    public function editProfileInfo(string $uuid, Request $request): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );

        try {
            $customer_data = $request->request->all();

            $form = $this->createForm(ProfileType::class);
            $form->submit($customer_data);

            if ($form->isValid()) {
                $requestCustomer = new CustomersEditRequest();
                $requestCustomer->customer= new Customer();

                $requestCustomer->customer->firstName = $form->get('firstName')->getData();
                $requestCustomer->customer->lastName = $form->get('lastName')->getData();
                $requestCustomer->customer->patronymic = $form->get('patronymic')->getData();
                $requestCustomer->customer->email  = $form->get('email')->getData();
                $requestCustomer->customer->phones = [new CustomerPhone()];
                $requestCustomer->customer->phones[0]->number = $form->get('phone')->getData();
                $requestCustomer->customer->birthday = $form->get('birthday')->getData();
                $requestCustomer->customer->sex = $form->get('sex')->getData() == 2 ? 'female' : 'male';
                $requestCustomer->customer->address = new CustomerAddress();
                $requestCustomer->customer->address->text = $form-> get('address')->getData();

                try {
                    $crmClient->customers->edit($uuid, $requestCustomer);
                    return $this->json($form->getData());
                } catch (\Exception $e) {
                    return $this->json(['error' => $e->getMessage()], 500);
                }
            } else {
                return $this->json(['error' => $form->getErrors(true)], 400);
            }

        } catch (ApiExceptionInterface $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                $exception->getStatusCode()
            );
        }
    }


    #[Route('history/{uuid}', name: 'get_profile_history', methods: ['get'])]
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
