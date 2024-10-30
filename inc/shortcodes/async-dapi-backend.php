<?php

$objApicallMng = new Apicall();
$action = isset($_GET['acttask']) ? $_GET['acttask'] : '';

if ($action == 'verify_domain') {

    $response = $objApicallMng->verify_domain();
    
    echo json_encode($response);

} elseif ($action == 'get_report') {

    $response = $objApicallMng->get_report();
    
    echo json_encode($response);

} elseif ($action == 'get_kundali_data') {

    $response = $objApicallMng->get_kundali_report_data();

    echo json_encode($response);
    
} elseif ($action == 'get_km_report') {

    $response = $objApicallMng->get_km_report();
    
    echo json_encode($response);

} elseif ($action == 'get_kundali_matching_data') {

    $response = $objApicallMng->get_kundali_matching_report_data();

    echo json_encode($response);
    
} else {
    
    echo 'Invalid backend request';

}

unset($objApicallMng);