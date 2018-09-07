<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 05/09/2018
 * Time: 21:30
 */

class peti
{
    private $id_peti;
    private $str_benefit_situation;
    private $db_value_plot;
    private $tb_city_id_city;
    private $tb_beneficiaries_id_beneficiaries;
    private $str_month_reference;
    private $str_year_reference;

    /**
     * peti constructor.
     * @param $id_peti
     * @param $str_benefit_situation
     * @param $db_value_plot
     * @param $tb_city_id_city
     * @param $tb_beneficiaries_id_beneficiaries
     * @param $str_month_reference
     * @param $str_year_reference
     */
    public function __construct($id_peti, $str_benefit_situation, $db_value_plot, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries, $str_month_reference, $str_year_reference)
    {
        $this->id_peti = $id_peti;
        $this->str_benefit_situation = $str_benefit_situation;
        $this->db_value_plot = $db_value_plot;
        $this->tb_city_id_city = $tb_city_id_city;
        $this->tb_beneficiaries_id_beneficiaries = $tb_beneficiaries_id_beneficiaries;
        $this->str_month_reference = $str_month_reference;
        $this->str_year_reference = $str_year_reference;
    }

    /**
     * @return mixed
     */
    public function getIdPeti()
    {
        return $this->id_peti;
    }

    /**
     * @param mixed $id_peti
     */
    public function setIdPeti($id_peti)
    {
        $this->id_peti = $id_peti;
    }

    /**
     * @return mixed
     */
    public function getStrBenefitSituation()
    {
        return $this->str_benefit_situation;
    }

    /**
     * @param mixed $str_benefit_situation
     */
    public function setStrBenefitSituation($str_benefit_situation)
    {
        $this->str_benefit_situation = $str_benefit_situation;
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
    public function getStrMonthReference()
    {
        return $this->str_month_reference;
    }

    /**
     * @param mixed $str_month_reference
     */
    public function setStrMonthReference($str_month_reference)
    {
        $this->str_month_reference = $str_month_reference;
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