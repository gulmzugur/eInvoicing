<?php

/**
 * @author      Uğur Gülmez <gulmzugur@gmail.com>
 * @copyright   Copyright (c) Uğur Gülmez
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/gulmzugur/eInvoicing
 * 
 */

namespace eInvoicing;

use eInvoicing\Exceptions\TestEnvironmentException;
use eInvoicing\Exceptions\ServicesException;
use eInvoicing\Exceptions\DataException;

use eInvoicing\Config\ServiceConfig;
use eInvoicing\Entities\InvoiceEntity;
use eInvoicing\Entities\UserEntity;

use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use Mpdf\Mpdf;

class InvoiceManager
{

    /**
     * config variable
     *
     * @var eInvoicing\Config\ServiceConfig
     */
    protected $config;

    /**
     * Username field for auth
     *
     * @var string
     */
    protected $username;

    /**
     * Password field for auth
     *
     * @var string
     */
    protected $password;

    /**
     * Guzzle client variable
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Session Token
     *
     * @var string
     */
    protected $token;

    /**
     * Operation identifier
     *
     * @var string
     */
    protected $oId;

    /**
     * Current targeted invoice
     *
     * @var eInvoicing\Repositories\InvoiceRepository
     */
    protected $invoice;

    /**
     * Current targeted invoices
     *
     * @var eInvoicing\Repositories\InvoiceRepository
     */
    protected $invoices = [];

    /**
     * User Informations
     *
     * @var eInvoicing\Repositories\UserRepository
     */
    protected $userInformations;

    /**
     * Base constructor method for and connection settings
     */
    public function __construct()
    {
        $this->config = new ServiceConfig();

        $this->client = new Client($this->config->getHeaders());
    }

    /**
     * Setter function for all test credentials
     *
     * @return self
     */
    public function setTestCredentials()  
    {
        
        $response = $this->client->post($this->config->getBaseUrl().ServiceConfig::TESTCRENDENTIALS_PATH,[
            "form_params" => [
                "assoscmd"  => "kullaniciOner",
                "rtype"     => "json",
            ]
        ]);
        $body = json_decode($response->getBody(), true);

        $this->checkError($body);

        if (isset($body["userid"]) && $body["userid"] == "") {
            throw new TestEnvironmentException("Failed to get e-Archive test user. Please try later.");
        }

        $this->username = $body["userid"];
        $this->password = "1";
        return $this;
    }

    /**
     * Setter function for all credentials
     *
     * @param string $username
     * @param string $password
     * @return self
     */
    public function setCredentials(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        return $this;
    }

    /**
     * Get all credentials as an array
     *
     * @return array
     */
    public function getCredentials() :array
    {
        return [
            $this->username,
            $this->password
        ];
    }

    /**
     * Setter function for token
     *
     * @param string
     * @return self
     */
    public function setToken(string $token)
    {

        $this->token = $token;
        return $this;
    }

    /**
     * Get the value of token
     *
     * @return string
     */
    public function getToken() :string
    {

        return $this->token;
    }

    // --------------------------------------------------------------------

    /**
     * Send request, json decode and return response
     *
     * @param  string $url
     * @param  array  $parameters
     * @param  array  $headers
     * @return array  $body
     */
    private function sendRequestAndGetBody(string $url, array $parameters, array $headers = []) :array
    {
        $response = $this->client->post($this->config->getBaseUrl() . "$url", [
            "headers"       => $headers ? $headers : $this->config->getHeaders(),
            "form_params"   => $parameters
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * Get auth token as a string
     *
     * @return string
     */
    public function getTokenFromApi() :string
    {
        $parameters = [
            "assoscmd"  => $this->config->getDebugMode() ? "login" : "anologin",
            "rtype"     => "json",
            "userid"    => $this->username,
            "sifre"     => $this->password,
            "sifre2"    => $this->password,
            "parola"    => "1"
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::TOKEN_PATH, $parameters, []);
        $this->checkError($body);

        return $this->token = $body["token"];
    }

    /**
     * Connect with credentials
     *
     * @return self
     */
    public function connect()
    {

        $this->getTokenFromApi();
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Initialize SMS Verification
     *
     * @return boolean
     */
    private function initializeSMSVerification() :bool
    {
        $parameters = [
            "cmd"       => "EARSIV_PORTAL_TELEFONNO_SORGULA",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_BASITTASLAKLAR",
            "token"     => $this->token,
            "jp"        => "{}",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        if(!isset($body["data"]["telefon"]))
        {
            return false;
        }

        return true;
    }
    
    /**
     * Send SMS Verification
     *
     * @param  string $phoneNumber
     * @return string
     */
    public function sendSMSVerification(string $phoneNumber) :string
    {
        $this->initializeSMSVerification();
        
        $data = [
            "CEPTEL"    => $phoneNumber,
            "KCEPTEL"   => false,
            "TIP"       => ""
        ];

        $parameters = [
            "cmd"       => "EARSIV_PORTAL_SMSSIFRE_GONDER",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_SMSONAY",
            "token"     => $this->token,
            "jp"        => "" . json_encode($data) . "",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        $this->oId = $body["data"]["oid"];

        return $this->oId;
    }

    /**
     * Verify SMS code
     *
     * @param  string $code
     * @param  string $operationId
     * @return boolen
     */
    public function verifySMSCode(string $code, string $operationId) :boolen
    {
        $data = [
            "SIFRE" => $code,
            "OID"   => $operationId,
            'OPR'   => 1,
            'DATA'  => $this->invoices,
        ];

        $parameters = [
            "cmd"       => "0lhozfib5410mp",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_SMSONAY",
            "token"     => $this->token,
            "jp"        => "" . json_encode($data) . "",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        if(!isset($body["data"]["sonuc"]))
        {
            return false;
        }
        
        if($body["data"]["sonuc"] == 0)
        {
            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Get main three menu from api
     *
     * @return array
     */
    public function getMainTreeMenuFromAPI() : array
    {
        $headers = [
            "referrer" => $this->config->getReferrer()
        ];

        $parameters = [
            "cmd"       => "getUserMenu",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "MAINTREEMENU",
            "token"     => $this->token,
            "jp"        => '{"ANONIM_LOGIN":"1"}'
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters, $headers);
        $this->checkError($body);

        return $body["data"];
    }


    // --------------------------------------------------------------------

    /**
     * Get company name from tax number via api
     *
     * @param  string $taxNr
     * @return array
     */
    public function getCompanyInfo(string $taxNr) :array
    {
        $parameters = [
            "cmd"       => "SICIL_VEYA_MERNISTEN_BILGILERI_GETIR",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_BASITFATURA",
            "token"     => $this->token,
            "jp"        => '{"vknTcknn":"' . $taxNr . '"}'
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        return $body;
    }

    // --------------------------------------------------------------------

    /**
     * Setter function for invoice
     *
     * @param  InvoiceEntity $invoice
     * @return self
     */
    public function setInvoice(InvoiceEntity $invoice)
    {

        $this->invoice = $invoice;
        return $this;
    }

    /**
     * Getter function for invoice
     *
     * @return 
     */
    public function getInvoice()
    {

        return $this->invoice;
    }

    /**
     * Getter function for invoices
     *
     * @return 
     */
    public function getInvoices()
    {

        return $this->invoices;
    }

    // --------------------------------------------------------------------

    /**
     * Get invoices from api
     *
     * @param  string $startDate
     * @param  string $endDate
     * @return array
     */
    public function getInvoicesFromAPI(string $startDate, string $endDate) :array
    {
        $parameters = [
            "cmd"       => "EARSIV_PORTAL_TASLAKLARI_GETIR",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_BASITTASLAKLAR",
            "token"     => $this->token,
            "jp"        => '{"baslangic":"' .$startDate. '","bitis":"' .$endDate. '","hangiTip":"5000/30000", "table":[]}'
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);
        // Invoices with the date given from the array type
        $this->invoices = $body['data'];

        return $body;
    }

    /**
     * Get Invoices via API
     *
     * @param  string $startDate
     * @param  string $endDate
     * @param  array $ettn
     * @return array
     */
    public function getEttnInvoiceFromAPIArray(string $startDate, string $endDate, array $ettn) :array
    {
        $parameters = [
            "cmd"       => "EARSIV_PORTAL_TASLAKLARI_GETIR",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_BASITTASLAKLAR",
            "token"     => $this->token,
            "jp"        => '{"baslangic":"' . $startDate . '","bitis":"' . $endDate . '","hangiTip":"5000/30000", "table":[]}'
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);
        $data = $body['data'];
        $dataFiltered = array();
        foreach($data as $item){
            if($item["onayDurumu"] == "Onaylanmadı" && in_array($item["ettn"], $ettn)){
                array_push($dataFiltered, $item);
            }
        }
        $this->invoices = $dataFiltered;
        return $dataFiltered;
    }

    // --------------------------------------------------------------------

    /**
     * Create draft basic invoice
     *
     * @param  InvoiceEntity $invoice
     * @return self
     */
    public function createDraftBasicInvoice(InvoiceEntity $invoice = null)
    {

        if ($invoice != null) {
            $this->invoice = $invoice;
        }

        if ($this->invoice == null) {
            throw new DataException("Invoice variable not exist");
        }

        $parameters = [
            "cmd"       => "EARSIV_PORTAL_FATURA_OLUSTUR",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_BASITFATURA",
            "token"     => $this->token,
            "jp"        => "" . json_encode($this->invoice->invoiceEntityExport()) . ""
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        if ($body["data"] != "Faturanız başarıyla oluşturulmuştur. Düzenlenen Belgeler menüsünden faturanıza ulaşabilirsiniz.") {
            throw new ServicesException("Failed to create invoice.", 0, null, $body);
        }

        return $this;
    }

    /**
     * Get an invoice from API
     *
     * @param  InvoiceEntity $invoice
     * @return array
     */
    public function getInvoiceFromAPI(InvoiceEntity $invoice = null) :array
    {
        if ($invoice != null) {
            $this->invoice = $invoice;
        }

        if ($this->invoice == null) {
            throw new DataException("Invoice variable not exist");
        }

        $data = [
            "ettn" => $this->invoice->getUuid()
        ];

        $parameters = [
            "cmd"       => "EARSIV_PORTAL_FATURA_GETIR",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_BASITFATURA",
            "token"     => $this->token,
            "jp"        => "" . json_encode($data) . "",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);

        $this->checkError($body);

        return $body["data"];
    }

    /**
     * Cancel an invoice
     *
     * @param  InvoiceEntity $invoice
     * @param  string $explanation
     * @return boolean
     */
    public function cancelInvoice(InvoiceEntity $invoice = null, string $explanation) :bool
    {
        if ($invoice != null) {
            $this->invoice = $invoice;
        }

        if ($this->invoice == null) {
            throw new DataException("Invoice variable not exist");
        }

        $data = [
            "silinecekler"  => [$this->invoice->getInvoiceSummary()],
            "aciklama"      => $explanation
        ];

        $parameters = [
            "cmd"       => "EARSIV_PORTAL_FATURA_SIL",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_BASITTASLAKLAR",
            "token"     => $this->token,
            "jp"        => "" . json_encode($data) . "",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        if (strpos($body["data"], " fatura başarıyla silindi.") == false) {
            throw new ServicesException("The invoice could not be canceled.", 0, null, $body);
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Get html invoice
     *
     * @param  InvoiceEntity $invoice
     * @param  boolean $signed
     * @return string
     */
    public function getInvoiceHTML(InvoiceEntity $invoice = null, bool $signed = true) :string
    {
        if ($invoice != null) {
            $this->invoice = $invoice;
        }

        if ($this->invoice == null) {
            throw new DataException("Invoice variable not exist");
        }

        $data = [
            "ettn"       => $this->invoice->getUuid(),
            "onayDurumu" => $signed ? "Onaylandı" : "Onaylanmadı"
        ];

        $parameters = [
            "cmd"       => "EARSIV_PORTAL_FATURA_GOSTER",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_TASLAKLAR",
            "token"     => $this->token,
            "jp"        => "" . json_encode($data) . "",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        return $body["data"];
    }

    /**
     * PDF Export
     *
     * @param  InvoiceEntity $invoice
     * @param  boolean $signed
     * @return Mpdf\Mpdf
     */
   
    public function getInvoicePDF(InvoiceEntity $invoice = null, bool $signed = true)
    {

        $data = $this->getInvoiceHTML($invoice, $signed);
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($data);
        return $mpdf->Output();
    }

    /**
     * Get download url
     *
     * @param  InvoiceEntity $invoice
     * @param  boolean $signed
     * @return string
     */
    public function getDownloadURL(InvoiceEntity $invoice = null, bool $signed = true) :string
    {
        if ($invoice != null) {
            $this->invoice = $invoice;
        }

        if ($this->invoice == null) {
            throw new DataException("Invoice variable not exist");
        }

        $signed = $signed ? "Onaylandı" : "Onaylanmadı";

        return $this->config->getBaseUrl().ServiceConfig::DOWNLOAD_PATH."?token={$this->token}
        &ettn={$this->invoice->getUuid()}&belgeTip=FATURA&onayDurumu={$signed}&cmd=EARSIV_PORTAL_BELGE_INDIR";
    }

    // --------------------------------------------------------------------

    /**
     * Set invoice manager user informations
     *
     * @param  UserEntity
     * @return self
     */
    public function setUserInformations(UserEntity $userInformations)
    {
        $this->userInformations = $userInformations;
        return $this;
    }

    /**
     * Get invoice manager user informations
     *
     * @return UserEntity
     */
    public function getUserInformations() :UserEntity
    {

        return $this->userInformations;
    }

    /**
     * Get user information via API
     *
     * @return UserEntity
     */
    public function getUserInformationsData() :UserEntity
    {
        $parameters = [
            "cmd"       => "EARSIV_PORTAL_KULLANICI_BILGILERI_GETIR",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_KULLANICI",
            "token"     => $this->token,
            "jp"        => "{}",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        $userInformations = new UserEntity($body["data"]);
        return $this->userInformations = $userInformations;
    }

    /**
     * Send user information data
     *
     * @param  UserEntity
     * @return string
     */
    public function sendUserInformationsData(UserEntity $userInformations = null) :string
    {
        if ($userInformations != null) {
            $this->userInformations = $userInformations;
        }

        if ($this->userInformations == null) {
            throw new DataException("User informations data not exist");
        }

        $parameters = [
            "cmd"       => "EARSIV_PORTAL_KULLANICI_BILGILERI_KAYDET",
            "callid"    => Uuid::uuid1()->toString(),
            "pageName"  => "RG_KULLANICI",
            "token"     => $this->token,
            "jp"        => "" . json_encode($this->userInformations->userEntityExport()) . "",
        ];

        $body = $this->sendRequestAndGetBody(ServiceConfig::DISPATCH_PATH, $parameters);
        $this->checkError($body);

        return $body["data"];
    }

    // --------------------------------------------------------------------

    /**
     * Check error, if exist throw it!
     *
     * @param  array
     * @return void
     */
    private function checkError(array $data)
    {
        if (isset($data["error"])) {
            throw new ServicesException("A server-side error has occurred!", 0, null, $data);

        }
    }
}