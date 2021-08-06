<?php

/**
 * @author      Uğur Gülmez <gulmzugur@gmail.com>
 * @copyright   Copyright (c) Uğur Gülmez
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/gulmzugur/eInvoicing
 * 
 */

namespace eInvoicing\Entities; 

use eInvoicing\Exceptions\ValidatorException;

use Ramsey\Uuid\Uuid;

class InvoiceEntity
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $documentType = "FATURA";

    /**
     * @var string
     */
    protected $documentNumber;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var string
     */
    protected $time;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $currencyRate;

    /**
     * @var string
     */
    protected $invoiceType;

    /**
     * @var string
     */
    protected $whichType;

    /**
     * @var string
     */
    protected $taxOrIdentityNumber;

    /**
     * @var string
     */
    protected $invoiceAcceptorTitle;

    /**
     * @var string
     */
    protected $invoiceAcceptorName;

    /**
     * @var string
     */
    protected $invoiceAcceptorLastName;

    /**
     * @var string
     */
    protected $buildingName;

    /**
     * @var string
     */
    protected $buildingNumber;

    /**
     * @var string
     */
    protected $doorNumber;

    /**
     * @var string
     */
    protected $town;

    /**
     * @var string
     */
    protected $taxAdministration;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $avenueStreet;

    /**
     * @var string
     */
    protected $district;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $postNumber;

    /**
     * @var string
     */
    protected $telephoneNumber;

    /**
     * @var string
     */
    protected $faxNumber;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var array
     */
    protected $refundTable;

    /**
     * @var string
     */
    protected $specialBaseAmount;      // Özel Matrah Tutarı 

    /**
     * @var int
     */
    protected $specialBasePercent;     // Özel Matrah Oranı 

    /**
     * @var string
     */
    protected $specialBaseTaxAmount;   // Özel Matrah Vergi Tutarı 

    /**
     * @var string
     */
    protected $taxType;

    /**
     * @var array
     */
    protected $itemOrServiceList;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $base;                   // Matrah

    /**
     * @var int
     */
    protected $itemOrServiceTotalPrice;

    /**
     * @var string
     */
    protected $totalDiscount;

    /**
     * @var int
     */
    protected $calculatedVAT;

    /**
     * @var int
     */
    protected $taxTotalPrice;

    /**
     * @var int
     */
    protected $includedTaxesTotalPrice;

    /**
     * @var int
     */
    protected $paymentPrice;

    /**
     * @var string
     */
    protected $note;

    /**
     * @var string
     */
    protected $orderNumber;

    /**
     * @var string
     */
    protected $orderDate;

    /**
     * @var string
     */
    protected $waybillNumber;  

    /**
     * @var string
     */   
    protected $waybillDate;

    /**
     * @var string
     */
    protected $receiptNumber;

    /**
     * @var string
     */
    protected $voucherDate;

    /**
     * @var string
     */
    protected $voucherTime;

    /**
     * @var string
     */
    protected $voucherType;

    /**
     * @var string
     */
    protected $zReportNumber;

    /**
     * @var string
     */
    protected $okcSerialNumber;

    /**
     * Initialize function
     *
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if($data != null)
        {
            $this->uuid                     = $data["faturaUuid"];
            $this->documentNumber           = $data["belgeNumarasi"];
            $this->date                     = $data["faturaTarihi"];
            $this->time                     = $data["saat"];
            $this->currency                 = $data["paraBirimi"];
            $this->currencyRate             = $data["dovzTLkur"];
            $this->invoiceType              = $data["faturaTipi"];
            $this->whichType                = $data["hangiTip"];
            $this->taxOrIdentityNumber      = $data["vknTckn"];
            $this->invoiceAcceptorTitle     = $data["aliciUnvan"];
            $this->invoiceAcceptorName      = $data["aliciAdi"];
            $this->invoiceAcceptorLastName  = $data["aliciSoyadi"];
            $this->buildingName             = $data["binaAdi"];
            $this->buildingNumber           = $data["binaNo"];
            $this->doorNumber               = $data["kapiNo"];
            $this->town                     = $data["kasabaKoy"];
            $this->taxAdministration        = $data["vergiDairesi"];
            $this->country                  = $data["ulke"];
            $this->avenueStreet             = $data["bulvarcaddesokak"];
            $this->district                 = $data["mahalleSemtIlce"];
            $this->city                     = $data["sehir"];
            $this->postNumber               = $data["postaKodu"];
            $this->telephoneNumber          = $data["tel"];
            $this->faxNumber                = $data["fax"];
            $this->email                    = $data["eposta"];
            $this->website                  = $data["websitesi"];
            $this->refundTable              = $data["iadeTable"];
            $this->specialBaseAmount        = $data["ozelMatrahTutari"];
            $this->specialBasePercent       = $data["ozelMatrahOrani"];
            $this->specialBaseTaxAmount     = $data["ozelMatrahVergiTutari"];
            $this->taxType                  = $data["vergiCesidi"];
            $this->itemOrServiceList        = $data["malHizmetTable"];
            $this->type                     = $data["tip"];
            $this->base                     = $data["matrah"];
            $this->itemOrServiceTotalPrice  = $data["malhizmetToplamTutari"];
            $this->totalDiscount            = $data["toplamIskonto"];
            $this->calculatedVAT            = $data["hesaplanankdv"];
            $this->taxTotalPrice            = $data["vergilerToplami"];
            $this->includedTaxesTotalPrice  = $data["vergilerDahilToplamTutar"];
            $this->paymentPrice             = $data["odenecekTutar"];
            $this->note                     = $data["not"];
            $this->orderNumber              = $data["siparisNumarasi"];
            $this->orderDate                = $data["siparisTarihi"];
            $this->waybillNumber            = $data["irsaliyeNumarasi"];
            $this->waybillDate              = $data["irsaliyeTarihi"];
            $this->receiptNumber            = $data["fisNo"];
            $this->voucherDate              = $data["fisTarihi"];
            $this->voucherTime              = $data["fisSaati"];
            $this->voucherType              = $data["fisTipi"];
            $this->zReportNumber            = $data["zRaporNo"];
            $this->okcSerialNumber          = $data["okcSeriNo"];

            $this->checkIt($data);
        }
    }

    /**
     * Get the value of uuid
     * 
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @param string 
     * 
     * @return  self
     */
    public function setUuid($uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new ValidatorException("UUID Incorrect");
        }

        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get the value of documentType
     * 
     * @return string
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Set the value of documentType
     *
     * @param string 
     * 
     * @return  self
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * Get the value of documentNumber
     * 
     * @return string
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    /**
     * Set the value of documentNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setDocumentNumber($documentNumber)
    {
        $this->documentNumber = $documentNumber;

        return $this;
    }

    /**
     * Get the value of date
     * 
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param string 
     * 
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of time
     * 
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get the value of currency
     * 
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @param string 
     * 
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of currencyRate
     * 
     * @return string
     */
    public function getCurrencyRate()
    {
        return $this->currencyRate;
    }

    /**
     * Set the value of currencyRate
     *
     * @param string 
     * 
     * @return  self
     */
    public function setCurrencyRate($currencyRate)
    {
        $this->currencyRate = $currencyRate;

        return $this;
    }

    /**
     * Get the value of invoiceType
     * 
     * @return string
     */
    public function getInvoiceType()
    {
        return $this->invoiceType;
    }

    /**
     * Set the value of invoiceType
     *
     * @param string 
     * 
     * @return  self
     */
    public function setInvoiceType($invoiceType)
    {
        $this->invoiceType = $invoiceType;

        return $this;
    }

    /**
     * Get the value of whichType
     * 
     * @return string
     */
    public function getWhichType()
    {
        return $this->whichType;
    }

    /**
     * Set the value of invoiceType
     *
     * @param string 
     * 
     * @return  self
     */
    public function setWhichType($whichType)
    {
        $this->whichType = $whichType;

        return $this;
    }

    /**
     * Get the value of taxOrIdentityNumber
     * 
     * @return string
     */
    public function getTaxOrIdentityNumber()
    {
        return $this->taxOrIdentityNumber ? $this->taxOrIdentityNumber : "11111111111";
    }

    /**
     * Set the value of taxOrIdentityNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTaxOrIdentityNumber($taxOrIdentityNumber)
    {
        $this->taxOrIdentityNumber = $taxOrIdentityNumber;

        return $this;
    }

    /**
     * Get the value of invoiceAcceptorTitle
     * 
     * @return string
     */
    public function getInvoiceAcceptorTitle()
    {
        return $this->invoiceAcceptorTitle;
    }

    /**
     * Set the value of invoiceAcceptorTitle
     *
     * @param string 
     * 
     * @return  self
     */
    public function setInvoiceAcceptorTitle($invoiceAcceptorTitle)
    {
        $this->invoiceAcceptorTitle = $invoiceAcceptorTitle;

        return $this;
    }

    /**
     * Get the value of invoiceAcceptorName
     * 
     * @return string
     */
    public function getInvoiceAcceptorName()
    {
        return $this->invoiceAcceptorName;
    }

    /**
     * Set the value of invoiceAcceptorName
     *
     * @param string 
     * 
     * @return  self
     */
    public function setInvoiceAcceptorName($invoiceAcceptorName)
    {
        $this->invoiceAcceptorName = $invoiceAcceptorName;

        return $this;
    }

    /**
     * Get the value of invoiceAcceptorLastName
     * 
     * @return string
     */
    public function getInvoiceAcceptorLastName()
    {
        return $this->invoiceAcceptorLastName;
    }

    /**
     * Set the value of invoiceAcceptorLastName
     *
     * @param string 
     * 
     * @return  self
     */
    public function setInvoiceAcceptorLastName($invoiceAcceptorLastName)
    {
        $this->invoiceAcceptorLastName = $invoiceAcceptorLastName;

        return $this;
    }

    /**
     * Get the value of buildingName
     * 
     * @return string
     */
    public function getBuildingName()
    {
        return $this->buildingName;
    }

    /**
     * Set the value of buildingName
     *
     * @param string 
     * 
     * @return  self
     */
    public function setBuildingName($buildingName)
    {
        $this->buildingName = $buildingName;

        return $this;
    }

    /**
     * Get the value of buildingNumber
     * 
     * @return string
     */
    public function getBuildingNumber()
    {
        return $this->buildingNumber;
    }

    /**
     * Set the value of buildingNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setBuildingNumber($buildingNumber)
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }

    /**
     * Get the value of doorNumber
     * 
     * @return string
     */
    public function getDoorNumber()
    {
        return $this->doorNumber;
    }

    /**
     * Set the value of doorNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setDoorNumber($doorNumber)
    {
        $this->doorNumber = $doorNumber;

        return $this;
    }

    /**
     * Get the value of town
     * 
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set the value of town
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get the value of taxAdministration
     * 
     * @return string
     */
    public function getTaxAdministration()
    {
        return $this->taxAdministration;
    }

    /**
     * Set the value of taxAdministration
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTaxAdministration($taxAdministration)
    {
        $this->taxAdministration = $taxAdministration;

        return $this;
    }

    /**
     * Get the value of country
     * 
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @param string 
     * 
     * @return  self
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of avenueStreet
     * 
     * @return string
     */
    public function getAvenueStreet()
    {
        return $this->avenueStreet;
    }

    /**
     * Set the value of avenueStreet
     *
     * @param string 
     * 
     * @return  self
     */
    public function setAvenueStreet($avenueStreet)
    {
        $this->avenueStreet = $avenueStreet;

        return $this;
    }

    /**
     * Get the value of district
     * 
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set the value of district
     *
     * @param string 
     * 
     * @return  self
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get the value of city
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @param string 
     * 
     * @return  self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of postNumber
     * 
     * @return string
     */
    public function getPostNumber()
    {
        return $this->postNumber;
    }

    /**
     * Set the value of postNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setPostNumber($postNumber)
    {
        $this->postNumber = $postNumber;

        return $this;
    }

    /**
     * Get the value of telephoneNumber
     * 
     * @return string
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * Set the value of telephoneNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;

        return $this;
    }

    /**
     * Get the value of faxNumber
     * 
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * Set the value of faxNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * Get the value of email
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string 
     * 
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of website
     * 
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set the value of website
     *
     * @param string 
     * 
     * @return  self
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get the value of refundTable
     * 
     * @return string
     */
    public function getRefundTable()
    {
        return $this->refundTable;
    }

    /**
     * Set the value of refundTable
     *
     * @param array 
     * 
     * @return  self
     */
    public function setRefundTable($refundTable)
    {
        $this->refundTable = $refundTable;

        return $this;
    }

    /**
     * Get the value of specialBaseAmount
     * 
     * @return string
     */
    public function getSpecialBaseAmount()
    {
        return $this->specialBaseAmount;
    }

    /**
     * Set the value of specialBaseAmount
     *
     * @param string 
     * 
     * @return  self
     */
    public function setSpecialBaseAmount($specialBaseAmount)
    {
        $this->specialBaseAmount = $specialBaseAmount;

        return $this;
    }

    /**
     * Get the value of specialBasePercent
     * 
     * @return string
     */
    public function getSpecialBasePercent() :int
    {
        return $this->specialBasePercent;
    }

    /**
     * Set the value of specialBasePercent
     *
     * @param string 
     * 
     * @return  self
     */
    public function setSpecialBasePercent(int $specialBasePercent)
    {
        $this->specialBasePercent = $specialBasePercent;

        return $this;
    }

    /**
     * Get the value of specialBaseTaxAmount
     * 
     * @return string
     */
    public function getSpecialBaseTaxAmount()
    {
        return $this->specialBaseTaxAmount;
    }

    /**
     * Set the value of specialBaseTaxAmount
     *
     * @param string 
     * 
     * @return  self
     */
    public function setSpecialBaseTaxAmount($specialBaseTaxAmount)
    {
        $this->specialBaseTaxAmount = $specialBaseTaxAmount;

        return $this;
    }

    /**
     * Get the value of taxType
     * 
     * @return string
     */
    public function getTaxType()
    {
        return $this->taxType;
    }

    /**
     * Set the value of taxType
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTaxType($taxType)
    {
        $this->taxType = $taxType;

        return $this;
    }

    /**
     * Get the value of itemOrServiceList
     * 
     * @return string
     */
    public function getItemOrServiceList()
    {
        return $this->itemOrServiceList;
    }

    /**
     * Set the value of itemOrServiceList
     *
     * @param string 
     * 
     * @return  self
     */
    public function setItemOrServiceList($itemOrServiceList)
    {
        $this->itemOrServiceList = $itemOrServiceList;

        return $this;
    }

    /**
     * Get the value of type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string 
     * 
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of base
     * 
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set the value of base
     *
     * @param string 
     * 
     * @return  self
     */
    public function setBase($base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get the value of itemOrServiceTotalPrice
     * 
     * @return string
     */
    public function getItemOrServiceTotalPrice()
    {
        return $this->itemOrServiceTotalPrice;
    }

    /**
     * Set the value of itemOrServiceTotalPrice
     *
     * @param string 
     * 
     * @return  self
     */
    public function setItemOrServiceTotalPrice($itemOrServiceTotalPrice)
    {
        $this->itemOrServiceTotalPrice = $itemOrServiceTotalPrice;

        return $this;
    }

    /**
     * Get the value of totalDiscount
     * 
     * @return string
     */
    public function getTotalDiscount()
    {
        return $this->totalDiscount;
    }

    /**
     * Set the value of totalDiscount
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTotalDiscount($totalDiscount)
    {
        $this->totalDiscount = $totalDiscount;

        return $this;
    }

    /**
     * Get the value of calculatedVAT
     * 
     * @return string
     */
    public function getCalculatedVAT()
    {
        return $this->calculatedVAT;
    }

    /**
     * Set the value of calculatedVAT
     *
     * @param string 
     * 
     * @return  self
     */
    public function setCalculatedVAT($calculatedVAT)
    {
        $this->calculatedVAT = $calculatedVAT;

        return $this;
    }

    /**
     * Get the value of taxTotalPrice
     * 
     * @return string
     */
    public function getTaxTotalPrice()
    {
        return $this->taxTotalPrice;
    }

    /**
     * Set the value of taxTotalPrice
     *
     * @param string 
     * 
     * @return  self
     */
    public function setTaxTotalPrice($taxTotalPrice)
    {
        $this->taxTotalPrice = $taxTotalPrice;

        return $this;
    }

    /**
     * Get the value of includedTaxesTotalPrice
     * 
     * @return string
     */
    public function getIncludedTaxesTotalPrice()
    {
        return $this->includedTaxesTotalPrice;
    }

    /**
     * Set the value of includedTaxesTotalPrice
     *
     * @param string 
     * 
     * @return  self
     */
    public function setIncludedTaxesTotalPrice($includedTaxesTotalPrice)
    {
        $this->includedTaxesTotalPrice = $includedTaxesTotalPrice;

        return $this;
    }

    /**
     * Get the value of paymentPrice
     * 
     * @return string
     */
    public function getPaymentPrice()
    {
        return $this->paymentPrice;
    }

    /**
     * Set the value of paymentPrice
     *
     * @param string 
     * 
     * @return  self
     */
    public function setPaymentPrice($paymentPrice)
    {
        $this->paymentPrice = $paymentPrice;

        return $this;
    }

    /**
     * Get the value of note
     * 
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @param string 
     * 
     * @return  self
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of orderNumber
     * 
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set the value of orderNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get the value of orderDate
     * 
     * @return string
     */
    public function getOrderDate()
    {
        return $this->orderData;
    }

    /**
     * Set the value of orderDate
     *
     * @param string 
     * 
     * @return  self
     */
    public function setOrderDate($orderData)
    {
        $this->orderData = $orderData;

        return $this;
    }

    /**
     * Get the value of waybillNumber
     * 
     * @return string
     */
    public function getWaybillNumber()
    {
        return $this->waybillNumber;
    }

    /**
     * Set the value of waybillNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setWaybillNumber($waybillNumber)
    {
        $this->waybillNumber = $waybillNumber;

        return $this;
    }

    /**
     * Get the value of waybillDate
     * 
     * @return string
     */
    public function getWaybillDate()
    {
        return $this->waybillDate;
    }

    /**
     * Set the value of waybillDate
     *
     * @param string 
     * 
     * @return  self
     */
    public function setWaybillDate($waybillDate)
    {
        $this->waybillDate = $waybillDate;

        return $this;
    }

    /**
     * Get the value of receiptNumber
     * 
     * @return string
     */
    public function getReceiptNumber()
    {
        return $this->receiptNumber;
    }

    /**
     * Set the value of receiptNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setReceiptNumber($receiptNumber)
    {
        $this->receiptNumber = $receiptNumber;

        return $this;
    }

    /**
     * Get the value of voucherDate
     * 
     * @return string
     */
    public function getVoucherDate()
    {
        return $this->voucherDate;
    }

    /**
     * Set the value of voucherDate
     *
     * @param string 
     * 
     * @return  self
     */
    public function setVoucherDate($voucherDate)
    {
        $this->voucherDate = $voucherDate;

        return $this;
    }

    /**
     * Get the value of voucherTime
     * 
     * @return string
     */
    public function getVoucherTime()
    {
        return $this->voucherTime;
    }

    /**
     * Set the value of voucherTime
     *
     * @param string 
     * 
     * @return  self
     */
    public function setVoucherTime($voucherTime)
    {
        $this->voucherTime = $voucherTime;

        return $this;
    }

    /**
     * Get the value of voucherType
     * 
     * @return string
     */
    public function getVoucherType()
    {
        return $this->voucherType;
    }

    /**
     * Set the value of voucherType
     *
     * @param string 
     * 
     * @return  self
     */
    public function setVoucherType($voucherType)
    {
        $this->voucherType = $voucherType;

        return $this;
    }

    /**
     * Get the value of zReportNumber
     * 
     * @return string
     */
    public function getZReportNumber()
    {
        return $this->zReportNumber;
    }

    /**
     * Set the value of zReportNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setZReportNumber($zReportNumber)
    {
        $this->zReportNumber = $zReportNumber;

        return $this;
    }

    /**
     * Get the value of okcSerialNumber
     * 
     * @return string
     */
    public function getOkcSerialNumber()
    {
        return $this->okcSerialNumber;
    }

    /**
     * Set the value of okcSerialNumber
     *
     * @param string 
     * 
     * @return  self
     */
    public function setOkcSerialNumber($okcSerialNumber)
    {
        $this->okcSerialNumber = $okcSerialNumber;

        return $this;
    }

    /**
     * Exporting Invoice Entity
     *
     * @return array
     */
    public function invoiceEntityExport() :array
    {

        $export = [
            "faturaUuid"                => $this->uuid,
            "belgeNumarasi"             => $this->documentNumber,
            "faturaTarihi"              => $this->date,
            "saat"                      => $this->time,
            "paraBirimi"                => $this->currency,
            "dovzTLkur"                 => $this->currencyRate,
            "faturaTipi"                => $this->invoiceType,
            "hangiTip"                  => $this->whichType,
            "vknTckn"                   => $this->taxOrIdentityNumber,
            "aliciUnvan"                => $this->invoiceAcceptorTitle,
            "aliciAdi"                  => $this->invoiceAcceptorName,
            "aliciSoyadi"               => $this->invoiceAcceptorLastName,
            "binaAdi"                   => $this->buildingName,
            "binaNo"                    => $this->buildingNumber,
            "kapiNo"                    => $this->doorNumber,
            "kasabaKoy"                 => $this->town,
            "vergiDairesi"              => $this->taxAdministration,
            "ulke"                      => $this->country,
            "bulvarcaddesokak"          => $this->avenueStreet,
            "mahalleSemtIlce"           => $this->district,
            "sehir"                     => $this->city,
            "postaKodu"                 => $this->postNumber,
            "tel"                       => $this->telephoneNumber,
            "fax"                       => $this->faxNumber,
            "eposta"                    => $this->email,
            "websitesi"                 => $this->website,
            "iadeTable"                 => $this->refundTable,
            "ozelMatrahTutari"          => $this->specialBaseAmount,
            "ozelMatrahOrani"           => $this->specialBasePercent,
            "ozelMatrahVergiTutari"     => $this->specialBaseTaxAmount,
            "vergiCesidi"               => $this->taxType,
            "malHizmetTable"            => $this->itemOrServiceList,
            "tip"                       => $this->type,
            "matrah"                    => $this->base,
            "malhizmetToplamTutari"     => $this->itemOrServiceTotalPrice,
            "toplamIskonto"             => $this->totalDiscount,
            "hesaplanankdv"             => $this->calculatedVAT,
            "vergilerToplami"           => $this->taxTotalPrice,
            "vergilerDahilToplamTutar"  => $this->includedTaxesTotalPrice,
            "odenecekTutar"             => $this->paymentPrice,
            "not"                       => $this->note,
            "siparisNumarasi"           => $this->orderNumber,
            "siparisTarihi"             => $this->orderDate,
            "irsaliyeNumarasi"          => $this->waybillNumber,
            "irsaliyeTarihi"            => $this->waybillDate,
            "fisNo"                     => $this->receiptNumber,
            "fisTarihi"                 => $this->voucherDate,
            "fisSaati"                  => $this->voucherTime,
            "fisTipi"                   => $this->voucherType,
            "zRaporNo"                  => $this->zReportNumber,
            "okcSeriNo"                 => $this->okcSerialNumber
        ];

        return $export;
    }

    /**
     * Get invoice summary fields
     *
     * @return array
     */
    public function getInvoiceSummary () :array
    {

        $summary = [
            "belgeNumarasi"     => $this->documentNumber,
            "aliciVknTckn"      => $this->taxOrIdentityNumber,
            "aliciUnvanAdSoyad" => $this->invoiceAcceptorTitle,
            "belgeTarihi"       => $this->date,
            "belgeTuru"         => $this->documentType,
            "ettn"              => $this->uuid
        ];

        return $summary;
    }

    /**
     * Data insert checks
     *
     * @param array $data
     * @return void
     */
    private function checkIt(array $data) :void
    {
        if (isset($data["uuid"])) {
            if (!Uuid::isValid($data["uuid"])) {
                throw new ValidatorException("UUID Incorrect");
            }
        }

        if (isset($data["faturaUuid"])) {
            if (!Uuid::isValid($data["faturaUuid"])) {
                throw new ValidatorException("UUID Incorrect");
            }
        }
    }
}