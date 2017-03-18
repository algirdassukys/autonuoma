<?php
	
include 'libraries/employees.class.php';
$employeesObj = new employees();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('tabelio_nr', 'vardas', 'pavarde');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'tabelio_nr' => 6,
	'vardas' => 20,
	'pavarde' => 20
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'tabelio_nr' => 'alfanum',
		'vardas' => 'alfanum',
		'pavarde' => 'alfanum');

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// įrašome naują klientą
		$employeesObj->insertEmployee($dataPrepared);

		// nukreipiame vartotoją į klientų puslapį
		header("Location: index.php?module={$module}&action=list");
		die();
	}
	else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
}

// įtraukiame šabloną
include 'templates/employee_form.tpl.php';

?>