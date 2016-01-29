<?php
// CMS FP
// globals amb les dades de la BBDD

/*	utilitzant variable global PHP 4.0<
	global $CFG;
	
	$CFG->dirroot="f:\\xampp\\htdocs\\cmsfp";
	$CFG->wwwroot="http://localhost/cmsfp/";
	$CFG->dbhost="localhost";
	$CFG->dbname="cmsfp";
	$CFG->dbuser="userDB";
	$CFG->dbpass="passwordDB";
*/

	class cCFG {
		public $dirroot="f:\\xampp2\\htdocs\\cmsfp";
		public $wwwroot="http://localhost/cmsfp";
		public $dbhost="localhost";
		public $dbname="cmsfp";
		public $dbuser="userDB";
		public $dbpass="passwordDB";
		public $tema="red";//red - default
	}
	
	$CFG=new cCFG;

?>
