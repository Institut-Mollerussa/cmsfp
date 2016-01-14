<?php
// CMS FP
// funcions amb elements de seguretat del portal


function connecta_amb_sessio()
{
	session_start();
}

function hiha_sessio()
{
	return isset($_SESSION['nom']);
}

function id_usuari()
{
	return $_SESSION['nom'];
}

function assigna_id($nom)
{
	$_SESSION['nom']=$nom;
}

function assigna_permisos($nivell)
{
	$_SESSION['nivell']=$nivell;
}

function es_administrador()
{
	if ($_SESSION['nivell']==10)	return true;
	else							return false;
}

function es_moderador()
{
	if ($_SESSION['nivell']==5)		return true;
	else							return false;
}

function es_convidat()
{
	if ($_SESSION['nivell']==1)	return true;
	else							return false;
}

function es_registrat()
{
	if ($_SESSION['nivell']==2)	return true;
	else							return false;
}

function acabar_sessio()
{
	session_unset();
	session_destroy();
}

?>