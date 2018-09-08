<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 07/09/2018
 * Time: 21:06
 */
require_once "db/connection.php";
require_once "classes/city.php";
require_once "classes/beneficiaries.php";
require_once "classes/peti.php";


class petiDAO
{

    public function remover($peti)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_peti WHERE id_peti = :id");
            $statement->bindValue(":id", $peti->getIdPeti());
            if ($statement->execute()) {
                return "<script> alert('Registo foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($peti)
    {
        global $pdo;
        try {
            if ($peti->getIdAction() != "") {
                $statement = $pdo->prepare("UPDATE tb_peti SET str_benefit_situation=:str_benefit_situation, db_value_plot=:db_value_plot, tb_city_id_city=: tb_city_id_city, 
            tb_beneficiaries_id_beneficiaries=:tb_beneficiaries_id_beneficiaries, str_month_reference=:str_month_reference, str_year_reference=:str_year_reference WHERE id_peti = :id;");
                $statement->bindValue(":id", $peti->getIdPeti());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_peti (str_benefit_situation, db_value_plot, tb_city_id_city, tb_beneficiaries_id_beneficiaries, str_month_reference, str_year_reference) 
                  VALUES (:str_benefit_situation, :db_value_plot, :tb_city_id_city, :tb_beneficiaries_id_beneficiaries, :str_month_reference, :str_year_reference)");
            }
            $statement->bindValue(":str_benefit_situation", $peti->getStrBenefitSituation());
            $statement->bindValue(":db_value_plot", $peti->getDbValuePlot());
            $statement->bindValue(":tb_city_id_city", $peti->getTbCityIdCity());
            $statement->bindValue(":tb_beneficiaries_id_beneficiaries", $peti->getTbBeneficiariesIdBeneficiaries());
            $statement->bindValue(":str_month_reference", $peti->getStrMonthReference());
            $statement->bindValue(":str_year_reference", $peti->getStrYearReference());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> alert('Dados cadastrados com sucesso !'); </script>";
                } else {
                    return "<script> alert('Erro ao tentar efetivar cadastro !'); </script>";
                }
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($peti)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_peti, str_benefit_situation, db_value_plot, tb_city_id_city, tb_beneficiaries_id_beneficiaries, str_month_reference, str_year_reference FROM tb_peti WHERE id_peti = :id");
            $statement->bindValue(":id", $peti->getIdPeti());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $peti->setIdPeti($rs->id_peti);
                $peti->setStrBenefitSituation($rs->str_benefit_situation);
                $peti->setDbValuePlot($rs->db_value_plot);
                $peti->setTbCityIdCity($rs->tb_city_id_city);
                $peti->setTbBeneficiariesIdBeneficiaries($rs->tb_beneficiaries_id_beneficiaries);
                $peti->setStrMonthReference($rs->str_month_reference);
                $peti->setStrYearReference($rs->str_year_reference);

                return$peti;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
}