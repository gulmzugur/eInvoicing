<?php

/**
 * @author      Uğur Gülmez <gulmzugur@gmail.com>
 * @copyright   Copyright (c) Uğur Gülmez
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/gulmzugur/eInvoicing
 * 
**/

namespace eInvoicing\Exceptions;

use Exception;

class ServicesException extends Exception
{
    protected $responseData;

    public function __construct($message = null, $code = 0, Exception $previous = null, $responseData = [])
    {
        $this->responseData = $responseData;

        parent::__construct($message, $code, $previous);
    }

    public function getResponseData()
    {
        return $this->responseData;
    }
}