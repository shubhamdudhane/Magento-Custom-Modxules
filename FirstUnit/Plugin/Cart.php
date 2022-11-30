<?php

namespace Learning\FirstUnit\Plugin;

/**
 * 
 */
class Cart
{	
	public function beforeAddProduct(
    \Magento\Checkout\Model\Cart $subject,
    $productInfo,
    $requestInfo = null
	)
	{
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
         $logger = new \Zend\Log\Logger();
         $logger->addWriter($writer);
         $logger->info('Your text message');
         
     $requestInfo['qty'] = 15;   //increasing product quantity to cart  
     return array($productInfo, $requestInfo);
	}

	public function aroundAddProduct(
    \Magento\Checkout\Model\Cart $subject,
    \Closure $proceed,
    $productInfo,
    $requestInfo = null
	)
	{
     $requestInfo['qty'] = 6;   //increasing product quantity to cart  
     $result = $proceed($productInfo, $requestInfo);
     return $result;
	}


}