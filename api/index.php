<?php
/*
 * A simple REST API that will match a Regular Expression to an Input Text and return the result.
 *
 * Author: Zemian Deng <zemiandeng@gmail.com>
 * Date: April 21, 2022
 */

function match_regex($regex, $input) {
    $matches = [];
    preg_match($regex, $input, $matches);
    return $matches;
}

// Allow any service to make pre-flight requests to this REST API
$allow_methods = "OPTIONS, GET, POST";
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: ' . $allow_methods);

// Main script request processing starts there
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 204 NO CONTENT");
    header('Allow: ' . $allow_methods);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = file_get_contents('php://input');
    $request_data = json_decode($body, true);
    $match_result = match_regex($request_data['regex'], $request_data['text']);
    echo json_encode($match_result);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = ["status" => "API Service is working!", "timestamp" => date('c')];
    echo json_encode($data);
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    header('Allow: ' . $allow_methods);
}
