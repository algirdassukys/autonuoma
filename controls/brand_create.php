<?php

include 'libraries/brands.class.php';
$brandsObj = new brands();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('pavadinimas');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 20
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'pavadinimas' => 'anything');

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	if($validator->validate($_POST)) {
		if(config::FOR_READING_ONLY != 1) {
			// suformuojame laukų reikšmių masyvą SQL užklausai
			$dataPrepared = $validator->preparePostFieldsForSQL();
	
			// įrašome naują įrašą
			$brandsObj->insertBrand($dataPrepared);
		} else {
			$showEditWarning = true;
		}
		
		// įtraukiame parametrą į nukreipimo nuorodą, jeigu įjungtas tik skaitymo režimas
		$editWarning = '';
		if($showEditWarning == true) {
			$editWarning = '&edit_warning=1';
		}
		
		// nukreipiame į markių puslapį
		header("Location: index.php?module={$module}&action=list{$editWarning}");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
	}
}

// įtraukiame šabloną
include 'templates/brand_form.tpl.php';

?>