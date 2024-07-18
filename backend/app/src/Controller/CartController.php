<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Model\Filter\Store\ProductFilterType;
use RetailCrm\Api\Model\Request\Store\ProductsRequest;

use App\DTO\CartDTO;


#[Route('/api/cart')]
class CartController extends AbstractController
{
    /**
     * Получаем корзину юзера из сессии.
     * Предполагается, что корзина хранится в сессии по ключу cart.
     */
    #[Route('/', name: 'app_get_cart', methods: ['get'])]
    public function getCart(SessionInterface $session): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );

        try {
            $cart_data = $session->get('cart', []);
            return $this->json($cart_data);
        } catch (\Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                400
            );
        }
    }

    #[Route('/add/{product_uuid}', name: 'app_add_cart_item', methods: ['post'])]
    public function addCartItem(string $product_uuid, SessionInterface $session): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );

        try {
            $product_request = new ProductsRequest();
            $product_request->filter = new ProductFilterType();
            $product_request->filter->externalId = $product_uuid;

            try {
                $response = $crmClient->store->products($product_request);

                $cart_data = $session->get('cart', []);

                $cart = new CartDTO();
                $cart = $cart
                            ->setData($cart_data)
                            ->addItem($response->products);

                $session->set('cart', $cart);

                return $this->json($cart);

            } catch (ApiExceptionInterface $exception) {
                return $this->json(
                ['error' => $exception->getMessage()],
                $exception->getStatusCode()
                );
            }
        } catch (\Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                400
            );
        }
    }

    #[Route('/remove/{product_uuid}', name: 'app_remove_cart_item', methods: ['post'])]
    public function removeCartItem(string $product_uuid, SessionInterface $session): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );

        try {
            $product_request = new ProductsRequest();
            $product_request->filter = new ProductFilterType();
            $product_request->filter->externalId = $product_uuid;

            try {
                $response = $crmClient->store->products($product_request);

                $cart_data = $session->get('cart');

                $cart = new CartDTO();
                $cart = $cart
                            ->setData($cart_data)
                            ->removeItem($response->products);

                $session->set('cart', $cart);

                return $this->json($cart);

            } catch (ApiExceptionInterface $exception) {
                return $this->json(
                ['error' => $exception->getMessage()],
                $exception->getStatusCode()
                );
            }
        } catch (\Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                400
            );
        }
    }

    #[Route('/delete/{product_uuid}', name: 'app_delete_cart_item', methods: ['post'])]
    public function deleteCartItem(string $product_uuid, SessionInterface $session): JsonResponse
    {
        $crmClient = SimpleClientFactory::createClient(
            $this->getParameter('crm_host'),
            $this->getParameter('api_key')
        );

        try {
            $product_request = new ProductsRequest();
            $product_request->filter = new ProductFilterType();
            $product_request->filter->externalId = $product_uuid;

            try {
                $response = $crmClient->store->products($product_request);

                $cart_data = $session->get('cart');

                $cart = new CartDTO();
                $cart = $cart
                            ->setData($cart_data)
                            ->deleteItem($response->products);

                $session->set('cart', $cart);

                return $this->json($cart);

            } catch (ApiExceptionInterface $exception) {
                return $this->json(
                ['error' => $exception->getMessage()],
                $exception->getStatusCode()
                );
            }
        } catch (\Exception $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                400
            );
        }
    }

    #[Route('/clean', name: 'app_clean_cart', methods: ['post'])]
    public function cleanCart(SessionInterface $session): JsonResponse
    {
        $session->set('cart', []);
        return $this->json([
            'cart' => []
        ]);
    }
}
