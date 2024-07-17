<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;


#[Route('/api/cart/')]
class CartController extends AbstractController
{
    #[Route('/products', name: 'app_cart_get_products')]
    public function getCartProducts(): JsonResponse
    {
        return $this->json([]);
    }
}
