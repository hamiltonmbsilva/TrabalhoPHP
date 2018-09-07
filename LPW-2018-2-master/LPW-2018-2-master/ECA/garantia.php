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
    $id_garantia_safra = (isset($_POST["id_garantia_safra"]) && $_POST["id_garantia_safra"] != null) ? $_POST["id_garantia_safra"] : "";
    $str_month = (isset($_POST["str_month"]) && $_POST["str_month"] != null) ? $_POST["str_month"] : "";
    $str_year = (isset($_POST["str_year"]) && $_POST["str_year"] != null) ? $_POST["str_year"] : "";
    $str_uf = (isset($_POST["str_uf"]) && $_POST["str_uf"] != null) ? $_POST["str_uf"] : "";
    $str_cod_siafi_city = (isset($_POST["str_cod_siafi_city"]) && $_POST["str_cod_siafi_city"] != null) ? $_POST["str_cod_siafi_city"] : "";
    $str_name_city = (isset($_POST["str_name_city"]) && $_POST["str_name_city"] != null) ? $_POST["str_name_city"] : "";
    $str_nis = (isset($_POST["str_nis"]) && $_POST["str_nis"] != null) ? $_POST["str_nis"] : "";
    $str_name_person = (isset($_POST["str_name_person"]) && $_POST["str_name_person"] != null) ? $_POST["str_name_person"] : "";
    $db_value = (isset($_POST["db_value"]) && $_POST["db_value"] != null) ? $_POST["db_value"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id_garantia_safra = (isset($_GET["id_garantia_safra"]) && $_GET["id_garantia_safra"] != null) ? $_GET["id_garantia_safra"] : "";
    $str_month = NULL;
    $str_year = NULL;
    $str_uf = NULL;
    $str_cod_siafi_city = NULL;
    $str_name_city = NULL;
    $str_nis = NULL;
    $str_name_person = NULL;
    $db_value = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_garantia_safra != "") {

    $cropquarantee = new cropquarantee($id, '', '',"","",'');

    $resultado = $object->atualizar($cropquarantee);
    $id_garantia_safra = $resultado->getIdGarantiaSafra();
    $str_month = $resultado->getStrMonth();
    $str_year = $resultado->getStrYear();
    $db_value = $resultado->getDbValue();
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $str_month != "" && $str_year != "" && $db_value !="" && $tb_city_id_city !="" && $tb_beneficiaries_id_beneficiaries !="") {
    $cropquarantee = new cropquarantee($id_garantia_safra, $str_month, $str_year, $db_value, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries);
    $msg = $object->salvar($cropquarantee);
    $id_garantia_safra = null;
    $str_year = null;
    $str_month = null;
    $db_value = null;
    $tb_city_id_city = null;
    $tb_beneficiaries_id_beneficiaries = null;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_garantia_safra != "") {
    $cropquarantee = new cropquarantee($id_garantia_safra, '', '','','','');
    $msg = $object->remover($cropquarantee);
    $id_garantia_safra = null;
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

                            <input type="hidden" name="$id_garantia_safra" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id_garantia_safra) && ($id_garantia_safra != null || $id_garantia_safra != "")) ? $id_garantia_safra : '';
                            ?>"/>
                            Ano:
                            <input class="form-control" type="text" name="$str_year" maxlength="4" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_year) && ($str_year != null || $str_year != "")) ? $str_year : '';
                            ?>"/>
                            <br/>
                            Mês:
                            <input class="form-control" type="text" name="$str_month" maxlength="2" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_year) && ($str_year != null || $str_year != "")) ? $str_year : '';
                            ?>"/>
                            UF:
                            <select class="form-control" name="tb_state_id_state">
                                <?php
                                $query = "SELECT * FROM tb_state order by str_uf;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_state == $tb_state_id_state) {
                                            echo "<option value='$rs->id_state' selected>$rs->str_uf</option>";
                                        } else {
                                            echo "<option value='$rs->id_state'>$rs->str_uf</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
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

                            Nome Município SIAFI:
                            <select class="form-control" name="tb_city_id_city">
                                    <?php
                                    $query = "SELECT * FROM tb_city order by str_name_city;";
                                    $statement = $pdo->prepare($query);
                                    if ($statement->execute()) {
                                        $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($result as $rs) {
                                            if ($rs->id_city == $tb_city_id_city) {
                                                echo "<option value='$rs->id_city' selected>$rs->str_name_city</option>";
                                            } else {
                                                echo "<option value='$rs->id_city'>$rs->str_name_city</option>";
                                            }
                                        }
                                    } else {
                                        throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                    }
                                    ?>
                            </select>

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

                            Nome Beneficiário :
                            <select class="form-control" name="tb_beneficiaries_id_beneficiaries">
                                <?php
                                $query = "SELECT * FROM tb_beneficiaries order by str_name_person;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_beneficiaries == $tb_beneficiaries_id_beneficiaries) {
                                            echo "<option value='$rs->id_beneficiaries' selected>$rs->str_name_person</option>";
                                        } else {
                                            echo "<option value='$rs->id_beneficiaries'>$rs->str_name_person</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>

                            Valor Benefício:
                            <input class="form-control" type="text" maxlength="11" name="db_value" placeholder="Entre com so com numeros" value="<?php
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

// Tudo que for chave estrangeira colocar num select , o value do opton tem que ser o id.