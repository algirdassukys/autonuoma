<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/employees.class.php';
$employeesObj = new employees();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $employeesObj->getEmplyeesListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $employeesObj->getEmplyeesList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/employee_list.tpl.php';

?>