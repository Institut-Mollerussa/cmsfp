<?php
require_once "f_seguretat.php";
require_once "f_operacions.php";
 
connecta_amb_sessio();

if( isset($_REQUEST["operacio"]) && hiha_sessio() )
{
	$operacio=$_REQUEST["operacio"];
	if($operacio=="descarregar_fitxerpp" && isset($_REQUEST["id"]))
	{
		descarregar_fitxerpp($_REQUEST["id"]);
	}
}	
?>