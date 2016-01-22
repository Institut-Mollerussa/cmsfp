<?php
// CMS FP
// funcions amb operacions del portal


include "config.php";


function connectar_bd()
{
	// implementar-ho a la funcio pare
}


function tancar_bd()
{
	// implementar-ho a la funcio pare
}



function obrir_sessio($nick, $pwd)
{
		//afegir codi per obrir la sessio
		assigna_id("admin");
		assigna_permisos(10);
		echo '<h3>Login ...</h3>';
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=index.php">';
}



function tancar_sessio()
{
	acabar_sessio();
	echo '<h3>Exit ...</h3>';
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=index.php">';
}




function llistarusuaris()
{
	global $CFG;
	$conn=mysqli_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	// resta de query
	
	//afegir codi per llistar usuaris
	echo '<a href="index.php?operacio=form_alta_usuari">Afegeix un usuari</a> | <a href="index.php">Tornar a l\'&agrave;rea principal</a><br><br>';
	echo '<h2>Llistat usuaris del portal: </h2>';
	echo '<table bgcolor="#C0D5BD" cellspacing=5 border="1" width="100%">';
		echo '<tr class="tlu">';
		echo '<td><strong>Pepe</strong></td>';
		echo '<td>Perez</td>';
		echo '<td>22</td>';
		echo '<td>pperez@hotmail.com</td>';
		echo '<td>10</td>';
		echo '<td><a href="index.php?operacio=form_modificar_usuari&nick=pepe">modificar</a></td>';	
		echo '<td><a href="index.php?operacio=op_eliminar_usuari&nick=pepe">eliminar</a></td>';
		echo '</tr>';
	echo '</table>';
}




function crearnouusuari($nick, $nomcognoms, $edat, $mail, $pwd, $nivell)
{	
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	//afegir codi per crear usuaris	
	$sql="insert into usuaris (nick, nomcognoms, contrasenya, mail, edat, nivell) values
	('".$nick."', '".$nomcognoms."', '".$pwd."', '".$mail."', '".$edat."', '".$nivell."')" ;
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar la inserció";
		echo mysqli_error();
		exit;
	}
	else {
		echo " Nou usuari creat: ".$nick;
		echo "<p><a href='index.php?operacio=llistar_usuaris'>Tornar</a>";
	}
	mysqli_close($mysqli);
}





function eliminarusuari($nick)
{
	//afegir codi per eliminar usuaris
		echo " Usuari ".$nick." eliminat.<br>";
		echo "<a href='index.php?operacio=llistar_usuaris'>Tornar</a>";
}




function formularimodificarusuari($nick)
{
	//afegir codi per modificar usuaris
	echo '<h2>Modificar usuari</h2>
	<form name="form1" method="POST" action="index.php">
	<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">
		<tr><td> Nom i cognoms :</td> <td><input name="nomcognoms" type="text" value="nomcognoms"></td></tr>
		<tr><td> Edat :</td> <td> <input name="edat" type="text" value="edat"></td></tr> 
		<tr><td> Correu electr&oacute;nic :</td> <td> <input name="mail" type="text" value="mail"></td></tr> 
		<tr><td> Usuari acc&eacute;s:</td><td>nick</td></tr> 
		<tr><td> Contrasenya :</td> <td> <input name="contrasenya" type="password"></td></tr> 
		<tr><td> Nivell :</td> <td> <input name="nivell" type="text" value="nivell"></td></tr> 
		<tr><td colspan="2" align="center"><input type="submit" value="Modificar"></td></tr>
	</table>
	<input name="nick" type="hidden" value="nick"> 
	<input name="operacio" type="hidden" value="op_modificar_usuari">
	</form>
	<p><a href="index.php?operacio=llistar_usuaris">Tornar &agrave;rea gesti&oacute;</a>
	<p><a href="index.php">Plana principal</a>';
}





function modificarusuari($nick, $nomcognoms, $edat, $mail, $pwd, $nivell)
{
	//afegir codi per modificar usuaris
		echo "Usuari modificat:".$nick;
		echo "<p><a href='index.php?operacio=llistar_usuaris'>Tornar</a>";
}



function formulariperfilusuari($nick)
{		
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	//connectar_bd();
	$sql="SELECT * FROM usuaris WHERE nick='".$nick."'" ;
	
	if ( ! $result = $mysqli->query($sql) ) {
			echo "No s'ha pogut realitzar l'actualització";
			echo mysqli_error();
			exit;
			
		}
		if($row = $result -> fetch_assoc()){
		
			echo '<h2>Modificar perfil</h2>
	<form name="form1" method="POST" action="index.php">
		<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">
			<tr><td> Nom i cognoms :</td> <td><input name="nomcognoms" type="text" value="'.$row['nomcognoms'].'"></td></tr>
			<tr><td> Edat :</td> <td> <input name="edat" type="text" value="'.$row['edat'].'"></td></tr> 
			<tr><td> Correu electr&oacute;nic :</td> <td> <input name="mail" type="text" value="'.$row['mail'].'"></td></tr> 
			<tr><td> Usuari acc&eacute;s:</td><td>'.$row['nick'].'</td></tr> 
			<tr><td> Contrasenya :</td> <td> <input name="contrasenya" type="password"></td></tr> 
			<tr><td colspan="2" align="center"><input type="submit" value="Modificar"></td></tr>
		</table>
		<input name="nick" type="hidden" value="'.$row['nick'].'"> 
		<input name="operacio" type="hidden" value="op_modificar_perfil">
	</form>
	<p><a href="index.php">Tornar</a>';
		}
		mysqli_free_result($result);
	//tancar_bd();
}




function modificarperfilusuari($nick, $nomcognoms, $edat, $mail, $pwd=0)
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	//connectar_bd();
	if($pwd!=0)
		$sql="UPDATE usuaris SET nick='".$nick."',nomcognoms='".$nomcognoms."', edat=".$edat.", mail='".$mail."', contrasenya='".$pwd."' WHERE nick='".$nick."'";
	else
		$sql="UPDATE usuaris SET nick='".$nick."',nomcognoms='".$nomcognoms."', edat=".$edat.", mail='".$mail."' WHERE nick='".$nick."'";
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar l'actualització";
		echo mysqli_error();
		exit;
	}
	else{
		echo "Perfil modificat:".$nick;
echo "<p><a href='index.php'>Tornar</a>";
	}

//afegir codi per modificar dades perfil usuaris. Si el password es buit no modificar-lo.	
	//tancar_bd();
}
?>