<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function addCart($item, $product_id)
    {
        $storedItem = ['qty'=>0, 'price'=>$item->product_rate, 'item'=>$item];
        if ($this->items) {
            if (array_key_exists($product_id, $this->items)) {
                $storedItem = $this->items[$product_id];
            }
        }

        $storedItem['qty']++;
        $storedItem['price'] = $item->product_rate * $storedItem['qty'];
        $this->items[$product_id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->product_rate;
    }

    public function addCartValue($item, $inputItem, $product_id)
    {
        $storedItem = ['qty'=>0, 'price'=>$inputItem['rateNumber'], 'item'=>$item];
        if ($this->items) {
            if (array_key_exists($product_id, $this->items)) {
                $storedItem = $this->items[$product_id];
            }
        }

        $storedItem['qty']+=$inputItem['quantityNumber'];
        $storedItem['price'] = $inputItem['rateNumber'] * $storedItem['qty'];
        $this->items[$product_id] = $storedItem;
        $this->totalQty+=$inputItem['quantityNumber'];
        $this->totalPrice += $inputItem['rateNumber'] * $inputItem['quantityNumber'];
    }
}