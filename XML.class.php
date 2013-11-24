<?php
class XML{

	private $xml;
	private $tab = 1;
	
	public function __constrct($version = '1.0', $encode = 'UTF-8'){
		$this->xml .= "<?xml version='$version' enconding='$encode'?>\n";
	}
	
	public function openTag($name){
		$this->addTab();
		$this->xml .= "<$name>\n";
		$this->tab++;
	}
	
	public function closeTag($name){
		$this->tab--;
		$this->addTab();
		$this->xml .="</$name>\n";
	}
	
	private function addTab(){
		for($i = 1; $i <= $this->tab; $i++){
			$this->xml .= "\t";
		}
	}
	
	public function addTag($name, $value){
		$this->addTab();
		$this->xml .= "<$name>$value</$name>\n";
	}
	
	public function __toString(){
		return $this->xml;
	}
}

?>