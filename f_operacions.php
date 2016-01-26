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
	//afegir codi per crear usuaris
		echo " Nou usuari creat:".$nick;
		echo "<p><a href='index.php?operacio=llistar_usuaris'>Tornar</a>";
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
	//afegir codi per crear formulari per editar perfil usuaris
	echo '<h2>Modificar perfil</h2>
	<form name="form1" method="POST" action="index.php">
		<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">
			<tr><td> Nom i cognoms :</td> <td><input name="nomcognoms" type="text" value="nomcognoms"></td></tr>
			<tr><td> Edat :</td> <td> <input name="edat" type="text" value="edat"></td></tr> 
			<tr><td> Correu electr&oacute;nic :</td> <td> <input name="mail" type="text" value="mail"></td></tr> 
			<tr><td> Usuari acc&eacute;s:</td><td>nick</td></tr> 
			<tr><td> Contrasenya :</td> <td> <input name="contrasenya" type="password"></td></tr> 
			<tr><td colspan="2" align="center"><input type="submit" value="Modificar"></td></tr>
		</table>
		<input name="nick" type="hidden" value="nick"> 
		<input name="operacio" type="hidden" value="op_modificar_perfil">
	</form>
	<p><a href="index.php">Tornar</a>';
}




function modificarperfilusuari($nick, $nomcognoms, $edat, $mail, $pwd=0)
{
	//afegir codi per modificar dades perfil usuaris. Si el password es buit no modificar-lo.
	echo "Perfil modificat:".$nick;
	echo "<p><a href='index.php'>Tornar</a>";
}

function llistarnoticies(){
	$mysqli = new mysqli("localhost", "root", "root", "portal");
	$sql="select * from noticies";
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar la consulta";
		echo mysqli_error();
		exit;
	}
	echo "<a href='index.php'>Tornar a l\'&agrave;rea principal</a><br><br>";
	echo "<h2>Llistat de noticies</h2>";
	echo "<table width='70%' border='1'> <tr><td><b>Titol</b></td><td><b>Data</b></td><td><b>Tipus</b></td><td><b>Eliminar</b></td></tr>";
	while ( $row = $result->fetch_assoc() ){
		echo "<tr><td>".htmlentities($row['titol'])."</td><td>".htmlentities($row['data'])."</td><td>".htmlentities($row['tipus'])."</td>";
        echo "<td><a href='index.php?operacio=eliminar_noticia&b_noti=".htmlentities($row['codin'])."'>Eliminar</a></td></tr>";
	}
	echo "</table>";
	mysqli_free_result($result);
	mysqli_close($mysqli);
}

function borrarnoticia($codin){
	$mysqli = new mysqli("localhost", "root", "root", "portal");
	$sql="DELETE FROM noticies WHERE codin='".$codin."'" ;
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut eliminar la noticia.";
		echo mysqli_error();
		exit;
	}
	else {
		echo "<a href='index.php'>Tornar a l\'&agrave;rea principal</a><br><br>";
		echo "Noticia ".$codin." eliminada.";
		header('Location: index.php?operacio=llistar_noticies');
	}
	mysqli_free_result($result);
	mysqli_close($mysqli);
}

?>