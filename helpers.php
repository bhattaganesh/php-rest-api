<?php
function sendResponse($status, $success, $message, $data = null) {
    header("HTTP/1.1 $status");

    $response = array(
        "success" => $success,
        "message" => $message,
        "data" => $data
    );

    echo json_encode($response);
    exit;
}

function sanitize($data) {
    // Remove any unwanted or malicious data from user input
    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return $data;
}


function escape($data) {
    // Encode any special characters in user input to prevent code injection
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
