<?php

namespace App\Controller;

use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Enum\CountryCodeIso3166;
use RetailCrm\Api\Enum\Customers\CustomerType;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Model\Entity\Orders\Delivery\OrderDeliveryAddress;
use RetailCrm\Api\Model\Entity\Orders\Delivery\SerializedOrderDelivery;
use RetailCrm\Api\Model\Entity\Orders\Items\Offer;
use RetailCrm\Api\Model\Entity\Orders\Items\OrderProduct;
use RetailCrm\Api\Model\Entity\Orders\Items\PriceType;
use RetailCrm\Api\Model\Entity\Orders\Items\Unit;
use RetailCrm\Api\Model\Entity\Orders\Order;
use RetailCrm\Api\Model\Entity\Orders\Payment;
use RetailCrm\Api\Model\Entity\Orders\SerializedRelationCustomer;
use RetailCrm\Api\Model\Request\Orders\OrdersCreateRequest;

use App\Form\OrderType;

#[Route('/api/order')]
class OrderController extends AbstractController
{
    #[Route('/create', name: 'app_create_order', methods: ['post'])]
    public function createOrder(Request $request, SessionInterface $session): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );

        try {
            $order_data = $request->request->all();

            $form = $this->createForm(OrderType::class);
            $form->submit($order_data);

            if ($form->isValid()) {
                
                $cart = $session->get('cart');

                $request = new OrdersCreateRequest();
                $order = new Order();
                $payment = new Payment();
                $delivery = new SerializedOrderDelivery();
                $deliveryAddress = new OrderDeliveryAddress();

                $payment->type = $form->get('paymentType')->getData();
                $payment->status = 'paid';
                $payment->amount = $cart['totalPrice'];
                $payment->paidAt = new DateTime();

                $deliveryAddress->text = $form->get('address')->getData();

                $delivery->address = $deliveryAddress;
                $delivery->cost = 0;
                $delivery->netCost = 0;

                $order->delivery = $delivery;
                $order->items = [];

                foreach ($cart['items'] as  $item) {
                    $offer = new Offer();
                    $offer->name = $item['name'];
                    $offer->externalId = $item['externalId'];
                    $offer->article = $item['article'];

                    $item = new OrderProduct();
                    $item->offer = $offer;
                    $item->quantity = 1;    // переписать DTO корзины чтобы сохранять количество товара
                    $item->purchasePrice = 1;   // тут тоже, сохранять отдельно цену
                    
                    $order->items[] = $item;
                }

                $order->payments = [$payment];
                $order->orderType     = 'test';
                $order->orderMethod   = 'phone';
                $order->countryIso    = CountryCodeIso3166::RUSSIAN_FEDERATION;
                $order->firstName     = $form->get('firstName')->getData();
                $order->lastName      = $form->get('lastName')->getData();
                $order->patronymic    = $form->get('patronymic')->getData();
                $order->phone         = $form->get('phone')->getData();
                $order->email         = $form->get('email')->getData();
                $order->managerId     = 28;
                //$order->customer      = SerializedRelationCustomer::withIdAndType(
                //    4924,
                //    CustomerType::CUSTOMER
                //);
                $order->status        = 'assembling';
                $order->statusComment = 'Assembling order';
                $order->weight        = 1;
                $order->shipmentStore = 'store';
                $order->shipmentDate  = (new DateTime())->add(new DateInterval('P7D'));
                $order->shipped       = false;

                $request->order = $order;
                $request->site  = 'intaro-practice';

                try {
                    $response = $crmClient->orders->create($request);
                    return $this->json([
                        'success' => true,
                        'message' => 'Thank you!'
                    ]);
                } catch (ApiExceptionInterface | ClientExceptionInterface $exception) {
                    return $this->json(
                        ['error' => $exception->getMessage()],
                        $exception->getStatusCode()
                    );
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
}
