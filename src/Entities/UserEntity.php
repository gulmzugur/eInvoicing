<?php

/**
 * @author      Uğur Gülmez <gulmzugur@gmail.com>
 * @copyright   Copyright (c) Uğur Gülmez
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/gulmzugur/eInvoicing
 * 
**/

namespace eInvoicing\Entities;

class UserEntity 
{
    /**
     * @var string
     */
    protected $taxOrIdentityNumber;

    /**
     * @var string
     */
    protected $appellation;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $surname;

    /**
     * @var string
     */
    protected $registrationNo;

    /**
     * @var string
     */
    protected $mersisNo;

    /**
     * @var string
     */
    protected $taxAdministration;

    /**
     * @var string
     */
    protected $avenueStreet;

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
    protected $doorNo;

    /**
     * @var string
     */
    protected $town;

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
    protected $country;

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
     * @var string
     */
    protected $businessCenter;

    /**
     * Initialize function
     *
     * @param array $data
     */
    public function __construct($data = null)
    {
        if($data != null)
        {
            $this->taxOrIdentityNumber = $data["vknTckn"];
            $this->appellation         = $data["unvan"];
            $this->name                = $data["ad"];
            $this->surname             = $data["soyad"];
            $this->registrationNo      = $data["sicilNo"];
            $this->mersisNo            = $data["mersisNo"];
            $this->taxAdministration   = $data["vergiDairesi"];
            $this->avenueStreet        = $data["cadde"];
            $this->buildingName        = $data["apartmanAdi"];
            $this->buildingNumber      = $data["apartmanNo"];
            $this->doorNo              = $data["kapiNo"];
            $this->town                = $data["kasaba"];
            $this->district            = $data["ilce"];
            $this->city                = $data["il"];
            $this->postNumber          = $data["postaKodu"];
            $this->country             = $data["ulke"];
            $this->telephoneNumber     = $data["telNo"];
            $this->faxNumber           = $data["faksNo"];
            $this->email               = $data["ePostaAdresi"];
            $this->website             = $data["webSitesiAdresi"];
            $this->businessCenter      = $data["isMerkezi"];
        }
    }

    /**
     * Get the value of taxOrIdentityNumber
     */ 
    public function getTaxOrIdentityNumber() :string
    {
        return $this->taxOrIdentityNumber;
    }

    /**
     * Set the value of taxOrIdentityNumber
     *
     * @param string
     * 
     * @return  self
     */ 
    public function setTaxOrIdentityNumber(string $taxOrIdentityNumber)
    {
        $this->taxOrIdentityNumber = $taxOrIdentityNumber;

        return $this;
    }

    /**
     * Get the value of appellation
     */ 
    public function getAppellation() :string
    {

        return $this->appellation;
    }

    /**
     * Set the value of appellation
     *
     * @param string 
     * 
     * @return  self
     */ 
    public function setAppellation(string $appellation)
    {
        $this->appellation = $appellation;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName() :string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string 
     * 
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of surname
     */ 
    public function getSurname() :string
    {
        return $this->surname;
    }

    /**
     * Set the value of surname
     *
     * @param string $surname
     * @return  self
     */ 
    public function setSurname(string $surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get the value of registrationNo
     */ 
    public function getRegistrationNo() :string
    {
        return $this->registrationNo;
    }

    /**
     * Set the value of registrationNo
     *
     * @param string $registrationNo
     * @return  self
     */ 
    public function setRegistrationNo(string $registrationNo)
    {
        $this->registrationNo = $registrationNo;

        return $this;
    }

    /**
     * Get the value of mersisNo
     */ 
    public function getMersisNo() :string
    {
        return $this->mersisNo;
    }

    /**
     * Set the value of mersisNo
     *
     * @param string $mersisNo
     * @return  self
     */ 
    public function setMersisNo(string $mersisNo)
    {
        $this->mersisNo = $mersisNo;

        return $this;
    }

    /**
     * Get the value of taxAdministration
     */ 
    public function getTaxAdministration() :string
    {
        return $this->taxAdministration;
    }

    /**
     * Set the value of taxAdministration
     *
     * @param string
     * @return  self
     */ 
    public function setTaxAdministration(string $taxAdministration)
    {
        $this->taxAdministration = $taxAdministration;

        return $this;
    }

    /**
     * Get the value of avenueStreet
     */ 
    public function getAvenueStreet() :string
    {
        return $this->avenueStreet;
    }

    /**
     * Set the value of avenueStreet
     *
     * @param string 
     * @return  self
     */ 
    public function setAvenueStreet(string $avenueStreet)
    {
        $this->avenueStreet = $avenueStreet;

        return $this;
    }

    /**
     * Get the value of buildingName
     */ 
    public function getBuildingName() :string
    {
        return $this->buildingName;
    }

    /**
     * Set the value of buildingName
     *
     * @param string 
     * @return  self
     */ 
    public function setBuildingName(string $buildingName)
    {
        $this->buildingName = $buildingName;

        return $this;
    }

    /**
     * Get the value of buildingNumber
     */ 
    public function getBuildingNumber() :string
    {
        return $this->buildingNumber;
    }

    /**
     * Set the value of buildingNumber
     *
     * @param string 
     * @return  self
     */ 
    public function setBuildingNumber(string $buildingNumber)
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }

    /**
     * Get the value of doorNo
     */ 
    public function getDoorNo() :string
    {
        return $this->doorNo;
    }

    /**
     * Set the value of doorNo
     *
     * @param string 
     * @return  self
     */ 
    public function setDoorNo(string $doorNo)
    {
        $this->doorNo = $doorNo;

        return $this;
    }

    /**
     * Get the value of town
     */ 
    public function getTown() :string
    {
        return $this->town;
    }

    /**
     * Set the value of town
     *
     * @param string 
     * @return  self
     */ 
    public function setTown(string $town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get the value of district
     */ 
    public function getDistrict() :string
    {
        return $this->district;
    }

    /**
     * Set the value of district
     *
     * @param string 
     * @return  self
     */ 
    public function setDistrict(string $district) 
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity() :string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @param string 
     * @return  self
     */ 
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of postNumber
     */ 
    public function getPostNumber() :string
    {
        return $this->postNumber;
    }

    /**
     * Set the value of postNumber
     *
     * @param string 
     * @return  self
     */ 
    public function setPostNumber(string $postNumber)
    {
        $this->postNumber = $postNumber;

        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry() :string
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @param string 
     * @return  self
     */ 
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of telephoneNumber
     */ 
    public function getTelephoneNumber() :string
    {
        return $this->telephoneNumber;
    }

    /**
     * Set the value of telephoneNumber
     *
     * @param string 
     * @return  self
     */ 
    public function setTelephoneNumber(string $telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;

        return $this;
    }

    /**
     * Get the value of faxNumber
     */ 
    public function getFaxNumber() :string
    {
        return $this->faxNumber;
    }

    /**
     * Set the value of faxNumber
     *
     * @param string 
     * @return  self
     */ 
    public function setFaxNumber(string $faxNumber) 
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string 
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of website
     */ 
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set the value of website
     *
     * @param string 
     * @return  self
     */ 
    public function setWebsite(string $website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get the value of businessCenter
     */ 
    public function getBusinessCenter() :string
    {
        return $this->businessCenter;
    }

    /**
     * Set the value of businessCenter
     *
     * @param string 
     * @return  self
     */ 
    public function setBusinessCenter(string $businessCenter)
    {
        $this->businessCenter = $businessCenter;

        return $this;
    }

    /**
     * Exporting User Entity
     *
     * @return array
     */
    public function  userEntityExport() :array
    {

        $export = [

            "vknTckn"           => $this->taxOrIdentityNumber,
            "unvan"             => $this->appellation,
            "ad"                => $this->name,
            "soyad"             => $this->surname,
            "sicilNo"           => $this->registrationNo,
            "mersisNo"          => $this->mersisNo,
            "vergiDairesi"      => $this->taxAdministration,
            "bulvarcaddesokak"  => $this->avenueStreet,
            "binaAdi"           => $this->buildingName,
            "binaNo"            => $this->buildingNumber,
            "kapiNo"            => $this->doorNo,
            "kasabaKoy"         => $this->town,
            "mahalleSemtIlce"   => $this->district,
            "il"                => $this->city,
            "postaKodu"         => $this->postNumber,
            "ulke"              => $this->country,
            "tel"               => $this->telephoneNumber,
            "fax"               => $this->faxNumber,
            "eposta"            => $this->email,
            "websitesi"         => $this->website,
            "isMerkezi"         => $this->businessCenter

        ];

        return $export;
    }
}