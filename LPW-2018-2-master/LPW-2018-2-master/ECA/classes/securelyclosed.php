<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 05/09/2018
 * Time: 21:31
 */

class securelyclosed
{
    private $id_securely_closed;
    private $db_value_plot;
    private $tb_city_id_city;
    private $tb_beneficiaries_id_beneficiaries;
    private $str_month_refence;
    private $str_year_reference;

    /**
     * securelyclosed constructor.
     * @param $id_securely_closed
     * @param $db_value_plot
     * @param $tb_city_id_city
     * @param $tb_beneficiaries_id_beneficiaries
     * @param $str_month_refence
     * @param $str_year_reference
     */
    public function __construct($id_securely_closed, $db_value_plot, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries, $str_month_refence, $str_year_reference)
    {
        $this->id_securely_closed = $id_securely_closed;
        $this->db_value_plot = $db_value_plot;
        $this->tb_city_id_city = $tb_city_id_city;
        $this->tb_beneficiaries_id_beneficiaries = $tb_beneficiaries_id_beneficiaries;
        $this->str_month_refence = $str_month_refence;
        $this->str_year_reference = $str_year_reference;
    }

    /**
     * @return mixed
     */
    public function getIdSecurelyClosed()
    {
        return $this->id_securely_closed;
    }

    /**
     * @param mixed $id_securely_closed
     */
    public function setIdSecurelyClosed($id_securely_closed)
    {
        $this->id_securely_closed = $id_securely_closed;
    }

    /**
     * @return mixed
     */
    public function getDbValuePlot()
    {
        return $this->db_value_plot;
    }

    /**
     * @param mixed $db_value_plot
     */
    public function setDbValuePlot($db_value_plot)
    {
        $this->db_value_plot = $db_value_plot;
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

    /**
     * @return mixed
     */
    public function getStrMonthRefence()
    {
        return $this->str_month_refence;
    }

    /**
     * @param mixed $str_month_refence
     */
    public function setStrMonthRefence($str_month_refence)
    {
        $this->str_month_refence = $str_month_refence;
    }

    /**
     * @return mixed
     */
    public function getStrYearReference()
    {
        return $this->str_year_reference;
    }

    /**
     * @param mixed $str_year_reference
     */
    public function setStrYearReference($str_year_reference)
    {
        $this->str_year_reference = $str_year_reference;
    }




}