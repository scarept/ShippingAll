<?php
	require_once('XML.class.php');
	require_once('Dal.php');

	$idCliente = $_GET['idCliente'];
	$atributo = $_GET['atributo'];
	$idZona = $_GET['idZona'];
	
	$idContrato = getIdContrato($idCliente);
	$calcCliente = getTipoCalculoCliente($idCliente);
	if($calcCliente->ID_CALCULO==1){
		$retorno = calculoTaxaPeso($atributo, $idZona);
	}else if($calcCliente->ID_CALCULO==2){
		$retorno = calculoTaxaVolumes($atributo, $idZona);
	}
	//else if($calcCliente->ID_CALCULO==3){
	//	$retorno = calculoTaxaZona($atributo);
	//}

	//if(isset($_GET['getIdContrato'])){
	//$idCliente2 =='' && $idCliente3 =='' && $idZona ==''){
	//	$retorno = getIdContrato($_GET['getIdContrato']);
	//}
	//else if(isset($_GET['getInfoCliente'])){
	//=='' && $idCliente3 =='' && $idZona ==''){
	//	$retorno = getInfoCliente($_GET['getInfoCliente']);
	//}
	//else if(isset($_GET['getTipoCalculoCliente'])){
	//=='' && $idCliente2 =='' && $idZona ==''){
	//	$retorno = getTipoCalculoCliente($_GET['getTipoCalculoCliente']);
	//}	
	//if(isset($_GET['getTaxaEnvio'])){
	//$idCliente2 =='' && $idCliente3 =='' && $idCliente ==''){
	//	$retorno = getTaxaEnvio($_GET['getTaxaEnvio']);
	//}
	echo $retorno;

	function getIdContrato($idCliente){
		$xml = new XML();
		$erro = 0;
		$xml->openTag("response");
		if($idCliente ==''){
			$erro=1;
			$msgerro = 'Codigo invalido!';
		}else{
			$database = new Dal();
			$database->db_connect();
			$rs = $database->execute_query("SELECT ID_CONTRATO FROM Contrato WHERE ID_CLIENTE = $idCliente");
			$database->db_close();
			if(mysql_num_rows($rs) > 0){
				$reg = mysql_fetch_object($rs);
				$xml->addTag('ID_Contrato',$reg->ID_CONTRATO);
			}
			else{
				$erro=2;
				$msgerro = 'Contrato nao encontrado!';
			}
		}
		$xml->addTag('erro',$erro);
		$xml->addTag('msgErro',$msgerro);

		$xml->closeTag("response");
		return $xml;
	}

	function getInfoCliente($idCliente){
		$xml = new XML();
		$erro = 0;
		$xml->openTag("response");
		if($idCliente ==''){
			$erro=1;
			$msgerro = 'Codigo invalido!';
		}else{
			$database = new Dal();
			$database->db_connect();
			$rs = $database->execute_query("SELECT * FROM Cliente WHERE ID_CLIENTE = $idCliente");
			$database->db_close();
			if(mysql_num_rows($rs) > 0){
				$reg = mysql_fetch_object($rs);
				$xml->addTag('ID_CLIENTE',$reg->ID_CLIENTE);
				$xml->addTag('NOME',$reg->NOME);
				$xml->addTag('NUM_TELEMOVEL',$reg->NUM_TELEMOVEL);
				$xml->addTag('EMAIL',$reg->EMAIL);
			}
			else{
				$erro=2;
				$msgerro = 'Cliente nao encontrado!';
			}
		}
		$xml->addTag('erro',$erro);
		$xml->addTag('msgErro',$msgerro);

		$xml->closeTag("response");
		return $xml;
	}

	function getTipoCalculoCliente($idCliente){
		$xml = new XML();
		$erro = 0;
		$xml->openTag("response");
		if($idCliente ==''){
			$erro=1;
			$msgerro = 'Codigo invalido!';
		}else{
			$database = new Dal();
			$database->db_connect();
			$rs = $database->execute_query("SELECT * FROM CALCULO WHERE ID_CALCULO = (SELECT ID_CALCULO FROM Contrato WHERE ID_CLIENTE= $idCliente");
			$database->db_close();
			if(mysql_num_rows($rs) > 0){
				$reg = mysql_fetch_object($rs);
				$xml->addTag('ID_CALCULO',$reg->ID_CALCULO);
				$xml->addTag('NOME',$reg->LABEL);
			}
			else{
				$erro=2;
				$msgerro = 'Calculo nao encontrado!';
			}
		}
		$xml->addTag('erro',$erro);
		$xml->addTag('msgErro',$msgerro);

		$xml->closeTag("response");
		return $xml;
	}
	
	function getTaxaEnvio($idZona){
		$xml = new XML();
		$erro = 0;
		$xml->openTag("response");
		if($idZona ==''){
			$erro=1;
			$msgerro = 'Codigo invalido!';
		}else{
			$database = new Dal();
			$database->db_connect();
			$rs = $database->execute_query("SELECT TAXA FROM ZONAS WHERE ID_ZONAS = $idZona");
			$database->db_close();
			if(mysql_num_rows($rs) > 0){
				$reg = mysql_fetch_object($rs);
				$xml->addTag('Taxa',$reg->TAXA);
			}
			else{
				$erro=2;
				$msgerro = 'Calculo nao encontrado!';
			}
		}
		$xml->addTag('erro',$erro);
		$xml->addTag('msgErro',$msgerro);

		$xml->closeTag("response");
		return $xml;
	}
	
	function calculoTaxaPeso($qtd, $idZona){
		$xml = new XML();
		$erro = 0;
		$xml->openTag("response");
		
		$taxa = getTaxaEnvio($idZona);
        if ($qtd > 0 && $qtd < 3)
        {
            $ret = 2 * $taxa; // Preço desta gama 2€. Num contexto real, podia ser verificado numa BD a gama de preços
        }else if($qtd >= 3 && $qtd < 6){
            $ret = 4 * $taxa;
        }
        else if ($qtd >= 6 && $qtd <= 10)
        {
            $ret = 6 * $taxa;
        }
		
		$xml->addTag('Preco',$ret);
		$xml->closeTag("response");
		return $xml;
	}

	function calculoTaxaVolumes($atributo, $idZona){
		$xml = new XML();
		$erro = 0;
		$xml->openTag("response");
	
		$taxa = getTaxaEnvio($idZona);
		$ret = 2 * $atributo * $taxa->Taxa;
		
		$xml->addTag('Preco',$ret);
		$xml->closeTag("response");
		return $xml;
	}
?>