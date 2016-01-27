<?php
// CMS FP
// funcions amb elements d'interficie del portal

function capsalera()
{
	capsalera_content("");
}



function capsalera_content($content)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>CMS FP</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
	<?php echo $content; ?>
    <link href="default.css" rel="stylesheet" type="text/css" media="screen" />
    </head>
    <body>

    <!-- start header -->
    <div id="header">   
     <h1><b>CMS FP</b></h1>
    </div>
    <!-- end header -->
    
    <!-- start page -->
    <div id="page">
    
<?php 
}



function start_content()
{
?>
      <!-- start content -->
      <div id="content">
        <div class="post">
            <h2 class="title">Benvinguts</h2>
            <p class="meta"><small>al CMS FP</small></p>
            <p class="links">&nbsp;</p>
            <div class="entry"></div>
        </div>
<?php 
}



function end_content()
{
?>
      </div>
      <!-- end content -->
<?php
}



function start_sidebar()
{
?>
      <!-- start sidebar -->
      <div id="sidebar">
<?php 
}



function end_sidebar()
{
?>
      </div>
      <!-- end sidebar -->

<?php
}



function peu()
{
?>
    </div>
    <!-- end page -->

    <!-- start foot -->
    <div id="footer">
    <p id="legal">CMS FP designed by <a href="http://www.institutmollerussa.com">DAW Institut Mollerussa</a> | (CC) Creative Commons  </p>
    </div>
  </body>
  </html>
<?php 
}




function formularientradaportal()
{
		start_content(); end_content();
		start_sidebar();
?>
        <ul>
		<li>
        
        <h2><strong>Logar al portal </strong></h2>
        <form name="form1" method="POST" action="index.php?operacio=login">
        <ul>		
        <li>Usuari:</li>
        <li><input name="nick" type="text" id="nick"></li>
        <li>Contrasenya:</li>
        <li><input name="contrasenya" type="password" id="pwd"></li>
        <li><input type="submit" value="Entrar"></li>
        </form>
        </ul>
        
        </li>
		</ul>
<?php
		end_sidebar();
}



function pintar_intranet()
{
	start_content();
	end_content();
	start_sidebar();
	echo "<ul><li>";
	echo "<h2>Usuari:  ".id_usuari()."</h2>";
	
	if (es_administrador())
	{
?>
        <h2><strong>Administraci&oacute;</strong></h2>
        <ul>
        <li><a href="index.php?operacio=llistar_usuaris">Gesti&oacute; usuaris </a></li>
        <li><a href="index.php?operacio=llistar_noticies">Llistar noticies </a></li>
		 <li><a href="index.php?operacio=llistar_pagines">Crear Pagines </a></li>
<?php 
	}
	else if(es_moderador())
	{
?>
		Aqui el menu de moderador
<?php
	}
?>
    <li>&nbsp;</li>
    <li><strong>Opcions d'usuari</strong></li>
<?php
	echo '<li><a href="index.php?operacio=form_modificar_perfil&nick='.id_usuari().'">Modificar perfil</a></li>
	<li><a href="index.php?operacio=logout">Desconnectar</a></li></ul>
	</li></ul>';
		
	end_sidebar();
}




function formularicrearnouusuari()
{

?>
	<h2>Creaci&oacute; d'un nou usuari</h2>

	<form name="form1" method="POST" action="index.php">
	
	<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">
	<tr><td> Nom i cognoms :</td> <td><input name="nomcognoms" type="text"></td></tr>
	<tr><td> Edat :</td> <td> <input name="edat" type="text"></td></tr> 
	<tr>
	  <td> Correu electr&ograve;nic :</td> 
	  <td> <input name="mail" type="text"></td></tr> 
	<tr>
	  <td> Usuari d'acc&eacute;s:</td> 
	  <td> <input name="nick" type="text"></td></tr> 
	<tr><td> Contrasenya :</td> <td> <input name="contrasenya" type="password"></td></tr> 
	<tr><td> Nivell :</td> <td>
	  <select name="nivell">
	    <option value="10">administrador</option>
	    <option value="5">moderador</option>
	    <option value="2">registrat</option>
	    <option value="1">convidat</option>
	    </select>
		</td></tr> 
	<tr><td colspan="2" align="center"><input type="submit" value="Crear"></td></tr>
	</table>	  
	<input name="operacio" type="hidden" value="op_alta_usuari">
  </form>
  
<?php

}

function formularicrearnovapagina(){
?>
<h2> Creacio d'una nova pagina</h2>
<form name="form2" method="POST" action="index.php">
<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">
<tr><td> Head de la pagina:</td><td><input name="head" type="text"></td></tr>
<tr><td> Body de la pagina</td><td><input name="body" type="text"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Crear Pagina"></td></tr>
</table>
<input name="operacio" type="hidden" value="op_alta_pagina">
</form>

<?php
}
?>
