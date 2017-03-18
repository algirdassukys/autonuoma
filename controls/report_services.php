<?php

include 'libraries/services.class.php';
$servicesObj = new services();

$formErrors = null;
$fields = array();
$formSubmitted = false;

$data = array();
if(empty($_POST['submit'])) {
	
	// rodome ataskaitos parametrų įvedimo formą
	include 'templates/report_services_form.tpl.php';
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
		include 'templates/report_services_form.tpl.php';
		exit;
	}
	
	// išrenkame ataskaitos duomenis
	$servicesData = $servicesObj->getOrderedServices($data['dataNuo'], $data['dataIki']);
	$servicesStats = $servicesObj->getStatsOfOrderedServices($data['dataNuo'], $data['dataIki']);
	
	// rodome ataskaitą
	include 'templates/report_services_show.tpl.php';
}

