<?php

$xml = simplexml_load_file("http://scare.pt/ARQSIWORK2/index.php?idCliente=1&atributo=10&idZona=1");

//print_r($xml);

if($xml->erro > 0){
echo "Id Erro: " . $xml->erro . '<br />';
echo "Descricao Erro: " . $xml->msgErro . '<br />';
}else{
echo "Preco: " . $xml->Preco . '<br />';
}


?>