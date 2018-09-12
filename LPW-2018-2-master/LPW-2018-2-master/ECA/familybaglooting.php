<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 08/09/2018
 * Time: 20:59
 */

require_once "classes/template.php";

require_once "dao/familybaglootingDAO.php";
require_once "classes/familybaglooting.php";


$object = new familybaglootingDAO();



$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";

    $str_month_reference = (isset($_POST["str_month_reference"]) && $_POST["str_month_reference"] != null) ? $_POST["str_month_reference"] : "";
    $str_year_reference = (isset($_POST["str_year_reference"]) && $_POST["str_year_reference"] != null) ? $_POST["str_year_reference"] : "";
    $str_month_competence = (isset($_POST["str_month_competence"]) && $_POST["str_month_competence"] != null) ? $_POST["str_month_competence"] : "";
    $str_year_competence = (isset($_POST["str_year_competence"]) && $_POST["str_year_competence"] != null) ? $_POST["str_year_competence"] : "";
    $tb_city_id_city = (isset($_POST["tb_city_id_city"]) && $_POST["tb_city_id_city"] != null) ? $_POST["tb_city_id_city"] : "";
    $tb_beneficiaries_id_beneficiaries = (isset($_POST["tb_beneficiaries_id_beneficiaries"]) && $_POST["tb_beneficiaries_id_beneficiaries"] != null) ? $_POST["tb_beneficiaries_id_beneficiaries"] : "";
    $dt_date_withdrawal = (isset($_POST["dt_date_withdrawal"]) && $_POST["dt_date_withdrawal"] != null) ? $_POST["dt_date_withdrawal"] : "";
    $db_saving_value = (isset($_POST["db_saving_value"]) && $_POST["db_saving_value"] != null) ? $_POST["db_saving_value"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
//    $id_garantia_safra = (isset($_GET["id_garantia_safra"]) && $_GET["id_garantia_safra"] != null) ? $_GET["id_garantia_safra"] : "";
    $str_month_reference = NULL;
    $str_year_reference = NULL;
    $str_month_competence = NULL;
    $str_year_competence = NULL;
    $tb_city_id_city = NULL;
    $tb_beneficiaries_id_beneficiaries = NULL;
    $dt_date_withdrawal = NULL;
    $db_saving_value = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $familybaglooting = new familybaglooting($id, '', '','','','','','', '');

    $resultado = $object->atualizar($familybaglooting);

    $str_month_reference = $resultado->getStrMonthReference();
    $str_year_reference = $resultado->getStrYearReference();
    $str_month_competence = $resultado->getStrMonthCompetence();
    $str_year_competence = $resultado->getStrYearCompetence();
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
    $dt_date_withdrawal = $resultado->getDtDateWithdrawal();
    $db_saving_value = $resultado->getDbSavingValue();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" &&  $str_month_reference != "" && $str_year_reference != "" && $str_month_competence !="" &&  $str_year_competence !="" &&  $tb_city_id_city !=""
    &&  $tb_beneficiaries_id_beneficiaries !="" &&  $dt_date_withdrawal !="" &&  $db_saving_value !="") {
    $familybaglooting = new familybaglooting ($id, $str_month_reference, $str_year_reference, $str_month_competence, $str_year_competence,
        $tb_city_id_city, $tb_beneficiaries_id_beneficiaries, $dt_date_withdrawal, $db_saving_value);
    $msg = $object->salvar($familybaglooting);
    $id = null;
    $str_month_reference = NULL;
    $str_year_reference = NULL;
    $str_month_competence = NULL;
    $str_year_competence = NULL;
    $tb_city_id_city = null;
    $tb_beneficiaries_id_beneficiaries = null;
    $dt_date_withdrawal = NULL;
    $db_saving_value = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $familybaglooting = new familybaglooting($id, '', '','','','','','','');
    $msg = $object->remover($familybaglooting);
    $id = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Bolsa Fanilia Saques</h4>
                        <p class='category'>Cadastro da bolsa Familia Saques </p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            //                            echo (isset($id_garantia_safra) && ($id_garantia_safra != null || $id_garantia_safra != "")) ? $id_garantia_safra : '';
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            <br/>
                            Ano Referencia:
                            <input class="form-control" type="text" name="str_year_reference" maxlength="4" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_year_reference) && ($str_year_reference != null || $str_year_reference != "")) ? $str_year_reference : '';
                            ?>"/>
                            <br/>
                            Mês Referencia:
                            <input class="form-control" type="text" name="str_month_reference" maxlength="2" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_month_reference) && ($str_month_reference != null || $str_month_reference != "")) ? $str_month_reference : '';
                            ?>"/>
                            <br/>

                            Ano Competencia:
                            <input class="form-control" type="text" name="str_year_competence" maxlength="4" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_year_competence) && ($str_year_competence != null || $str_year_competence != "")) ? $str_year_competence : '';
                            ?>"/>
                            <br/>

                            Mês Competencia:
                            <input class="form-control" type="text" name="str_month_competence" maxlength="2" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_month_competence) && ($str_month_competence != null || $str_month_competence != "")) ? $str_month_competence : '';
                            ?>"/>
                            <br/>

                            Código Município SIAFI:
                            <select class="form-control" name="tb_city_id_city">
                                <?php
                                $query = "SELECT * FROM tb_city order by str_cod_siafi_city;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_city == $tb_city_id_city) {
                                            echo "<option value='$rs->id_city' selected>$rs->str_cod_siafi_city</option>";
                                        } else {
                                            echo "<option value='$rs->id_city'>$rs->str_cod_siafi_city</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>
                            NIS Beneficiário :
                            <select class="form-control" name="tb_beneficiaries_id_beneficiaries">
                                <?php
                                $query = "SELECT * FROM tb_beneficiaries order by str_nis;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_beneficiaries == $tb_beneficiaries_id_beneficiaries) {
                                            echo "<option value='$rs->id_beneficiaries' selected>$rs->str_nis</option>";
                                        } else {
                                            echo "<option value='$rs->id_beneficiaries'>$rs->str_nis</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Data Saque:
                            <input class="form-control" type="text" maxlength="11" name="dt_date_withdrawal" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($dt_date_withdrawal) && ($dt_date_withdrawal != null || $dt_date_withdrawal != "")) ? $dt_date_withdrawal : '';
                            ?>"/>
                            <br/>

                            Valor Saque:
                            <input class="form-control" type="text" maxlength="11" name="db_saving_value" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($db_saving_value) && ($db_saving_value != null || $db_saving_value != "")) ? $db_saving_value : '';
                            ?>"/>
                            <br/>

                            <input class="btn btn-success" type="submit" value="REGISTER">
                            <hr>
                        </form>


                        <?php
                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                        //chamada a paginação
                        $object->tabelapaginada();

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>

// Tudo que for chave estrangeira colocar num select , o value do opton tem que ser o id.

