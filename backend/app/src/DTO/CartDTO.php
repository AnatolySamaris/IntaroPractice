<?php

namespace App\DTO;

/**
 * Для работы с корзиной.
 */
class CartDTO
{
    /**
     * Массив товаров в формате [externalId: [item, quantity], ...],
     * То есть продукт хранится под ключом собственного externalId
     * для простого доступа к нему. Под ключом хранится товар и его количество В КОРЗИНЕ (quantity)
     */
    private $items = [];
    private $totalPrice = 0.00;


    public function __construct()
    {
    }


    /**
     *  Возвращает данные в виде
     *  {
     *      'items': [
     *          externalId: [item, quantity],
     *          ...
     *      ],
     *      'totalPrice' : int
     *  }
     * 
     */
    public function getData(): array
    {
        return [
            'items' => $this->items,
            'totalPrice' => $this->totalPrice
        ];
    }

    public function setData(array $cart_data): self
    {
        foreach ($cart_data as $product) {
            $this->addItem($product);
        }
        return $this;
    }

    /**
     * Если товар уже добавлен в корзину, добавляем только количество,
     * иначе добавляем товар в корзину в количестве 1.
     * @param array $item
     * @return \App\DTO\CartDTO
     */
    public function addItem(array $item): self
    {
        $externalId = $item['externalId'];
        $this->items[$externalId]['quantity'] = ($this->items[$externalId]['quantity'] ?? 0) + 1;
        $this->items[$externalId]['item'] = $item;
        $this->totalPrice += $item['minPrice'];
        return $this;
    }

    /**
     * Уменьшаем количество товаров в корзине на 1.
     * Если применить для товара которого 1 штука в корзине, он просто удалится.
     * @param array $item
     * @return static
     */
    public function removeItem(array $item): self
    {
        $externalId = $item['externalId'];
        if (array_key_exists($externalId, $this->items)) {
            if ($this->items[$externalId]['quantity'] == 1) {
                $this->deleteItem($item);
            } else {
                $this->totalPrice -= $item['minPrice'];
                $this->items[$externalId]['quantity']--;
            }
        }
        return $this;
    }

    /**
     * Удаляет продукт из корзины
     * @param array $item
     * @return \App\DTO\CartDTO
     */
    public function deleteItem(array $item): self
    {
        $externalId = $item['externalId'];
        if (array_key_exists($externalId, $this->items)) {
            $this->totalPrice -= $item['minPrice'] * $this->items[$externalId]['quantity'];
            unset($this->items[$externalId]);
        }
        return $this;
    }
}