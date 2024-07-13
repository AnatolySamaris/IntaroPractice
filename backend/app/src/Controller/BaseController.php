<?php

namespace App\Controller;

use Exception;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Model\Filter\Store\ProductGroupFilterType;
use RetailCrm\Api\Model\Request\Store\ProductGroupsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request; 

class BaseController extends AbstractController
{

    
    private $httpClient;
    private $cache;

    public function __construct(HttpClientInterface $httpClient, CacheInterface $cache)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    public function uuid_get(Request $request): Response
    {
        $uuid = $request->getSession()->get('uuid');

        // Используйте $uuid как необходимо
        // ...

        return new Response('Your UUID: ' . $uuid);
    }
    

    protected function createRetailCrmUsers()
    {
        try {
            $users = SimpleClientFactory::createClient('https://popova.retailcrm.ru/', $_ENV['API_KEY']);
            $users->api->credentials();
            return $users;
        } catch (Exception $exception) {
            // Handle exception appropriately (logging, error response, etc.)
            throw $exception;
        }
    }

    protected function getHeader()
    {
        $user = $this->getUser();

        if (!is_null($user)) {
            $user->crmLoad();
        }

        $category = $this->cache->getItem('category_menu');

        if (!$category->isHit()) {
            try {
                $users = $this->createRetailCrmUsers();

                $request = new ProductGroupsRequest();
                $request->filter = new ProductGroupFilterType();

                $categoryMenu = $users->store->productGroups($request)->productGroup;

                // Filtering $categoryMenu
                $filteredCategoryMenu = [];
                foreach ($categoryMenu as $key => $c) {
                    if ($c->parentId === null) {
                        $filteredCategoryMenu[] = $c;
                    }
                }

                $category->set($filteredCategoryMenu);
                $category->expiresAfter(3600 * 2);
                $this->cache->save($category);
            } catch (Exception $exception) {
                // Handle exception appropriately (logging, error response, etc.)
                throw $exception;
            }
        }

        return [
            
          
           0
        ];
    }
}
