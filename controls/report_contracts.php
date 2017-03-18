<?php

include 'libraries/contracts.class.php';
$contractsObj = new contracts();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {

	// rodome ataskaitos parametrų įvedimo formą
	include 'templates/report_contracts_form.tpl.php';
} else {
	$formSubmitted = true;

	// nustatome laukų validatorių tipus
	$validations = array (
			'dataNuo' => 'date',
			'dataIki' => 'date');

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations);


	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$data = $validator->preparePostFieldsForSQL();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$fields = $_POST;

		// rodome ataskaitos parametrų įvedimo formą su klaidomis ir sustabdome scenarijaus vykdym1
		include 'templates/report_contracts_form.tpl.php';
		exit;
	}

	// išrenkame ataskaitos duomenis
	$contractData = $contractsObj->getCustomerContracts($data['dataNuo'], $data['dataIki']);
	$totalPrice = $contractsObj->getSumPriceOfContracts($data['dataNuo'], $data['dataIki']);
	$totalServicePrice = $contractsObj->getSumPriceOfOrderedServices($data['dataNuo'], $data['dataIki']);

	// rodome ataskaitą
	include 'templates/report_contracts_show.tpl.php';
}