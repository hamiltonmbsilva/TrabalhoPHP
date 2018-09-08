<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 08/09/2018
 * Time: 18:31
 */
require_once "classes/template.php";

require_once "dao/securelyclosedDAO.php";
require_once "classes/securelyclosed.php";


$object = new securelyclosedDAO();



$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();




// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";

    $str_month_refence = (isset($_POST["str_month_refence"]) && $_POST["str_month_refence"] != null) ? $_POST["str_month_refence"] : "";
    $str_year_reference = (isset($_POST["str_year_reference"]) && $_POST["str_year_reference"] != null) ? $_POST["str_year_reference"] : "";
    $str_uf = (isset($_POST["str_uf"]) && $_POST["str_uf"] != null) ? $_POST["str_uf"] : "";
    $str_cod_siafi_city = (isset($_POST["str_cod_siafi_city"]) && $_POST["str_cod_siafi_city"] != null) ? $_POST["str_cod_siafi_city"] : "";
    $str_name_city = (isset($_POST["str_name_city"]) && $_POST["str_name_city"] != null) ? $_POST["str_name_city"] : "";
    $str_cpf = (isset($_POST["str_cpf"]) && $_POST["str_cpf"] != null) ? $_POST["str_cpf"] : "";
    $str_nis = (isset($_POST["str_nis"]) && $_POST["str_nis"] != null) ? $_POST["str_nis"] : "";
    $int_rgp = (isset($_POST["int_rgp"]) && $_POST["int_rgp"] != null) ? $_POST["int_rgp"] : "";
    $str_name_person = (isset($_POST["str_name_person"]) && $_POST["str_name_person"] != null) ? $_POST["str_name_person"] : "";
    $db_value_plot = (isset($_POST["db_value_plot"]) && $_POST["db_value_plot"] != null) ? $_POST["db_value_plot"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
//    $id_garantia_safra = (isset($_GET["id_garantia_safra"]) && $_GET["id_garantia_safra"] != null) ? $_GET["id_garantia_safra"] : "";
    $str_month_refence = NULL;
    $str_year_reference = NULL;
    $str_uf = NULL;
    $str_cod_siafi_city = NULL;
    $str_name_city = NULL;
    $str_cpf = NULL;
    $str_nis = NULL;
    $int_rgp = NULL;
    $str_name_person = NULL;
    $db_value_plot = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $securelyclosed = new securelyclosed($id, '', '','','','');

    $resultado = $object->atualizar($securelyclosed);
    $db_value_plot = $resultado->getDbValuePlot();
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
    $str_month_refence = $resultado->getStrMonthRefence();
    $str_year_reference = $resultado->getStrYearReference();


}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" &&  $db_value_plot != "" && $tb_city_id_city != "" && $tb_beneficiaries_id_beneficiaries !="" && $str_month_refence !="" && $str_year_reference !="") {
    $peti = new peti($id, $str_benefit_situation, $db_value_plot, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries, $str_month_refence, $str_year_reference);
    $msg = $object->salvar($securelyclosed);
    $id = null;
    $db_value_plot = null;
    $tb_city_id_city = null;
    $tb_beneficiaries_id_beneficiaries = null;
    $str_month_refence = null;
    $str_year_reference = null;


}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $securelyclosed = new securelyclosed($id, '', '','','','');
    $msg = $object->remover($peti);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Seguro Defeso</h4>
                        <p class='category'>Cadastro do seguro defeso </p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="$id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            //                            echo (isset($id_garantia_safra) && ($id_garantia_safra != null || $id_garantia_safra != "")) ? $id_garantia_safra : '';
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            <br/>
                            Ano:
                            <input class="form-control" type="text" name="$str_year_reference" maxlength="4" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_year_reference) && ($str_year_reference != null || $str_year_reference != "")) ? $str_year_reference : '';
                            ?>"/>
                            <br/>
                            Mês:
                            <input class="form-control" type="text" name="$str_month_refence" maxlength="2" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_month_reference) && ($str_month_reference != null || $str_month_reference != "")) ? $str_month_reference : '';
                            ?>"/>
                            <br/>
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
                            <br/>

                            CPF DO Beneficiário :
                            <select class="form-control" name="tb_beneficiaries_id_beneficiaries">
                                <?php
                                $query = "SELECT * FROM tb_beneficiaries order by str_cpf;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_beneficiaries == $tb_beneficiaries_id_beneficiaries) {
                                            echo "<option value='$rs->id_beneficiaries' selected>$rs->str_cpf</option>";
                                        } else {
                                            echo "<option value='$rs->id_beneficiaries'>$rs->str_cpf</option>";
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

                            RG DO Beneficiário :
                            <select class="form-control" name="tb_beneficiaries_id_beneficiaries">
                                <?php
                                $query = "SELECT * FROM tb_beneficiaries order by int_rgp;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->id_beneficiaries == $tb_beneficiaries_id_beneficiaries) {
                                            echo "<option value='$rs->id_beneficiaries' selected>$rs->int_rgp</option>";
                                        } else {
                                            echo "<option value='$rs->id_beneficiaries'>$rs->int_rgp</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                                }
                                ?>
                            </select>
                            <br/>

                            Nome Favorecido :
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
                            <br/>

                            VALOR PARCELA:
                            <input class="form-control" type="text" maxlength="11" name="db_value_plot" placeholder="Entre com so com numeros" value="<?php
                            // Preenche o sigla no campo sigla com um valor "value"
                            echo (isset($db_value_plot) && ($db_value_plot != null || $db_value_plot != "")) ? $db_value_plot : '';
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