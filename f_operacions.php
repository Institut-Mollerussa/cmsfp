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
	$conn=mysqli_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="
	select * from usuaris;
	";
	if ( ! $result = $conn->query($sql) ) {
	echo "No s'ha pogut realitzar la consulta";
	echo mysqli_error();
	exit;
	}
	// resta de query
	
	//afegir codi per llistar usuaris
	echo '<a href="index.php?operacio=form_alta_usuari">Afegeix un usuari</a> | <a href="index.php">Tornar a l\'&agrave;rea principal</a><br><br>';
	echo '<h2>Llistat usuaris del portal: </h2>';
	echo '<table bgcolor="#C0D5BD" cellspacing=5 border="1" width="100%">';
	echo '<tr class="tlu">';
	echo "<tr>";
	echo "<td><strong>Nom</strong></td><td><strong>Cognom</strong></td><td><strong>E-mail</strong></td><td><strong>Edat</strong></td><td><strong>Nivell</strong></td><td><strong>Modificar usuari</strong></td><td><strong>Eliminar usuari</strong></td>";
	echo "</tr>";
	while ( $row = $result->fetch_assoc() ){
		echo "<tr>";
		echo "<td>";
		echo htmlentities($row['nick'])."<br></td>";
		echo "<td>";
		echo htmlentities($row['nomcognoms'])."<br></td>";
		echo "<td>";
		echo htmlentities($row['mail'])."<br></td>";
		echo "<td>";
		echo htmlentities($row['edat'])."<br></td>";
		echo "<td>";
		echo htmlentities($row['nivell'])."<br></td>";
		echo '<td><a href="index.php?operacio=form_modificar_usuari&nick='.$row["nick"].'">modificar</a></td>';
		echo '<td><a href="index.php?operacio=op_eliminar_usuari&nick='.$row["nick"].'">eliminar</a></td>';
	}
	echo '</tr>';
	echo '</table>';
}

//nick, nomcognoms,contrasenya,mail,edat,nivell


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




function formularimodificarusuari($nick) //Xavi
{
	//afegir codi per modificar usuaris
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="Select * from usuaris where nick='" .$nick ."'";
	if( ! $result = $mysqli->query($sql) ){
		echo "No s'ha pogut realitzar la consulta";
		echo mysqli_error();
		exit;
	}else{
		if ($row = $result->fetch_assoc()){
			echo '<h2>Modificar usuari</h2>
					<form name="form1" method="POST" action="index.php">
					<table bgcolor="#C0D5BD" cellpadding="5" cellspacing="2" border="1">
						<tr><td> Nom i cognoms :</td> <td><input name="nomcognoms" type="text" value="'.$row["nomcognoms"].'"></td></tr>
						<tr><td> Edat :</td> <td> <input name="edat" type="text" value="'.$row["edat"].'"></td></tr> 
						<tr><td> Correu electr&oacute;nic :</td> <td> <input name="mail" type="text" value="'.$row["mail"].'"></td></tr> 
						<tr><td> Usuari acc&eacute;s:</td><td>'.$row["nick"].'</td></tr> 
						<tr><td> Contrasenya :</td> <td> <input name="contrasenya" type="password"></td></tr> 
						<tr><td> Nivell :</td> <td> <input name="nivell" type="text" value="'.$row["nivell"].'"></td></tr> 
						<tr><td colspan="2" align="center"><input type="submit" value="Modificar"></td></tr>
					</table>
					<input name="nick" type="hidden" value="'.$row["nick"].'"> 
					<input name="operacio" type="hidden" value="op_modificar_usuari">
					</form>
					<p><a href="index.php?operacio=llistar_usuaris">Tornar &agrave;rea gesti&oacute;</a>
					<p><a href="index.php">Plana principal</a>';
		}else{
			echo "No existeix cap usuari amb aquest nick:" .$nick. ".";
		}
	}
}





function modificarusuari($nick, $nomcognoms, $edat, $mail, $pwd, $nivell) //Xavi
{
	//afegir codi per modificar usuaris
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="Update usuaris set nomcognoms='".$nomcognoms."', edat=".$edat.", mail='".$mail."', contrasenya='".$pwd."', nivell='".$nivell."' where nick='" .$nick ."'";
	
	if( ! $result = $mysqli->query($sql) ){
		echo "No s'ha pogut realitzar l'actualització";
		echo mysqli_error();
		exit;
	}else{
		echo "Usuari modificat:".$nick;
		echo "<p><a href='index.php?operacio=llistar_usuaris'>Tornar</a>";
	}
}



function formulariperfilusuari($nick)
{		
	global $CFG;
	if(id_usuari()==$nick){
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
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

else{
	echo "T'has de logar primer";
}
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


function llistarnoticies()
{
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

function borrarnoticia($codin)
{
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
function crearnovapagina($head, $body){
   
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
	$sql="insert into pagines (head,body) values
	('".$head."', '".$body."')" ;
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar la inserció";
		echo mysqli_error();
		exit;
	}
	else {
		echo " Nova pagina creada: ".$head;
		echo "<p><a href='index.php?operacio=llistar_pagines'>Tornar</a>";
	}
	mysqli_close($mysqli);
}
function llistarpagines()
{
	global $CFG;
	$conn=mysqli_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="select head from pagines;";
	if ( ! $result = $conn->query($sql) ) {
	echo "No s'ha pogut realitzar la consulta";
	echo mysqli_error();
	exit;
	}
	
    echo '<a href="index.php?operacio=form_alta_pagina">Afegeix una pagina</a> | <a href="index.php">Tornar a l\'&agrave;rea principal</a><br><br>';
	echo '<h2>Llistat pagines del portal: </h2>';
	echo '<table bgcolor="#C0D5BD" cellspacing=5 border="1" width="100%">';
	echo '<tr class="tlu">';
	
	echo "<tr><td><strong>Nom de la pagina</strong></td></tr>";
	
	while ( $row = $result->fetch_assoc() ){
		echo "<tr><td>";
		echo htmlentities($row['head'])."<br></td>";
		
		echo '<td><a href="index.php?operacio=op_visualitzar_pagina">Visualitzar pagina</a></td>'
		echo '<td><a href="index.php?operacio=form_modificar_pagina&head='.$row["head"].'">Modificar pagina</a></td>';
		echo '<td><a href="index.php?operacio=op_eliminar_pagina&head='.$row["head"].'">Eliminar la pagina</a></td></tr>';
	}
	echo '</tr>';
	echo '</table>';
}





?>