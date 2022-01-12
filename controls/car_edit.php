<?php

include 'libraries/cars.class.php';
$carsObj = new cars();

include 'libraries/brands.class.php';
$brandsObj = new brands();

include 'libraries/models.class.php';
$modelsObj = new models();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('modelis', 'valstybinis_nr', 'pagaminimo_data', 'pavaru_deze', 'degalu_tipas', 'kebulas', 'bagazo_dydis', 'busena', 'rida', 'vietu_skaicius', 'registravimo_data', 'verte');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'valstybinis_nr' => 6
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'modelis' => 'positivenumber',
		'valstybinis_nr' => 'alfanum',
		'pavaru_deze' => 'positivenumber',
		'degalu_tipas' => 'positivenumber',
		'kebulas' => 'positivenumber',
		'bagazo_dydis' => 'positivenumber',
		'busena' => 'positivenumber',
		'pagaminimo_data' => 'date',
		'rida' => 'positivenumber',
		'vietu_skaicius' => 'positivenumber',
		'registravimo_data' => 'date',
		'verte' => 'price'
		);

	// sukuriame laukų validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$data = $_POST;

		// sutvarkome checkbox reikšmes
		if(isset($data['radijas']) && $data['radijas'] == 'on') {
			$data['radijas'] = 1;
		} else {
			$data['radijas'] = 0;
		}

		if(isset($data['grotuvas']) && $data['grotuvas'] == 'on') {
			$data['grotuvas'] = 1;
		} else {
			$data['grotuvas'] = 0;
		}

		if(isset($data['kondicionierius']) && $data['kondicionierius'] == 'on') {
			$data['kondicionierius'] = 1;
		} else {
			$data['kondicionierius'] = 0;
		}

		// atnaujiname duomenis
		$carsObj->updateCar($data);

		// nukreipiame vartotoją į automobilių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
	}
} else {
	// išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $carsObj->getCar($id);
}

// įtraukiame šabloną
include 'templates/car_form.tpl.php';

?>