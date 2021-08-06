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

class TestEnvironmentException extends Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message);
    }
}