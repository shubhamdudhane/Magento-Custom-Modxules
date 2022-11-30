<?php

namespace Learning\FirstUnit\Plugin;

/**
 * 
 */
class Product
{	
    public function afterGetName(
    \Magento\Catalog\Model\Product $subject,
    $result
	){
     return "Best Product Seller".$result;
	}
}