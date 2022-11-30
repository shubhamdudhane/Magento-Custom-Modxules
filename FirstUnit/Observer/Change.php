<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Learning\FirstUnit\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Change implements ObserverInterface
{
    public function __construct()
    {
        // Observer initialization code...
        // You can use dependency injection to get any class this observer may need.
    }

    public function execute(Observer $observer)
    {
        $collection = $observer->getEvent()->getData('collection');

        foreach ($collection as $product) {
            $price = $product->getData('price');
            $name  = $product->getData('name');
            if ($price < 2) {
                $name = $name." "."So Cheap";
            } else {
                $name = $name." "."So Expensive";
            }
            $product->setData('name', $name);
        }
    }
}
