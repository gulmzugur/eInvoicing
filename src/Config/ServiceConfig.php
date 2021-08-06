<?php

/**
 * @author      Uğur Gülmez <gulmzugur@gmail.com>
 * @copyright   Copyright (c) Uğur Gülmez
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/gulmzugur/eInvoicing
 * 
 */

namespace eInvoicing\Config;

class ServiceConfig
{


    /**
     * Urls
     */
    const BASE_URL      = "https://earsivportal.efatura.gov.tr";
    const TEST_URL      = "https://earsivportaltest.efatura.gov.tr";

    /**
     * Paths
     */
    const TESTCRENDENTIALS_PATH = "/earsiv-services/esign";
    const DISPATCH_PATH         = "/earsiv-services/dispatch";
    const TOKEN_PATH            = "/earsiv-services/assos-login";
    const REFERRER_PATH         = "/intragiris.html";
    const DOWNLOAD_PATH         = "/earsiv-services/download";

    /**
     * Debug mode
     *
     * @var boolean
     */
    protected $debugMode = false;

    /**
     * Referrer variable
     *
     * @var string
     */
    protected $referrer;

    /**
     * Base headers
     *
     * @var array
     */
    protected $headers = [
        "accept"          => "*/*",
        "accept-language" => "tr,en-US;q=0.9,en;q=0.8",
        "cache-control"   => "no-cache",
        "content-type"    => "application/x-www-form-urlencoded;charset=UTF-8",
        "pragma"          => "no-cache",
        "sec-fetch-mode"  => "cors",
        "sec-fetch-site"  => "same-origin",
        "User-Agent"      => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36", 
    ];

    /**
     * Base Constructor method
     */
    public function __construct()
    {
        $this->referrer = $this->getBaseUrl() . self::REFERRER_PATH;
        $this->headers["referrer"] = $this->referrer;

    }

    /**
     * Get the value of baseUrl
     *
     * @return string
     */
    public function getBaseUrl() :string
    {
        if ($this->debugMode) {
            return self::TEST_URL;
        }
        return self::BASE_URL;
    }

    /**
     * Get the value of debugMode
     *
     * @return bool
     */
    public function getDebugMode() :bool
    {

        return $this->debugMode;
    }

    /**
     * Setter function for debug mode
     *
     * @param boolean 
     * @return self
     */
    public function setDebugMode(bool $status)
    {

        $this->debugMode = $status;
        return $this;
    }

    /**
     * Get the value of referrer
     *
     * @return string
     */
    public function getReferrer() :string
    {

        return $this->referrer;
    }

    /**
     * Setter function for referrer
     *
     * @param string 
     * @return self
     */
    public function setReferrer(string $referrer)
    {
        
        $this->referrer = $referrer;
        return $this;
    }

    /**
     * Get the value of headers
     *
     * @return array
     */
    public function getHeaders() :array
    {

        return $this->headers;
    }

    /**
     * Setter function for headers
     *
     * @param array
     * @return self
     */
    public function setHeaders(array $headers)
    {

        $this->headers = $headers;
        return $this;
    }
}