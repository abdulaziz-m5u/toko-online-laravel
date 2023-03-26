<?php

namespace App\Exceptions;

use Exception;

class OutOfStockException extends Exception
{
    public function report()
	{
		\Log::debug('The product is out of stock');
	}
}
