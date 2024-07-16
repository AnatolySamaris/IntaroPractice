<?php

namespace App\Controller;

use RetailCrm\Api\Enum\CountryCodeIso3166;
use RetailCrm\Api\Enum\Customers\CustomerType;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Model\Entity\Orders\Delivery\OrderDeliveryAddress;
use RetailCrm\Api\Model\Entity\Orders\Delivery\SerializedOrderDelivery;
use RetailCrm\Api\Model\Entity\Orders\Items\Offer;
use RetailCrm\Api\Model\Entity\Orders\Items\OrderProduct;
use RetailCrm\Api\Model\Entity\Orders\Items\Unit;
use RetailCrm\Api\Model\Entity\Orders\Order;
use RetailCrm\Api\Model\Entity\Orders\Payment;
use RetailCrm\Api\Model\Entity\Orders\SerializedRelationCustomer;
use RetailCrm\Api\Model\Request\Orders\OrdersCreateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $retailCrmApiKey = 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE';

    #[Route('/order', name: 'app_order_create', methods: ['POST'])]
    public function createOrder(Request $request): Response
    {
        $session = $request->getSession();
        $customerId = $session->get('customerId');

        $client = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $this->retailCrmApiKey);

        $ordersCreateRequest = new OrdersCreateRequest();
        $order = new Order();
        $delivery = new SerializedOrderDelivery();
        $deliveryAddress = new OrderDeliveryAddress();
        $payment = new Payment();

        $requestData = $request->toArray();

        $payment->status = "Не оплачен";
        $payment->type = $requestData['paymentType'];

        $deliveryAddress->countryIso = CountryCodeIso3166::RUSSIAN_FEDERATION;
        $deliveryAddress->text = $requestData['address'];

        $delivery->address = $deliveryAddress;
        $delivery->cost = 0;
        $delivery->netCost = 0;

        $items = $requestData['items'] ?? [];
        foreach ($items as $item) {
            $offer = new Offer();
            $orderItem = new OrderProduct();

            $offer->externalId = $item['externalId'];
            $offer->unit = new Unit('796', $item['unitCode'], 'pcs');
            $orderItem->offer = $offer;
            $orderItem->quantity = $item['quantity'];

            $order->items[] = $orderItem;
        }

        $customerResponse = $client->customers->get($customerId);
        if ($customerResponse->customer !== null && is_object($customerResponse->customer)) {
            $customer = $customerResponse->customer;

            $order->delivery = $delivery;
            $order->customer = SerializedRelationCustomer::withIdAndType(
                $customer->id,
                CustomerType::CUSTOMER
            );

            $ordersCreateRequest->order = $order;
            $ordersCreateRequest->site = "Khalif";

            $response = $client->orders->create($ordersCreateRequest);

            return $this->redirectToRoute('app_order_success', ['orderId' => $response->id]);
        } else {
            // Handle the case where the customer is not found
            return $this->redirectToRoute('app_order_create');
        }
    }

    #[Route('/order/success/{orderId}', name: 'app_order_success', methods: ['GET'])]
    public function orderSuccess(string $orderId): Response
    {
        $client = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $this->retailCrmApiKey);
        $order = $client->orders->get($orderId, [])['order'];

        return $this->json([
            'orderId' => $order->id,
            'total' => $order->totalSumm,
            'items' => $order->items,
        ]);
    }
}
