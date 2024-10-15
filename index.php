<?php

require_once 'TowerOfHanoi.php';

session_start();

// Initialize game if not exists
if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new TowerOfHanoi();
}

// Parse the request URL
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = trim($path, '/');

// Parse the request method
$method = $_SERVER['REQUEST_METHOD'];

// Define routes
if ($method === 'GET' && $path === 'state') {
    getState();
} elseif ($method === 'POST' && preg_match('/^move\/(\d+)\/(\d+)\/?$/', $path, $matches)) {
    $from = $matches[1];
    $to = $matches[2];
    makeMove($from, $to);
} else {
    // Handle 404 Not Found
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'Not Found']);
}

function getState() {
    $game = $_SESSION['game'];
    echo json_encode($game->getState());
}

function makeMove($from, $to) {
    $game = $_SESSION['game'];
    try {
        $game->move($from, $to);
        echo json_encode(['message' => 'Move successful', 'state' => $game->getState()]);
    } catch (Exception $e) {
        header("HTTP/1.0 400 Bad Request");
        echo json_encode(['error' => $e->getMessage()]);
    }
}
