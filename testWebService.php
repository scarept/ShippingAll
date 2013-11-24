<?php

$xml = simplexml_load_file("http://scare.pt/ARQSIWORK2/index.php?getIdContrato=1");

//print_r($xml);

if($xml->erro > 0){
echo "Id Erro: " . $xml->erro . '<br />';
echo "Descricao Erro: " . $xml->msgErro . '<br />';
}else{
echo "Id_Contrato: " . $xml->ID_CONTRATO . '<br />';
echo "Id_Cliente: " . $xml->ID_CLIENTE . '<br />';
echo "Id_Calculo: " . $xml->ID_CALCULO . '<br />';
}


?>