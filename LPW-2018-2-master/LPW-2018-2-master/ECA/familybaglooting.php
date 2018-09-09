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
