<?php

require_once 'tower_of_hanoi.php';

session_start();

// Initialize game if not exists
if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new TowerOfHanoi();
}

$game = $_SESSION['game'];

// Parse the request URL
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = trim($path, '/');

// Parse the request method
$method = $_SERVER['REQUEST_METHOD'];

// Define routes
if ($method === 'GET' && $path === 'state') {
    getState($game);
} elseif ($method === 'POST' && preg_match('/^move\/(\d+)\/(\d+)$/', $path, $matches)) {
    $from = (int)$matches[1];
    $to = (int)$matches[2];
    makeMove($game, $from, $to);
} else {
    // Handle 404 Not Found
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'Not Found']);
}

function getState(TowerOfHanoi $game) {
    $state = $game->getState();
    echo json_encode($state);
}

function makeMove(TowerOfHanoi $game, int $from, int $to) {
    try {
        if ($game->getState()['status'] === 'completed') {
            throw new Exception("Game has already finished");
        }
        $game->move($from, $to);
        $newState = $game->getState();
        echo json_encode(['message' => 'Move successful', 'state' => $newState]);
    } catch (Exception $e) {
        header("HTTP/1.0 400 Bad Request");
        echo json_encode(['error' => $e->getMessage()]);
    }
}