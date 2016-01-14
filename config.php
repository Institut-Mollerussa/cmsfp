<?php
// CMS FP
// globals amb les dades de la BBDD

/*	utilitzant variable global PHP 4.0<
	global $CFG;
	
	$CFG->dirroot="f:\\xampp\\htdocs\\c5\\_portalcss";
	$CFG->wwwroot="http://localhost/c5/_portalcss/";
	$CFG->dbhost="localhost";
	$CFG->dbname="portal";
	$CFG->dbuser="root";
	$CFG->dbpass="root";
*/

	class cCFG {
		public $dirroot="f:\\xampp2\\htdocs\\c5\\portalcss";
		public $wwwroot="http://localhost/c5/portalcss";
		public $dbhost="localhost";
		public $dbname="portal";
		public $dbuser="root";
		public $dbpass="root";
	}
	
	$CFG=new cCFG;

?>
