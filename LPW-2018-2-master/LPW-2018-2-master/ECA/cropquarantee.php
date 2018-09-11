<?php

require_once "classes/template.php";

require_once "dao/cropquaranteeDAO.php";
require_once "classes/cropquarantee.php";


$object = new cropquaranteeDAO();


$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
//    $id_garantia_safra = (isset($_POST["id_garantia_safra"]) && $_POST["id_garantia_safra"] != null) ? $_POST["id_garantia_safra"] : "";
    $str_month = (isset($_POST["str_month"]) && $_POST["str_month"] != null) ? $_POST["str_month"] : "";
    $str_year = (isset($_POST["str_year"]) && $_POST["str_year"] != null) ? $_POST["str_year"] : "";
    $db_value = (isset($_POST["db_value"]) && $_POST["db_value"] != null) ? $_POST["db_value"] : "";
    $tb_city_id_city = (isset($_POST["tb_city_id_city"]) && $_POST["tb_city_id_city"] != null) ? $_POST["tb_city_id_city"] : "";
    $tb_beneficiaries_id_beneficiaries = (isset($_POST["tb_beneficiaries_id_beneficiaries"]) && $_POST["tb_beneficiaries_id_beneficiaries"] != null) ? $_POST["tb_beneficiaries_id_beneficiaries"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
//    $id_garantia_safra = (isset($_GET["id_garantia_safra"]) && $_GET["id_garantia_safra"] != null) ? $_GET["id_garantia_safra"] : "";
    $str_month = NULL;
    $str_year = NULL;
    $str_uf = NULL;
    $db_value = NULL;
    $tb_city_id_city = NULL;
    $tb_beneficiaries_id_beneficiaries = NULL;
}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $cropquarantee = new cropquarantee($id, '', '', "", "", '');

    $resultado = $object->atualizar($cropquarantee);

//    $id_garantia_safra = $resultado->getIdGarantiaSafra();
    $str_month = $resultado->getStrMonth();
    $str_year = $resultado->getStrYear();
    $db_value = $resultado->getDbValue();
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_month != "" && $str_year != "" && $db_value != "" && $tb_city_id_city != "" && $tb_beneficiaries_id_beneficiaries != "") {
    $cropquarantee = new cropquarantee($id, $str_month, $str_year, $db_value, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries);

    $msg = $object->salvar($cropquarantee);
    $id = null;
    $str_month = null;
    $str_year = null;
    $db_value = null;
    $tb_city_id_city = null;
    $tb_beneficiaries_id_beneficiaries = null;

}


if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" ) {
    $cropquarantee = new cropquarantee($id, '', '', '', '', '');
    $msg = $object->remover($cropquarantee);
    $id = null;
}

?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Garantia Safra</h4>
                            <p class='category'>List of beneficiaries of the system</p>

                        </div>
                        <div class='content table-responsive'>

                            <form action="?act=save&id=" method="POST" name="form1">

                                <input type="hidden" name="id" value="<?php
                                // Preenche o id no campo id com um valor "value"
                                //                            echo (isset($id_garantia_safra) && ($id_garantia_safra != null || $id_garantia_safra != "")) ? $id_garantia_safra : '';
                                echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                                ?>"/>
                                <br/>
                                Ano:
                                <input class="form-control" type="text" name="str_year" maxlength="4" value="<?php
                                // Preenche o nome no campo nome com um valor "value"
                                echo (isset($str_year) && ($str_year != null || $str_year != "")) ? $str_year : '';
                                ?>"/>
                                <br/>
                                Mês:
                                <input class="form-control" type="text" name="str_month" maxlength="2" value="<?php
                                // Preenche o nome no campo nome com um valor "value"
                                echo (isset($str_month) && ($str_month != null || $str_month != "")) ? $str_month : '';
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

                                Valor Benefício:
                                <input class="form-control" type="text" maxlength="11" name="db_value"
                                       placeholder="Entre com so com numeros" value="<?php
                                // Preenche o sigla no campo sigla com um valor "value"
                                echo (isset($db_value) && ($db_value != null || $db_value != "")) ? $db_value : '';
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