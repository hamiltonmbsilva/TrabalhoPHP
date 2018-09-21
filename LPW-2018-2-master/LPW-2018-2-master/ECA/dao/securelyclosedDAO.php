<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 08/09/2018
 * Time: 15:19
 */

require_once "db/connection.php";
require_once "classes/city.php";
require_once "classes/beneficiaries.php";
require_once "classes/securelyclosed.php";

class securelyclosedDAO
{
    public function remover($securelyclosed)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_securely_closed WHERE id_securely_closed = :id");
            $statement->bindValue(":id", $securelyclosed->getIdSecurelyClosed());
            if ($statement->execute()) {
                return "<script> alert('Registo foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($securelyclosed)
    {
        global $pdo;
        try {
            if ($securelyclosed->getIdSecurelyClosed() != "") {
                $statement = $pdo->prepare("UPDATE tb_securely_closed SET db_value_plot=:db_value_plot, tb_city_id_city=:tb_city_id_city, tb_beneficiaries_id_beneficiaries=:tb_beneficiaries_id_beneficiaries, 
            str_month_refence=:str_month_refence, str_year_reference=:str_year_reference WHERE id_securely_closed = :id;");
                $statement->bindValue(":id", $securelyclosed->getIdSecurelyClosed());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_securely_closed (db_value_plot, tb_city_id_city, tb_beneficiaries_id_beneficiaries, str_month_refence, str_year_reference) 
                  VALUES (:db_value_plot, :tb_city_id_city, :tb_beneficiaries_id_beneficiaries, :str_month_refence, :str_year_reference);");
            }
            $statement->bindValue(":db_value_plot", $securelyclosed->getDbValuePlot());
            $statement->bindValue(":tb_city_id_city", $securelyclosed->getTbCityIdCity());
            $statement->bindValue(":tb_beneficiaries_id_beneficiaries", $securelyclosed->getTbBeneficiariesIdBeneficiaries());
            $statement->bindValue(":str_month_refence", $securelyclosed->getStrMonthRefence());
            $statement->bindValue(":str_year_reference", $securelyclosed->getStrYearReference());


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

    public function atualizar($securelyclosed)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_securely_closed, db_value_plot, tb_city_id_city, tb_beneficiaries_id_beneficiaries,
            str_month_refence, str_year_reference FROM tb_securely_closed WHERE id_securely_closed = :id");
            $statement->bindValue(":id", $securelyclosed->getIdSecurelyClosed());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $securelyclosed->setIdSecurelyClosed($rs->id_securely_closed);
                $securelyclosed->setDbValuePlot($rs->db_value_plot);
                $securelyclosed->setTbCityIdCity($rs->tb_city_id_city);
                $securelyclosed->setTbBeneficiariesIdBeneficiaries($rs->tb_beneficiaries_id_beneficiaries);
                $securelyclosed->setStrMonthRefence($rs->str_month_refence);
                $securelyclosed->setStrYearReference($rs->str_year_reference);


                return $securelyclosed;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function tabelapaginada()
    {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 2);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT S.id_securely_closed,S.db_value_plot, S.str_month_refence, S.str_year_reference ,C.id_city, C.str_name_city, C.str_cod_siafi_city,B.id_beneficiaries,B.str_cpf, B.str_nis, B.str_name_person,B.int_rgp, T.id_state, T.str_uf  FROM tb_city C INNER JOIN tb_securely_closed S ON C.id_city = S.tb_city_id_city 
                INNER JOIN tb_beneficiaries As B ON B.id_beneficiaries = S.tb_beneficiaries_id_beneficiaries
                INNER JOIN tb_state  AS T ON T.id_state = C.tb_state_id_state LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_securely_closed";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

        /* Cálcula qual será a página final do nosso range */
        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr style='text-transform: uppercase;' class='active'>
        <th style='text-align: center; font-weight: bolder;'>Ano e Mês</th>
       <!-- <th style='text-align: center; font-weight: bolder;'>Mês</th>-->
        <th style='text-align: center; font-weight: bolder;'>UF</th>
       <!-- <th style='text-align: center; font-weight: bolder;'>Código Municipio Siafi</th>-->
        <th style='text-align: center; font-weight: bolder;'>Nome do Municipio</th>
        <th style='text-align: center; font-weight: bolder;'>CPF do Favorecido</th>
        <!--<th style='text-align: center; font-weight: bolder;'>Nis do Favorecido</th>-->
        <th style='text-align: center; font-weight: bolder;'>RG do Favorecido</th>
        <th style='text-align: center; font-weight: bolder;'>Nome do Favorecido</th> 
        <th style='text-align: center; font-weight: bolder;'>Valor da Parcela</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $securely):
                $valor = '$'.number_format($securely->db_value_plot,2,',','.');
                echo "<tr>        
        <td style='text-align: center'>$securely->str_month_refence / $securely->str_year_reference </td>
        <!--<td style='text-align: center'>$securely->str_month_refence</td>-->
        <td style='text-align: center'>$securely->str_uf</td>
       <!-- <td style='text-align: center'>$securely->str_cod_siafi_city</td>-->
        <td style='text-align: center'>$securely->str_name_city</td>
        <td style='text-align: center'>$securely->str_cpf</td>
        <!--<td style='text-align: center'>$securely->str_nis</td>-->
        <td style='text-align: center'>$securely->int_rgp</td>
        <td style='text-align: center'>$securely->str_name_person</td>
        <td style='text-align: center'>$valor </td>
        <td style='text-align: center'><a href='?act=upd&id=$securely->id_securely_closed' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$securely->id_securely_closed' title='Remover'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo "
</tbody>
     </table>

    <div class='box-paginacao' style='text-align: center'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'> FIRST  |</a>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'> PREVIOUS  |</a>
";

            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'> ( $i ) </a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>| NEXT  </a>
                  <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina'  title='Última Página'>| LAST  </a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }

}