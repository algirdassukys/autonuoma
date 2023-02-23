<?php

include 'libraries/contracts.class.php';
$contractsObj = new contracts();

include 'libraries/services.class.php';
$servicesObj = new services();

include 'libraries/cars.class.php';
$carsObj = new cars();

include 'libraries/employees.class.php';
$employeesObj = new employees();

include 'libraries/customers.class.php';
$customersObj = new customers();

$formErrors = null;
$data = array();

// gauname redaguojamos užsakytos paslaugos išrinkimo identifikatorius iš GET masyvo
$contractId = '';
if(isset($_GET['contractId'])) {
	$contractId = mysql::escapeFieldForSQL($_GET['contractId']);
}

$serviceId = '';
if(isset($_GET['serviceId'])) {
	$serviceId = mysql::escapeFieldForSQL($_GET['serviceId']);
}

$dateFrom = '';
if(isset($_GET['dateFrom'])) {
	$dateFrom = mysql::escapeFieldForSQL($_GET['dateFrom']);
}

// nustatome privalomus laukus
$required = array('kaina', 'kiekis');

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'kaina' => 'positivenumber',
		'kiekis' => 'positivenumber'
	);

	// sukuriame laukų validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$data = $_POST;

		// gauname paslaugos id, galioja nuo ir kaina reikšmes {$price['fk_paslauga']}:{$price['galioja_nuo']}:{$price['kaina']}
		$tmp = explode("#", $data['paslauga']);
				
		$data['fk_paslauga'] = $tmp[0];
		$data['fk_kaina_galioja_nuo'] = $tmp[1];
		
		// atnaujiname duomenis
		$contractsObj->updateOrderedService($data);

		// nukreipiame vartotoją į automobilių puslapį
		common::redirect("index.php?module={$module}&action=edit&id={$contractId}");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
} else {
	// išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $servicesObj->getOrderedService($contractId, $dateFrom, $serviceId);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include 'templates/contract2_service_form.tpl.php';

?>