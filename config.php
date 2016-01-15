<?php
// CMS FP
// globals amb les dades de la BBDD

/*	utilitzant variable global PHP 4.0<
	global $CFG;
	
	$CFG->dirroot="f:\\xampp\\htdocs\\m9\\cmsfp";
	$CFG->wwwroot="http://localhost/m9/cmsfp/";
	$CFG->dbhost="localhost";
	$CFG->dbname="portal";
	$CFG->dbuser="root";
	$CFG->dbpass="root";
*/

	class cCFG {
		public $dirroot="f:\\xampp2\\htdocs\\m9\\cmsfp";
		public $wwwroot="http://localhost/m9/cmsfp";
		public $dbhost="localhost";
		public $dbname="portal";
		public $dbuser="root";
		public $dbpass="root";
	}
	
	$CFG=new cCFG;

?>
