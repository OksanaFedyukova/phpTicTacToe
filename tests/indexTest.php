<?php
session_start();

// Define the functions to be tested from your original game code

function isGameOver($field) {
    // Check for a winner
    if ($winner = checkWinner($field)) {
        return $winner;
    }

    // Check for a tie
    $emptyCells = 0;
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($field[$i][$j] == '') {
                $emptyCells++;
            }
        }
    }
    if ($emptyCells == 0) {
        return 'tie';
    }

    return false;
}

function checkWinner($field) {
    // Check for horizontal wins
    for ($i = 0; $i < 3; $i++) {
        if ($field[$i][0] != '' && $field[$i][0] == $field[$i][1] && $field[$i][1] == $field[$i][2]) {
            return $field[$i][0];
        }
    }

    // Check for vertical wins
    for ($j = 0; $j < 3; $j++) {
        if ($field[0][$j] != '' && $field[0][$j] == $field[1][$j] && $field[1][$j] == $field[2][$j]) {
            return $field[0][$j];
        }
    }

    // Check for diagonal wins
    if ($field[0][0] != '' && $field[0][0] == $field[1][1] && $field[1][1] == $field[2][2]) {
        return $field[0][0];
    }
    if ($field[0][2] != '' && $field[0][2] == $field[1][1] && $field[1][1] == $field[2][0]) {
        return $field[0][2];
    }

    return false;
}

// Test cases
$testCases = [
    [
        'input' => [
            ['&#10060', '&#10060', '&#10060'],  // Horizontal win
            ['', '', ''],
            ['', '', ''],
        ],
        'expected' => '&#10060',
        'description' => 'Horizontal win for player'
    ],
    [
        'input' => [
            ['&#10060', '', ''],  // Vertical win
            ['&#10060', '', ''],
            ['&#10060', '', ''],
        ],
        'expected' => '&#10060',
        'description' => 'Vertical win for player'
    ],
    [
        'input' => [
            ['&#10060', '', ''],  // Diagonal win
            ['', '&#10060', ''],
            ['', '', '&#10060'],
        ],
        'expected' => '&#10060',
        'description' => 'Diagonal win for player'
    ],
    [
        'input' => [
            ['&#10060', '&#11093', '&#10060'],  // Tie
            ['&#11093', '&#10060', '&#11093'],
            ['&#11093', '&#10060', '&#11093'],
        ],
        'expected' => 'tie',
        'description' => 'Tie condition'
    ],
];

// Run the test cases
foreach ($testCases as $case) {
    $_SESSION['field'] = $case['input'];
    $result = isGameOver($_SESSION['field']);
    echo "Test: {$case['description']}\n";
    echo "Expected: {$case['expected']}, Got: $result\n";
    echo ($result === $case['expected']) ? "Test Passed\n\n" : "Test Failed\n\n";
}

?>

