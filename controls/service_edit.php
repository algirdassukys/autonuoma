<?php
	
include 'libraries/contracts.class.php';
$contractsObj = new contracts();

include 'libraries/services.class.php';
$servicesObj = new services();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('pavadinimas', 'kainos', 'datos');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'pavadinimas' => 40,
	'aprasymas' => 300
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'pavadinimas' => 'anything',
		'aprasymas' => 'anything',
		'kainos' => 'price',
		'datos' => 'date');

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// atnaujiname duomenis
		$servicesObj->updateService($dataPrepared);

		// pašaliname nebereikalingas paslaugų kainas ir įrašome naujas
		// gauname esamas paslaugas
		$servicePrices = $servicesObj->getServicePrices($id);

		// jeigu paslaugos kainos nerandame iš formos gautame masyve, šaliname
		foreach($servicePrices as $priceDb) {
			$found = false;
			foreach($dataPrepared['kainos'] as $keyForm => $priceForm) {
				if($priceDb['kaina'] == $dataPrepared['kainos'][$keyForm] && $priceDb['galioja_nuo'] == $dataPrepared['datos'][$keyForm]) {
					$found = true;
				}
			}

			if(!$found) {
				// šalinama paslaugos kaina
				$servicesObj->deleteServicePrices($id, $priceDb['galioja_nuo'], $priceDb['kaina']);
			}
		}

		foreach($dataPrepared['kainos'] as $keyForm => $priceForm) {
			// jeigu paslaugos kainos nerandame duomenų bazėje, tačiau ji yra formoje, įrašome
			$found = false;
			foreach($servicePrices as $priceDb) {
				if($priceDb['kaina'] == $dataPrepared['kainos'][$keyForm] && $priceDb['galioja_nuo'] == $dataPrepared['datos'][$keyForm]) {
					$found = true;
				}
			}

			if(!$found) {
				// įrašoma paslaugos kaina
				$servicesObj->insertServicePrices($id, $dataPrepared['datos'][$keyForm], $dataPrepared['kainos'][$keyForm]);
			}
		}

		// nukreipiame į paslaugų puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
		if(isset($_POST['kainos']) && sizeof($_POST['kainos']) > 0) {
			$i = 0;
			foreach($_POST['kainos'] as $key => $val) {
				$data['paslaugos_kainos'][$i]['fk_paslauga'] = $id;
				$data['paslaugos_kainos'][$i]['kaina'] = $val;
				$data['paslaugos_kainos'][$i]['galioja_nuo'] = $_POST['datos'][$key];
				$data['paslaugos_kainos'][$i]['neaktyvus'] = $_POST['neaktyvus'][$key];
				$i++;
			}
		}

		array_unshift($data['paslaugos_kainos'], array());
	}
} else {
	// tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
	if(!empty($id)) {
		$data = $servicesObj->getService($id);
		$servicePrices = $servicesObj->getServicePrices($id);
		if(sizeof($servicePrices) > 0) {
			foreach($servicePrices as $key => $val) {
				// jeigu paslaugos kaina yra naudojama, jos koreguoti neleidziame ir įvedimo laukelį padarome neaktyvų
				$priceCount = $contractsObj->getPricesCountOfOrderedServices($id, $val['galioja_nuo']);
				if($priceCount > 0) {
					$val['neaktyvus'] = 1;
				}
				$data['paslaugos_kainos'][] = $val;
			}
		}

		// į paslaugų kainų masyvo pradžią įtraukiame tuščią reikšmę, kad paslaugų kainų formoje
		// būtų visada išvedami paslėpti formos laukai, kuriuos galėtume kopijuoti ir pridėti norimą
		// kiekį kainų
		array_unshift($data['paslaugos_kainos'], array());
	}
}

// įtraukiame šabloną
include 'templates/service_form.tpl.php';

?>