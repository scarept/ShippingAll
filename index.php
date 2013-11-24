<?php
require_once('XML.class.php');
require_once('Dal.php');

$xml = new XML();

$erro = 0;

$idCliente = $_GET['getIdContrato'];

$xml->openTag("response");

if($idCliente ==''){
	$erro=1;
	$msgerro = 'Codigo invalido!';
}
else{
	$database = new Dal();
	$database->db_connect();
	//$rs = $database->execute_query("SELECT * FROM Contrato WHERE ID_CLIENTE = $idCliente");
	$rs = $database->execute_query("SELECT * FROM Cliente WHERE ID_CLIENTE = $idCliente");
	$database->db_close();
	if(mysql_num_rows($rs) > 0){
		$reg = mysql_fetch_object($rs);
		//$xml->addTag('ID_CONTRATO',$rs->ID_CONTRATO);
		//$xml->addTag('ID_CLIENTE',$rs->ID_CLIENTE);
		//$xml->addTag('ID_CALCULO',$rs->ID_CALCULO);
		$xml->addTag('Nome',$rs->NOME);
		$xml->addTag('Mail',$rs->EMAIL);
	}
	else{
		$erro=2;
		$msgerro = 'Contrato nao encontrado!';
	}
}

$xml->addTag('erro',$erro);
$xml->addTag('msgErro',$msgerro);

$xml->closeTag("response");

echo $xml;

?>