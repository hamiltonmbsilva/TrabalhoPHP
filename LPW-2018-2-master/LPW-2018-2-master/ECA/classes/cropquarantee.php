<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 03/09/2018
 * Time: 22:13
 */


class cropquarantee
{
    private $id_garantia_safra;
    private $str_month;
    private $str_year;
    private $db_value;
    private $tb_city_id_city;
    private $tb_beneficiaries_id_beneficiaries;

    /**
     * cropquarantee constructor.
     * @param $id_garantia_safra
     * @param $str_month
     * @param $str_year
     * @param $db_value
     * @param $tb_city_id_city
     * @param $tb_beneficiaries_id_beneficiaries
     */
    public function __construct($id_garantia_safra, $str_month, $str_year, $db_value, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries)
    {
        $this->id_garantia_safra = $id_garantia_safra;
        $this->str_month = $str_month;
        $this->str_year = $str_year;
        $this->db_value = $db_value;
        $this->tb_city_id_city = $tb_city_id_city;
        $this->tb_beneficiaries_id_beneficiaries = $tb_beneficiaries_id_beneficiaries;
    }

    /**
     * @return mixed
     */
    public function getIdGarantiaSafra()
    {
        return $this->id_garantia_safra;
    }

    /**
     * @param mixed $id_garantia_safra
     */
    public function setIdGarantiaSafra($id_garantia_safra)
    {
        $this->id_garantia_safra = $id_garantia_safra;
    }

    /**
     * @return mixed
     */
    public function getStrMonth()
    {
        return $this->str_month;
    }

    /**
     * @param mixed $str_month
     */
    public function setStrMonth($str_month)
    {
        $this->str_month = $str_month;
    }

    /**
     * @return mixed
     */
    public function getStrYear()
    {
        return $this->str_year;
    }

    /**
     * @param mixed $str_year
     */
    public function setStrYear($str_year)
    {
        $this->str_year = $str_year;
    }

    /**
     * @return mixed
     */
    public function getDbValue()
    {
        return $this->db_value;
    }

    /**
     * @param mixed $db_value
     */
    public function setDbValue($db_value)
    {
        $this->db_value = $db_value;
    }

    /**
     * @return mixed
     */
    public function getTbCityIdCity()
    {
        return $this->tb_city_id_city;
    }

    /**
     * @param mixed $tb_city_id_city
     */
    public function setTbCityIdCity($tb_city_id_city)
    {
        $this->tb_city_id_city = $tb_city_id_city;
    }

    /**
     * @return mixed
     */
    public function getTbBeneficiariesIdBeneficiaries()
    {
        return $this->tb_beneficiaries_id_beneficiaries;
    }

    /**
     * @param mixed $tb_beneficiaries_id_beneficiaries
     */
    public function setTbBeneficiariesIdBeneficiaries($tb_beneficiaries_id_beneficiaries)
    {
        $this->tb_beneficiaries_id_beneficiaries = $tb_beneficiaries_id_beneficiaries;
    }




}