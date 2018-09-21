<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 08/09/2018
 * Time: 10:29
 */

require_once "classes/template.php";

require_once "dao/petiDAO.php";
require_once "classes/peti.php";


$object = new petiDAO();



$template = new Template();

$template->header();
$template->sidebar();
$template->mainpanel();




// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";

    $str_month_reference = (isset($_POST["str_month_reference"]) && $_POST["str_month_reference"] != null) ? $_POST["str_month_reference"] : "";
    $str_year_reference = (isset($_POST["str_year_reference"]) && $_POST["str_year_reference"] != null) ? $_POST["str_year_reference"] : "";
    $tb_city_id_city = (isset($_POST["tb_city_id_city"]) && $_POST["tb_city_id_city"] != null) ? $_POST["tb_city_id_city"] : "";
    $tb_beneficiaries_id_beneficiaries = (isset($_POST["tb_beneficiaries_id_beneficiaries"]) && $_POST["tb_beneficiaries_id_beneficiaries"] != null) ? $_POST["tb_beneficiaries_id_beneficiaries"] : "";
    $str_benefit_situation = (isset($_POST["str_benefit_situation"]) && $_POST["str_benefit_situation"] != null) ? $_POST["str_benefit_situation"] : "";
    $db_value_plot = (isset($_POST["db_value_plot"]) && $_POST["db_value_plot"] != null) ? $_POST["db_value_plot"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
//    $id_garantia_safra = (isset($_GET["id_garantia_safra"]) && $_GET["id_garantia_safra"] != null) ? $_GET["id_garantia_safra"] : "";
    $str_month_reference = NULL;
    $str_year_reference = NULL;
    $tb_city_id_city = NULL;
    $tb_beneficiaries_id_beneficiaries = NULL;
    $str_benefit_situation = NULL;
    $db_value_plot = NULL;

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {

    $peti = new peti($id, '', '','','','','');

    $resultado = $object->atualizar($peti);
    $str_benefit_situation = $resultado->getStrBenefitSituation();
    $db_value_plot = $resultado->getDbValuePlot();
    $tb_city_id_city = $resultado->getTbCityIdCity();
    $tb_beneficiaries_id_beneficiaries = $resultado->getTbBeneficiariesIdBeneficiaries();
    $str_month_reference = $resultado->getStrMonthReference();
    $str_year_reference = $resultado->getStrYearReference();


}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" &&  $str_benefit_situation != "" && $db_value_plot != "" && $tb_city_id_city != "" && $tb_beneficiaries_id_beneficiaries != "" && $str_month_reference !="" && $str_year_reference !="") {
    $peti = new peti($id, $str_benefit_situation, $db_value_plot, $tb_city_id_city, $tb_beneficiaries_id_beneficiaries, $str_month_reference, $str_year_reference);
    $msg = $object->salvar($peti);
    $id = null;
    $str_benefit_situation = null;
    $db_value_plot = null;
    $tb_city_id_city = null;
    $tb_beneficiaries_id_beneficiaries = null;
    $str_month_reference = null;
    $str_year_reference = null;


}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $peti = new peti($id, '', '','','','','');
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
                        <h4 class='title'>Peti</h4>
                        <p class='category'>Cadastro e lista de Peti no Sistema </p>

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
                            <input class="form-control" type="number"  name="str_year_reference" max="<?php echo date('Y');?>" maxlength="4" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_year_reference) && ($str_year_reference != null || $str_year_reference != "")) ? $str_year_reference : '';
                            ?>"/>
                            <br/>
                            Mês:
                            <input class="form-control" type="number" min="01" max="12" name="str_month_reference" maxlength="2" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($str_month_reference) && ($str_month_reference != null || $str_month_reference != "")) ? $str_month_reference : '';
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

                            <Laber>Situação do Beneficio:</Laber>
                            <?php

                                    echo "<select class='form-control' name='str_benefit_situation'>
                                        <option value='1'";
                                    if(isset($str_benefit_situation) && ($str_benefit_situation != null || $str_benefit_situation != ""))
                                        echo (($str_benefit_situation == 1) ? ' selected' : '');
                                    echo ">Sacado</option>";
                                    echo "<option value='0'";
                                    if(isset($str_benefit_situation) && ($str_benefit_situation != null || $str_benefit_situation != ""))
                                        echo (($str_benefit_situation == 0) ? ' selected' : '');
                                    echo ">Não Sacado</option></select>";

                            ?>

                            <br/>

                            VALOR PARCELA:
                            <input class="form-control" type="number" maxlength="11" name="db_value_plot" placeholder="Entre com so com numeros" value="<?php
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