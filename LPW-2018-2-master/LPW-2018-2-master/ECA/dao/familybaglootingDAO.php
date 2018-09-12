<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 08/09/2018
 * Time: 19:07
 */

require_once "db/connection.php";
require_once "classes/city.php";
require_once "classes/beneficiaries.php";
require_once "classes/familybaglooting.php";

class familybaglootingDAO
{
    public function remover($familybaglooting)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM td_familybag_looting WHERE id_familybag_looting = :id");
            $statement->bindValue(":id", $familybaglooting->getIdFamilybagLooting());
            if ($statement->execute()) {
                return "<script> alert('Registo foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($familybaglooting)
    {
        global $pdo;
        try {
            if ($familybaglooting->getIdFamilybagLooting() != "") {
                $statement = $pdo->prepare("UPDATE td_familybag_looting SET str_month_reference=:str_month_reference, str_year_reference=:str_year_reference, str_month_competence=:str_month_competence, 
              str_year_competence=:str_year_competence, tb_city_id_city=:tb_city_id_city , tb_beneficiaries_id_beneficiaries=:tb_beneficiaries_id_beneficiaries, dt_date_withdrawal=:dt_date_withdrawal,
              db_saving_value=:db_saving_value WHERE id_familybag_looting = :id;");
                $statement->bindValue(":id", $familybaglooting->getIdFamilybagLooting());
            } else {
                $statement = $pdo->prepare("INSERT INTO td_familybag_looting (str_month_reference, str_year_reference, str_month_competence, str_year_competence, tb_city_id_city,
              tb_beneficiaries_id_beneficiaries, dt_date_withdrawal, db_saving_value) 
                  VALUES (:str_month_reference, :str_year_reference, :str_month_competence, :str_year_competence, :tb_city_id_city, :tb_beneficiaries_id_beneficiaries, :dt_date_withdrawal, :db_saving_value);");
            }
            $statement->bindValue(":str_month_reference", $familybaglooting->getStrMonthReference());
            $statement->bindValue(":str_year_reference", $familybaglooting->getStrYearReference());
            $statement->bindValue(":str_month_competence", $familybaglooting->getStrMonthCompetence());
            $statement->bindValue(":str_year_competence", $familybaglooting->getStrYearCompetence());
            $statement->bindValue(":tb_city_id_city", $familybaglooting->getTbCityIdCity());
            $statement->bindValue(":tb_beneficiaries_id_beneficiaries", $familybaglooting->getTbBeneficiariesIdBeneficiaries());
            $statement->bindValue(":dt_date_withdrawal", $familybaglooting->getDtDateWithdrawal());
            $statement->bindValue(":db_saving_value", $familybaglooting->getDbSavingValue());


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

    public function atualizar($familybaglooting)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_familybag_looting, str_month_reference, str_year_reference, str_month_competence,
            str_year_competence, tb_city_id_city, tb_beneficiaries_id_beneficiaries, dt_date_withdrawal, db_saving_value FROM td_familybag_looting WHERE id_familybag_looting = :id");
            $statement->bindValue(":id", $familybaglooting->getIdFamilybagLooting());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $familybaglooting->setIdFamilybagLooting($rs->id_familybag_looting);
                $familybaglooting->setStrMonthReference($rs->str_month_reference);
                $familybaglooting->setStrYearReference($rs->str_year_reference);
                $familybaglooting->setStrMonthCompetence($rs->str_month_competence);
                $familybaglooting->setStrYearCompetence($rs->str_year_competence);
                $familybaglooting->setTbCityIdCity($rs->tb_city_id_city);
                $familybaglooting->setTbBeneficiariesIdBeneficiaries($rs->tb_beneficiaries_id_beneficiaries);
                $familybaglooting->setDtDateWithdrawal($rs->dt_date_withdrawal);
                $familybaglooting->setDbSavingValue($rs->db_saving_value);


                return $familybaglooting;
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
        $sql = "SELECT F.id_familybag_looting,F.str_month_reference, F.str_year_reference, F.str_month_competence, F.str_year_competence,
                F.dt_date_withdrawal, F.db_saving_value, C.id_city, C.str_name_city, C.str_cod_siafi_city,B.id_beneficiaries, B.str_nis, B.str_name_person,
                T.id_state, T.str_uf  FROM tb_city C INNER JOIN td_familybag_looting F ON C.id_city = F.tb_city_id_city 
                INNER JOIN tb_beneficiaries As B ON B.id_beneficiaries = F.tb_beneficiaries_id_beneficiaries
                INNER JOIN tb_state  AS T ON T.id_state = C.tb_state_id_state LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM td_familybag_looting";
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
        <th style='text-align: center; font-weight: bolder;'>Ano Refrência</th>
        <th style='text-align: center; font-weight: bolder;'>Mês Refrência</th>
        <th style='text-align: center; font-weight: bolder;'>Ano Compentência</th>
        <th style='text-align: center; font-weight: bolder;'>Mês Compentência</th>
        <th style='text-align: center; font-weight: bolder;'>UF</th>
        <th style='text-align: center; font-weight: bolder;'>Código Municipio Siafi</th>
        <th style='text-align: center; font-weight: bolder;'>Nome do Municipio</th>
        <th style='text-align: center; font-weight: bolder;'>Nis do Favorecido</th>
        <th style='text-align: center; font-weight: bolder;'>Nome do Favorecido</th>
        <th style='text-align: center; font-weight: bolder;'>Data do Saque</th>  
        <th style='text-align: center; font-weight: bolder;'>Valor da Parcela</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $family):
                echo "<tr>        
        <td style='text-align: center'>$family->str_month_reference</td>
        <td style='text-align: center'>$family->str_year_reference</td>
        <td style='text-align: center'>$family->str_month_competence</td>
        <td style='text-align: center'>$family->str_year_competence</td>
        <td style='text-align: center'>$family->str_uf</td>
        <td style='text-align: center'>$family->str_cod_siafi_city</td>
        <td style='text-align: center'>$family->str_name_city</td>
        <td style='text-align: center'>$family->str_nis</td>
        <td style='text-align: center'>$family->str_name_person</td>
        <td style='text-align: center'>$family->dt_date_withdrawal</td>
        <td style='text-align: center'>$family->db_saving_value</td>
        <td style='text-align: center'><a href='?act=upd&id=$family->id_familybag_looting' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$family->id_familybag_looting' title='Remover'><i class='ti-close'></i></a></td>
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