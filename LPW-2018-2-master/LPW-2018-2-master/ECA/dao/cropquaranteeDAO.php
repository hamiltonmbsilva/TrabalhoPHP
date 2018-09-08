<?php
/**
 * Created by PhpStorm.
 * User: Hamil
 * Date: 03/09/2018
 * Time: 22:25
 */
    require_once "db/connection.php";
    require_once "classes/city.php";
    require_once "classes/beneficiaries.php";
    require_once "classes/cropquarantee.php";

class cropquaranteeDAO
{
    public function remover($cropquarantee)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM td_crop_guarantee WHERE id_garantia_safra = :id");
            $statement->bindValue(":id", $cropquarantee->getIdGarantiaSafra());
            if ($statement->execute()) {
                return "<script> alert('Registo foi excluído com êxito !'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }


    public function salvar($cropquarantee)
    {

        global $pdo;
        try {
            if ($cropquarantee->getIdGarantiaSafra() != "") {
                $statement = $pdo->prepare("UPDATE td_crop_guarantee SET str_month=:str_month, str_year=:str_year, 
            db_value=:db_value, tb_city_id_city=:tb_city_id_city, tb_beneficiaries_id_beneficiaries=:tb_beneficiaries_id_beneficiaries
             WHERE id_garantia_safra = :id;");
                $statement->bindValue(":id", $cropquarantee->getIdGarantiaSafra());
            } else {
                $statement = $pdo->prepare("INSERT INTO td_crop_guarantee (str_month, str_year, db_value, tb_city_id_city, 
            tb_beneficiaries_id_beneficiaries) 
                  VALUES (:str_month, :str_year, :db_value, :tb_city_id_city, :tb_beneficiaries_id_beneficiaries)");
            }
            $statement->bindValue(":str_month", $cropquarantee->getStrMonth());
            $statement->bindValue(":str_year", $cropquarantee->getStrYear());
            $statement->bindValue(":db_value", $cropquarantee->getDbValue());
            $statement->bindValue(":tb_city_id_city", $cropquarantee->getTbCityIdCity());
            $statement->bindValue(":tb_beneficiaries_id_beneficiaries", $cropquarantee->getTbBeneficiariesIdBeneficiaries());

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

    public function atualizar($cropquarantee){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_garantia_safra, str_month, str_year, db_value, tb_city_id_city, 
            tb_beneficiaries_id_beneficiaries  FROM td_crop_guarantee WHERE id_garantia_safra = :id");
            $statement->bindValue(":id", $cropquarantee->getIdGarantiaSafra());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $cropquarantee->setIdGarantiaSafra($rs->id_garantia_safra);
                $cropquarantee->setStrMonth($rs->str_month);
                $cropquarantee->setStrYear($rs->str_year);
                $cropquarantee->setDbValue($rs->db_value);
                $cropquarantee->setTbCityIdCity($rs->tb_city_id_city);
                $cropquarantee->setTbBeneficiariesIdBeneficiaries($rs->tb_beneficiaries_id_beneficiaries);
                return $cropquarantee;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function tabelapaginada() {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT S.id_garantia_safra,S.str_month, S.str_year,S.db_value ,C.id_city, C.str_name_city, C.str_cod_siafi_city,
        B.id_beneficiaries, B.str_nis, B.str_name_person, T.id_state, T.str_uf 
        FROM tb_city C INNER JOIN td_crop_guarantee S ON C.id_city = S.tb_city_id_city 
                INNER JOIN tb_beneficiaries As B ON B.id_beneficiaries = S.tb_beneficiaries_id_beneficiaries
                INNER JOIN tb_state  AS T ON T.id_state = C.tb_state_id_state LIMIT {$linha_inicial}, " . QTDE_REGISTROS;

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM td_crop_guarantee";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;

        /* Cálcula qual será a página final do nosso range */
        $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';
            //Exemplo para debugar o sistema


        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr style='text-transform: uppercase;' class='active'>
    
        <th style='text-align: center; font-weight: bolder;'>Mês</th>
        <th style='text-align: center; font-weight: bolder;'>Ano</th>
        <th style='text-align: center; font-weight: bolder;'>UF</th>
        <th style='text-align: center; font-weight: bolder;'>Código Município SIAFI</th>
        <th style='text-align: center; font-weight: bolder;'>Nome Município SIAFI</th>
        <th style='text-align: center; font-weight: bolder;'>NIS Beneficiário</th>
        <th style='text-align: center; font-weight: bolder;'>Nome Beneficiário</th>
         <th style='text-align: center; font-weight: bolder;'>Valor Benefício</th>
        <th style='text-align: center; font-weight: bolder;' colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $cropquarantee):
                echo "<tr>

        <td style='text-align: center'>$cropquarantee->str_month</td>
        <td style='text-align: center'>$cropquarantee->str_year</td>       
        <td style='text-align: center'>$cropquarantee->str_uf</td>
        <td style='text-align: center'>$cropquarantee->str_cod_siafi_city</td>
        <td style='text-align: center'>$cropquarantee->str_name_city</td>   
        <td style='text-align: center'>$cropquarantee->str_nis</td>    
        <td style='text-align: center'>$cropquarantee->str_name_person</td>
        <td style='text-align: center'>$cropquarantee->db_value</td>
        <td style='text-align: center'><a href='?act=upd&id=$cropquarantee->id_garantia_safra' title='Alterar'><i class='ti-reload'></i></a></td>
        <td style='text-align: center'><a href='?act=del&id=$cropquarantee->id_garantia_safra' title='Remover'><i class='ti-close'></i></a></td>
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