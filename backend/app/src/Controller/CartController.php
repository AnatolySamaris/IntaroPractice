<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Model\Request\Orders\OrdersHistoryRequest;
use RetailCrm\Api\Model\Request\Orders\OrdersCreateRequest;
use RetailCrm\Api\Model\Entity\Orders\Order;
use RetailCrm\Api\Model\Entity\Orders\Items\Offer;
use RetailCrm\Api\Model\Entity\Orders\Items\OrderProduct;
use RetailCrm\Api\Model\Entity\Orders\Items\Unit;

class CartController extends AbstractController
{
    private $retailCrmApiKey = 'ZhdjJq9SoNSkxGK3lwmNdCvdxaKKNFiE';

    #[Route('/cart', name: 'app_cart', methods: ['GET'])]
    public function getShoppingCart(Request $request): Response
    {
        $session = $request->getSession();
        $customerId = $session->get('customerId');

        $client = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $this->retailCrmApiKey);
        $ordersHistoryRequest = new OrdersHistoryRequest();
        $ordersHistoryRequest->filter['customer'] = $customerId;
        $orders = $client->orders->history($ordersHistoryRequest)->orders;

        return $this->json($orders);
    }

    #[Route('/cart/add', name: 'app_cart_add', methods: ['POST'])]
    public function addToCart(Request $request): Response
    {
        $session = $request->getSession();
        $customerId = $session->get('customerId');
        $offerId = $request->request->get('offerId');
        $quantity = $request->request->get('quantity');

        $client = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $this->retailCrmApiKey);
        $ordersCreateRequest = new OrdersCreateRequest();
        $order = new Order();
        $offer = new Offer();
        $item = new OrderProduct();

        $offer->externalId = $offerId;
        $offer->unit = new Unit('796', 'pcs', 'pcs');
        $item->offer = $offer;
        $item->quantity = $quantity;
        $order->items[] = $item;
        $order->customer = $customerId;

        $ordersCreateRequest->order = $order;
        $client->orders->create($ordersCreateRequest);

        return new Response('', Response::HTTP_CREATED);
    }

    #[Route('/cart/update', name: 'app_cart_update', methods: ['POST'])]
    public function updateCart(Request $request): Response
    {
        $session = $request->getSession();
        $customerId = $session->get('customerId');
        $offers = $request->request->get('offers');

        $client = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $this->retailCrmApiKey);
        $ordersHistoryRequest = new OrdersHistoryRequest();
        $ordersHistoryRequest->filter['customer'] = $customerId;
        $orders = $client->orders->history($ordersHistoryRequest)->orders;

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                foreach ($offers as $offer) {
                    if ($item->offer->externalId == $offer['offer']['externalId']) {
                        $item->quantity = $offer['quantity'];
                    }
                }
            }
            $client->orders->update($order);
        }

        return new Response('', Response::HTTP_OK);
    }

    #[Route('/cart/remove', name: 'app_cart_remove', methods: ['POST'])]
    public function removeFromCart(Request $request): Response
    {
        $session = $request->getSession();
        $customerId = $session->get('customerId');
        $offerId = $request->request->get('offerId');

        $client = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $this->retailCrmApiKey);
        $ordersHistoryRequest = new OrdersHistoryRequest();
        $ordersHistoryRequest->filter['customer'] = $customerId;
        $orders = $client->orders->history($ordersHistoryRequest)->orders;

        foreach ($orders as $order) {
            foreach ($order->items as $key => $item) {
                if ($item->offer->externalId == $offerId) {
                    unset($order->items[$key]);
                    $client->orders->update($order);
                    break;
                }
            }
        }

        return new Response('', Response::HTTP_OK);
    }
}