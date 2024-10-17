<?php

// Hey there! This is how you start the server: php -S localhost:8000
// Here's how to play:
// GET - http://localhost:8000/status (to see the current game state)
// POST - http://localhost:8000/move/1/3 (to move a disk from peg 1 to peg 3)
// POST - http://localhost:8000/reset (to start over)
// All code documentation and documentaries were generated with AI to better clarify

session_start(); // Let's remember stuff between requests!

// If we're just starting, let's set up the game
if (!isset($_SESSION['state'])) {
    $_SESSION['state'] = [
        [1, 2, 3, 4, 5, 6, 7], // All disks start on the first peg
        [], // Empty second peg
        []  // Empty third peg
    ];
    $_SESSION['isCompleted'] = false; // Game's not over yet!
}

// This function tells us what's going on in the game
function getState() {
    return json_encode([
        'state' => $_SESSION['state'],
        'isFinished' => $_SESSION['isCompleted']
    ]);
}

// This is where the magic happens - moving disks around!
function move($from, $to) {
    $from--; // We're using 1, 2, 3 for pegs, but arrays start at 0
    $to--;   // So we need to subtract 1
    
    // Game over? No more moves!
    if ($_SESSION['isCompleted']) {
        return json_encode(['error' => 'The game has already finished']);
    }
    
    // Oops, trying to use a non-existent peg?
    if ($from < 0 || $from > 2 || $to < 0 || $to > 2) {
        return json_encode(['error' => 'Invalid peg']);
    }
    
    // Can't move a disk that isn't there!
    if (empty($_SESSION['state'][$from])) {
        return json_encode(['error' => 'No disk on the source peg']);
    }
    
    $disk = $_SESSION['state'][$from][0]; // The disk we're trying to move
    
    // No putting big disks on little disks!
    if (!empty($_SESSION['state'][$to]) && $_SESSION['state'][$to][0] < $disk) {
        return json_encode(['error' => 'Cannot place a larger disk on top of a smaller one']);
    }
    
    // Move the disk from one peg to another
    array_unshift($_SESSION['state'][$to], array_shift($_SESSION['state'][$from]));
    
    // Did we just win? Let's check!
    $_SESSION['isCompleted'] = (count($_SESSION['state'][2]) == 7);
    
    return json_encode(['message' => 'Move successful']);
}

// Let's figure out what the player wants to do
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json'); // We're sending back JSON

// What does the player want?
if ($uri == '/status' && $method == 'GET') {
    echo getState(); // They want to know the current state
} elseif (preg_match('/\/move\/(\d+)\/(\d+)/', $uri, $matches) && $method == 'POST') {
    echo move($matches[1], $matches[2]); // They want to make a move
} elseif ($uri == '/reset' && $method == 'POST') {
    // They want to start over
    $_SESSION['state'] = [
        [1, 2, 3, 4, 5, 6, 7],
        [],
        []
    ];
    $_SESSION['isCompleted'] = false;
    echo json_encode(['message' => 'Game reset successfully']);
} else {
    // Uh oh, we don't know what they want
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}
