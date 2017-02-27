<?php
	// nuskaitome konfigūracijų failą
	include 'config.php';

	// iškviečiame prisijungimo prie duomenų bazės klasę
	include 'utils/mysql.class.php';

	// nustatome pasirinktos ataskaitos id
	$id = '';
	if(isset($_GET['id'])) {
		$id = mysql::escape($_GET['id']);
	}
	
?>