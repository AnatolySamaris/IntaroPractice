<!-- Пока сырая версия -->

<?php

namespace App\Controller;

use RetailCrm\Api\Factory\SimpleClientFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderHistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history', methods: ['GET'])]
    public function getOrderHistory(Request $request): Response
    {
        $session = $request->getSession();
        $userId = $session->get('userId');

        $client = SimpleClientFactory::createClient('https://popova.retailcrm.ru', $_ENV['RETAIL_CRM_API_KEY']);
        $orders = $client->orders->list(['filter' => ['customer' => $userId]])->orders;

        return $this->json($orders);
    }
}
