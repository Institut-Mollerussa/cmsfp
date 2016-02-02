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
		echo "El nick o nom d'usuari ja existeix, per tant no puc crear l'usuari nou. Torna-hi amb un altre diferent";
		echo "<p><a href='index.php?operacio=llistar_usuaris'>Tornar</a>";
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

function form_fitxerpp()
{
	echo '<h2>Pujar fitxers</h2>
	<form name="form1" method="POST" action="index.php?operacio=pujar_fitxerpp" enctype="multipart/form-data">
		<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">
			<tr>
			<td>Arxiu:</td><td><input type="file" name="arxiu" /></td>
			</tr><tr>
			<td>Descripció Breu (Opcional):</td><td><input type="text" name="descripcio" /></td>
			</tr>
		</table><br>
		<input type="submit" name="enviar" value="Enviar" />
	</form>
	<p><a href="index.php?operacio=llistar_fitxerpp">Tornar</a></p>';
	
}

function pujar_fitxerpp($descripcio, $fitxer)
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// variable per limitar la mida de l'arxiu
	$maxim = 10240000; //10Mb
	if ( is_uploaded_file($fitxer['arxiu']['tmp_name']) ) 
	{ 	// Se ha subido?
	
		if ($fitxer['arxiu']['size'] <= $maxim ) 
		{ 	// No supera el tamany maxim

			$desti_serv = $CFG->dataroot.$fitxer['arxiu']['name'];
			echo $desti_serv;
			move_uploaded_file($fitxer['arxiu']['tmp_name'], $desti_serv);
			
			// aquesta versio no detecta sobrescriptura d'fitxerspp
			// estaria millor que el directori protegit, estigues en un config.php amb una variable $CFG->datadir = "f://...";

			if(!get_magic_quotes_gpc())
				$nom = addslashes($fitxer['arxiu']['name']); // Arreglamos el Nombre
			else 
				$nom = $fitxer['arxiu']['name'];
			
			$query = "INSERT INTO fitxerspp (nom,tipus,descripcio) VALUES ";
			$query.= "('".$nom."','".$fitxer['arxiu']['type']."','";
			$query.= mysql_real_escape_string($descripcio)."')";
			
			if ( ! $result = $mysqli->query($query) ) {
				echo "No s'ha pogut realitzar la inserció";
				echo mysqli_error();
				exit;
			}
			else {
				echo "<br>Fitxer pujat correctament<br><br>";
				echo "<a href='http://localhost/proves.php/cmsfp/index.php?operacio=llistar_fitxerpp'>Llistar Fitxers</a>";
			}
		} 
		else 
			echo "El tamany de l'arxiu es superior a 10Mb";
	} 
	else 
		echo "El fitxer no s'ha pujat";
}

function llistar_fitxerpp()
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="select * from fitxerspp";
	if ( ! $result = $mysqli->query($sql) ) {
	echo "No s'ha pogut realitzar la consulta";
	echo mysqli_error();
	exit;
	}
	else{
		echo "<p><b style=' font-size:30px;'>LLISTAT D'ARXIUS:</b></p>";
		echo "<button type='button'>
		<a style='text-decoration:none;' href='index.php?operacio=form_fitxerpp'>Agregar Fitxer</a>
		</button><br><br>"; 
		echo '<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">';
		echo "<tr>
				<td>Nom</td><td>Descripció</td><td>Descarregar</td><td>Eliminar</td>
			 </tr>";
		while ( $row = $result->fetch_assoc() ){
		echo "<tr>";
		//echo "<td>".$row['id']."</td>";
		echo "<td>".$row['nom']."</td>";
		echo "<td>".$row['descripcio']."</td>";
		echo "<td><a href='visor.php?operacio=descarregar_fitxerpp&id=".$row['id']."'>Descarregar</a></td>";
		echo "<td><a href='index.php?operacio=eliminar_fitxerpp&id=".$row['id']."&nom=".$row['nom']."'>Eliminar</a></td>";
		echo "</tr>";
		}
		echo "</table>";
		echo "<hr>";
		echo "<p><a href='index.php'>Tornar a la pagina principal</a></p>";
	}	
}

function descarregar_fitxerpp($id)
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="select * from fitxerspp where id=".$id;
	if ( ! $result = $mysqli->query($sql) ) {
	echo "No s'ha pogut realitzar la consulta";
	echo mysqli_error();
	exit;
	}
	else{
		while ( $row = $result->fetch_assoc() ){
		$origen_serv = $CFG->dataroot.$row['nom'];
		//$nom_arxiu = $row['nom'];
		$fp = fopen($origen_serv, 'r'); 
		$arxiu = fread($fp, filesize($origen_serv)); 
		fclose($fp); 
		header ("Content-Type: application/force-download");
		header('Content-Disposition: attachment; filename='.$arxiu);
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: inline; filename="'.$row["nom"].'"');
		//header("Content-Type: ".$row['tipus']);	
		header ("Content-Length: ".filesize($origen_serv));
		}
	}	
}

function eliminar_fitxerpp($id,$nom)
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="delete from fitxerspp where id=".$id;
	unlink($CFG->dataroot.$nom);
	if ( ! $result = $mysqli->query($sql) ) {
	echo "No s'ha pogut realitzar la consulta";
	echo mysqli_error();
	exit;
	}
	else{
		echo '
		<html>
		<head>
		<meta charset="UTF-8">
		<title>Eliminar fitxer</title>
		<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=index.php?operacio=llistar_fitxerpp">
		</head>

		<body bgcolor="#CCE8FD">

		<h1>Fitxer escborrat <br>Adeu!</h1>	
		</body>
		</html>
		';
	}
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

?>