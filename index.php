﻿<?php
// CMS FP
// dispatcher per operacions

require_once "f_seguretat.php";
require_once "f_interficie.php";
require_once "f_operacions.php";
 
connecta_amb_sessio();

capsalera();


if( isset($_REQUEST["operacio"]) && hiha_sessio() )
{
	$operacio=$_REQUEST["operacio"];
	
	if($operacio=="op_alta_usuari" && isset($_REQUEST["nomcognoms"]) && isset($_REQUEST["nick"]) && isset($_REQUEST["contrasenya"]) )
	{ 
		// crear nou usuari
		$nomcognoms = $_REQUEST["nomcognoms"];
		$edat = $_REQUEST["edat"];
		$mail = $_REQUEST["mail"];
		$nick = $_REQUEST["nick"];
		$pwd = $_REQUEST["contrasenya"];
		$nivell = $_REQUEST["nivell"];
		
		crearnouusuari($nick, $nomcognoms, $edat, $mail, $pwd, $nivell);
	}
	else if($operacio=="form_alta_usuari")
	{ 	
		// formulari per instroduir el nou usuari
		formularicrearnouusuari();
	}
	else if( $operacio=="form_modificar_usuari" && isset($_REQUEST["nick"]) )
	{
		// construeix formulari per editar camps d'un usuari
		$n = $_REQUEST["nick"];
		formularimodificarusuari($n);
	}
	else if( $operacio=="op_modificar_usuari" &&  isset($_REQUEST["nomcognoms"]) && isset($_REQUEST["edat"]) && isset($_REQUEST["mail"]) && isset($_REQUEST["nick"]) && isset($_REQUEST["nivell"]) )
	{
		//modifica valors d'un usuari  
		$nomcognoms = $_REQUEST["nomcognoms"];
		$edat = $_REQUEST["edat"];
		$mail = $_REQUEST["mail"];
		$nick = $_REQUEST["nick"];
		$pwd = $_REQUEST["contrasenya"];
		$nivell = $_REQUEST["nivell"];
	
		modificarusuari($nick, $nomcognoms, $edat, $mail, $pwd, $nivell);
	}
	else if( $operacio=="op_eliminar_usuari" && isset($_REQUEST["nick"]) )
	{
		// eliminar usuari pel seu id (nics) - sense confirmacuó
		$nick = $_REQUEST["nick"];
		eliminarusuari($nick);
	}
	else if( $operacio=="llistar_usuaris" )
	{
		//llista en una taula els usuaris i ofereix les operacions pel CRUD
		llistarusuaris();
	}
	else if($operacio=="op_alta_pagina" && isset($_REQUEST["head"]) && isset($_REQUEST["body"]) )
	{ 	
	
		$head = $_REQUEST["head"];
		$body = $_REQUEST["body"];
		
		crearnovapagina($head,$body);
	}
	else if($operacio=="form_alta_pagina")
		
	{ 	
		
		formularicrearnovapagina();
		}
		
	 else if($operacio=="op_visualitzar_pagina" && isset($_REQUEST["head"])){
     
	 $head=$_REQUEST["head"];
	 
	 visualitzarpagina($head);
 }	
 
	else if( $operacio=="llistar_pagines" )
	{
		
		llistarpagines();
	}
	
	else if( $operacio=="op_eliminar_pagina" && isset($_REQUEST["head"]) )
	{
		
		$head = $_REQUEST["head"];
		eliminarpagina($head);
		
	}
	else if( $operacio=="form_modificar_pagina" &&  isset($_REQUEST["head"]) )
	{
		
		$head = $_REQUEST["head"];
		
		
	
		formularimodificarpagina($head);
	}
	else if( $operacio=="op_modificar_pagina" &&  isset($_REQUEST["head"]) && isset($_REQUEST["body"] )  && isset($_REQUEST["oldhead"] ))
	{
		
		$head = $_REQUEST["head"];
		$body=$_REQUEST["body"];
		$oldhead = $_REQUEST["oldhead"];
	
		modificarpagina($head,$body,$oldhead);
	}
	else if($operacio=="logout")
	{
		tancar_sessio();
	}
	else if( $operacio=="form_modificar_perfil" && isset($_REQUEST["nick"]) )
	{
		// construeix formulari per editar camps del perfil de l'usuari
		$n = $_REQUEST["nick"];
		formulariperfilusuari($n);
	}
	else if( $operacio=="op_modificar_perfil" &&  isset($_REQUEST["nomcognoms"]) && isset($_REQUEST["edat"]) && isset($_REQUEST["mail"]) )
	{
		//modifica valors d'un usuari  
		$nomcognoms = $_REQUEST["nomcognoms"];
		$edat = $_REQUEST["edat"];
		$mail = $_REQUEST["mail"];
		$pwd = $_REQUEST["contrasenya"];
		
		//llista en una taula els usuaris i ofereix les operacions pel CRUD
		modificarperfilusuari( id_usuari(), $nomcognoms, $edat, $mail, $pwd);
	}
	else if( $operacio=="llistar_noticies")
	{
		llistarnoticies();
	}
	else if( $operacio=="eliminar_noticia" && isset($_REQUEST["b_noti"]))
	{
		$b = $_REQUEST["b_noti"];
		borrarnoticia($b);
	}
	else if( $operacio=="form_modificar_noticia" && isset($_REQUEST["codin"]))
	{
		$cn = $_REQUEST["codin"];
		formularimodificarnoticia($cn);
	}
	else if( $operacio=="op_modificar_noticia" &&  isset($_REQUEST["codin"]) && isset($_REQUEST["titol"]) && isset($_REQUEST["data"]) && isset($_REQUEST["descripcio"]) && isset($_REQUEST["tipus"]))
	{
		$codin = $_REQUEST["codin"];
		$titol = $_REQUEST["titol"];
		$data = $_REQUEST["data"];
		$descripcio = $_REQUEST["descripcio"];
		$tipus = $_REQUEST["tipus"];

		modificarnoticia( $titol, $data, $descripcio, $tipus, $codin);
	}	
	else if( $operacio=="op_alta_noticia")
	{ 
		$titol = $_REQUEST["titol"];
		$data = $_REQUEST["data"];
		$descripcio = $_REQUEST["descripcio"];
		$tipus = $_REQUEST["tipus"];

		crearnoticia($titol, $data, $descripcio, $tipus);
	}	
	else if($operacio=="form_alta_noticia")
	{ 	
		formularicrearnoticia();
	}
	else
	{
		echo "Operació no reconeguda";
	}
}
else if( hiha_sessio() )
{
	pintar_intranet();
}
else if( isset($_REQUEST["operacio"]) && $_REQUEST["operacio"]=="login" && isset($_REQUEST["nick"]) && isset($_REQUEST["contrasenya"]) )
{
	obrir_sessio( $_REQUEST["nick"], $_REQUEST["contrasenya"] );
}
else
{
	formularientradaportal();
}

peu();

?>
