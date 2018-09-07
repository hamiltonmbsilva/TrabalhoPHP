<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 05/09/2018
 * Time: 21:32
 */

class familybaglooting
{
    private $id_familybag_looting;
    private $str_month_reference;
    private $str_year_reference;
    private $str_month_competence;
    private $str_year_competence;
    private $tb_city_id_city;
    private $tb_beneficiaries_id_beneficiaries;
    private $dt_date_withdrawal;
    private $db_saving_value;

    /**
     * familybaglooting constructor.
     * @param $id_familybag_looting
     * @param $str_month_reference
     * @param $str_year_reference
     * @param $str_month_competence
     * @param $str_year_competence
     * @param $tb_city_id_city
     * @param $tb_beneficiaries_id_beneficiaries
     * @param $dt_date_withdrawal
     * @param $db_saving_value
     */
    public function __construct($id_familybag_looting, $str_month_reference, $str_year_reference, $str_month_competence, $str_year_competence, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries, $dt_date_withdrawal, $db_saving_value)
    {
        $this->id_familybag_looting = $id_familybag_looting;
        $this->str_month_reference = $str_month_reference;
        $this->str_year_reference = $str_year_reference;
        $this->str_month_competence = $str_month_competence;
        $this->str_year_competence = $str_year_competence;
        $this->tb_city_id_city = $tb_city_id_city;
        $this->tb_beneficiaries_id_beneficiaries = $tb_beneficiaries_id_beneficiaries;
        $this->dt_date_withdrawal = $dt_date_withdrawal;
        $this->db_saving_value = $db_saving_value;
    }

    /**
     * @return mixed
     */
    public function getIdFamilybagLooting()
    {
        return $this->id_familybag_looting;
    }

    /**
     * @param mixed $id_familybag_looting
     */
    public function setIdFamilybagLooting($id_familybag_looting)
    {
        $this->id_familybag_looting = $id_familybag_looting;
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

    /**
     * @return mixed
     */
    public function getStrMonthCompetence()
    {
        return $this->str_month_competence;
    }

    /**
     * @param mixed $str_month_competence
     */
    public function setStrMonthCompetence($str_month_competence)
    {
        $this->str_month_competence = $str_month_competence;
    }

    /**
     * @return mixed
     */
    public function getStrYearCompetence()
    {
        return $this->str_year_competence;
    }

    /**
     * @param mixed $str_year_competence
     */
    public function setStrYearCompetence($str_year_competence)
    {
        $this->str_year_competence = $str_year_competence;
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
    public function getDtDateWithdrawal()
    {
        return $this->dt_date_withdrawal;
    }

    /**
     * @param mixed $dt_date_withdrawal
     */
    public function setDtDateWithdrawal($dt_date_withdrawal)
    {
        $this->dt_date_withdrawal = $dt_date_withdrawal;
    }

    /**
     * @return mixed
     */
    public function getDbSavingValue()
    {
        return $this->db_saving_value;
    }

    /**
     * @param mixed $db_saving_value
     */
    public function setDbSavingValue($db_saving_value)
    {
        $this->db_saving_value = $db_saving_value;
    }




}