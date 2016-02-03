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
	global $CFG;
	$conn=mysqli_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);

	
	$sql="DELETE FROM usuaris WHERE nick='".$nick."'" ;
	
	
	if ( ! $resul=$conn->query($sql) ) {
		echo " problemes al eliminar l'usuari.";
		echo mysql_error();
		exit;
	}
	else
	{
		echo " Usuari ".$nick." eliminat.<br>";
		echo "<a href='index.php'>Tornar</a>";
	}
	
	tancar_bd();
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
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
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
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
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
		
		echo '<td><a href="index.php?operacio=op_visualitzar_pagina&head='.$row["head"].'">Visualitzar pagina</a></td>';
		
		echo '<td><a href="index.php?operacio=form_modificar_pagina&head='.$row["head"].'">Modificar pagina</a></td>';
		echo '<td><a href="index.php?operacio=op_eliminar_pagina&head='.$row["head"].'">Eliminar la pagina</a></td></tr>';
	}
	echo '</tr>';
	echo '</table>';
}
function eliminarpagina($head)
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
	$sql="delete from pagines where head like '".$head."'" ;
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar l eliminacio";
		echo mysqli_error();
		exit;
	}
	else {
		echo " La seguent pagina ha estat eliminada: ".$head;
		echo "<a href='index.php'>Tornar inici</a>&nbsp&nbsp";
		echo "<a href='index.php?operacio=llistar_pagines'>Enrera</a>";
	}
	mysqli_close($mysqli);
	    
		
}
function modificarpagina($head,$body,$oldhead)
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);

	
		$sql="UPDATE pagines SET head='".$head."',body='".$body."' where head='".$oldhead."'";
	
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar l'actualització";
		echo mysqli_error();
		exit;
	}
	else{
		echo "la seguent pagina ha estat modificada:".$head;
	echo "<a href='index.php'>Tornar inici</a>&nbsp&nbsp";
		echo "<a href='index.php?operacio=llistar_pagines'>Enrera</a>";
	}

}
function visualitzarpagina($head)
{
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$sql="select * from pagines where head='".$head."'";
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar la consulta";
		echo mysqli_error();
		exit;
	}
	
	echo "<a href='index.php'>Tornar inici</a>&nbsp&nbsp";
		echo "<a href='index.php?operacio=llistar_pagines'>Enrera</a>";
	echo "<h1>PAGINA VISUALITACIO</h1>";
	?>
	<div  id="header" style="font-size:300%;">  <h1> 
     
   <?php
   	while ( $row = $result->fetch_assoc() ){
		echo "<p>".htmlentities($row['head'])."</p>";
	
   
   
	?>
   
	 </h1>
    </div>
	<div style="width:106%;
height: 500px; border:solid 3px black; border-radius:20px;  background-color: #33FFFF ; font-size:200%;">
	
	
	
	<?php
	echo "<p>".htmlentities($row['body'])."</p>";
	
	}
	?>
	</div>
		
	
		<?php
	
	
	
	
	
	
	
	mysqli_free_result($result);
	mysqli_close($mysqli);
}

function modificarnoticia ($titol, $data, $descripcio, $tipus, $codin)
{

	global $CFG;

	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
	$sql="UPDATE noticies SET titol='".$titol."', data='".$data."', descripcio='".$descripcio."', tipus='".$tipus."', codin='".$codin."' where codin='".$codin."'";
	
	if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar l'actualització";
		echo mysqli_error();
		exit;
	}
	else{
		echo " La noticia amb el codi ".$codin." sha modificat correctment";
}
}


function formularimodificarnoticia ($codin)
{
	
		global $CFG;
	    $mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		$sql="SELECT * FROM noticies WHERE codin='".$codin."'";
		
		if ( ! $result = $mysqli->query($sql) ) {
		echo "No s'ha pogut realitzar la consulta";
		echo mysqli_error();
		exit;
}
else{
		if ($row = $result->fetch_assoc()){
			echo '<h2>Modificar noticia</h2>
					<form name="formulari" method="POST" action="index.php?operacio=op_modificar_noticia">	
						Titol: <input type="text" name="titol" value="'.$row['titol'].'"><br>
						Data: <input type="text" name="data" value="'.$row['data'].'"><br>
						Descripcio: <textarea name="descripcio" rows="6" cols="90" value="'.$row['descripcio'].'"> </textarea><br>
						Tipus : <select name="tipus" value="'.$row['tipus'].'">
							<option value="Esports">Esports</option>
							<option value="Economia">Economia</option>
							<option value="Politica">Politica</option>
							<option value="Societat">Societat</option>
							<option value="Cultura">cultura</option>
								</select>
						<input name="codin" type="hidden" value="'.$row['codin'].'"> 
						<input type="submit">Modificar</input>
					</form>';
				
		}
		else{
			echo "No existeix la noticia:" .$codin. ".";
		}
		
}
}




?>