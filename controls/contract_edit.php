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

// nustatome privalomus laukus
$required = array('nr', 'sutarties_data', 'nuomos_data_laikas', 'planuojama_grazinimo_data_laikas', 'pradine_rida', 'kaina', 'degalu_kiekis_paimant', 'busena', 'fk_klientas', 'fk_darbuotojas', 'fk_automobilis', 'fk_grazinimo_vieta', 'fk_paemimo_vieta', 'kiekiai');

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'nr' => 'positivenumber',
		'sutarties_data' => 'date',
		'nuomos_data_laikas' => 'datetime',
		'planuojama_grazinimo_data_laikas' => 'datetime',
		'faktine_grazinimo_data_laikas' => 'datetime',
		'pradine_rida' => 'int',
		'galine_rida' => 'int',
		'kaina' => 'price',
		'degalu_kiekis_paimant' => 'int',
		'dagalu_kiekis_grazinus' => 'int',
		'busena' => 'positivenumber',
		'fk_klientas' => 'alfanum',
		'fk_darbuotojas' => 'alfanum',
		'fk_automobilis' => 'positivenumber',
		'fk_grazinimo_vieta' => 'positivenumber',
		'fk_paemimo_vieta' => 'positivenumber',
		'kiekiai' => 'int');

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// atnaujiname sutartį
		$contractsObj->updateContract($dataPrepared);

		// atnaujiname užsakytas paslaugas
		$contractsObj->updateOrderedServices($dataPrepared);

		// nukreipiame vartotoją į sutarčių puslapį
		if($formErrors == null) {
			header("Location: index.php?module={$module}&action=list");
			die();
		}
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();

		// laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
		$data = $_POST;
		if(isset($_POST['kiekiai']) && sizeof($_POST['kiekiai']) > 0) {
			$i = 0;
			foreach($_POST['kiekiai'] as $key => $val) {
				$data['uzsakytos_paslaugos'][$i]['kiekis'] = $val;
				$i++;
			}
		}
	}
} else {
	//  išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $contractsObj->getContract($id);
	$data['uzsakytos_paslaugos'] = $contractsObj->getOrderedServices($id);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;

// įtraukiame šabloną
include 'templates/contract_form.tpl.php';

?>