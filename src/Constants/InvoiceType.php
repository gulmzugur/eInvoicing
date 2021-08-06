<?php

/**
 * @author      Uğur Gülmez <gulmzugur@gmail.com>
 * @copyright   Copyright (c) Uğur Gülmez
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/gulmzugur/eInvoicing
 * 
**/

namespace eInvoicing\Constants;

class InvoiceType {
    const SALE                              = "SATIS";
    const REFUND                            = "IADE";
    const WITHHOLDING                       = "TEVKIFAT";
    const EXCEPTION                         = "ISTISNA";
    const SPECIAL_BASE                      = "OZELMATRAH";
    const EXPORT_REGISTERED                 = "IHRACKAYITLI";
    const WHOLESALER_STATE_INVOICE_SALES    = "HKSSATIS";
    const WHOLESALE_TYPE_INVOICE_BROKER     = "HKSKOMISYONCU";
    
}