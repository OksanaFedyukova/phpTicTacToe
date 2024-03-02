<?php
session_start();

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

// Function to check if a player has won
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

// Function to check for a winning move or block the opponent's winning move
function checkWinningMove(&$field, $symbol) {
    // Check rows for winning moves
    for ($i = 0; $i < 3; $i++) {
        if ($field[$i][0] == $symbol && $field[$i][1] == $symbol && $field[$i][2] == '') {
            $field[$i][2] = '&#11093'; // Block the winning move
            return true;
        }
        if ($field[$i][0] == $symbol && $field[$i][2] == $symbol && $field[$i][1] == '') {
            $field[$i][1] = '&#11093'; // Block the winning move
            return true;
        }
        if ($field[$i][1] == $symbol && $field[$i][2] == $symbol && $field[$i][0] == '') {
            $field[$i][0] = '&#11093'; // Block the winning move
            return true;
        }
    }

    // Check columns for winning moves
    for ($j = 0; $j < 3; $j++) {
        if ($field[0][$j] == $symbol && $field[1][$j] == $symbol && $field[2][$j] == '') {
            $field[2][$j] = '&#11093'; // Block the winning move
            return true;
        }
        if ($field[0][$j] == $symbol && $field[2][$j] == $symbol && $field[1][$j] == '') {
            $field[1][$j] = '&#11093'; // Block the winning move
            return true;
        }
        if ($field[1][$j] == $symbol && $field[2][$j] == $symbol && $field[0][$j] == '') {
            $field[0][$j] = '&#11093'; // Block the winning move
            return true;
        }
    }

    // Check diagonals for winning moves
    if ($field[0][0] == $symbol && $field[1][1] == $symbol && $field[2][2] == '') {
        $field[2][2] = '&#11093'; // Block the winning move
        return true;
    }
    if ($field[0][0] == $symbol && $field[2][2] == $symbol && $field[1][1] == '') {
        $field[1][1] = '&#11093'; // Block the winning move
        return true;
    }
    if ($field[1][1] == $symbol && $field[2][2] == $symbol && $field[0][0] == '') {
        $field[0][0] = '&#11093'; // Block the winning move
        return true;
    }
    if ($field[0][2] == $symbol && $field[1][1] == $symbol && $field[2][0] == '') {
        $field[2][0] = '&#11093'; // Block the winning move
        return true;
    }
    if ($field[0][2] == $symbol && $field[2][0] == $symbol && $field[1][1] == '') {
        $field[1][1] = '&#11093'; // Block the winning move
        return true;
    }
    if ($field[1][1] == $symbol && $field[2][0] == $symbol && $field[0][2] == '') {
        $field[0][2] = '&#11093'; // Block the winning move
        return true;
    }

    return false;
}

// Function for bot's move
function botMove(&$field) {
    // Check if the bot can win in the next move
    if (checkWinningMove($field, '&#11093')) {
        return;
    }

    // Check if the player can win in the next move and block that move
    if (checkWinningMove($field, '&#10060')) {
        return;
    }

    // Place the bot's symbol in a strategic position
    // For simplicity, let's place it randomly in an empty cell
    do {
        $random_i = rand(0, 2);
        $random_j = rand(0, 2);
    } while ($field[$random_i][$random_j] !== '');
    
    $field[$random_i][$random_j] = '&#11093'; // Place bot's symbol
}

// Initialize game field if not already set
if (!isset($_SESSION["field"])) {
    $_SESSION["field"] = [
        ["", "", ""],
        ["", "", ""],
        ["", "", ""],
    ];
}

// Process player's move
if (isset($_GET['i']) && isset($_GET['j'])) {
    $turn_i = intval($_GET['i']);
    $turn_j = intval($_GET['j']);

    // Place player's symbol in the specified cell
    $_SESSION['field'][$turn_i][$turn_j] = '&#10060'; // Player's symbol

    // Check if the game is over
    if ($result = isGameOver($_SESSION['field'])) {
        // Game over, display result
        if ($result == 'tie') {
            $message = 'It\'s a tie!';
        } else {
            $message = 'Player ' . $result . ' wins!';
        }
    } else {
        // Bot makes a move
        botMove($_SESSION['field']);

        // Check if the game is over after the bot's move
        if ($result = isGameOver($_SESSION['field'])) {
            // Game over, display result
            if ($result == 'tie') {
                $message = 'It\'s a tie!';
            } else {
                $message = 'Player ' . $result . ' wins!';
            }
        }
    }
}


// Retrieve current game field
$field = $_SESSION['field'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP GAME</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h1>Tic-Tac-Toe</h1>
        <a href="reset.php"><button>Re-Start</button></a>
        <?php
        if (isset($message)) {
            echo '<p>' . $message . '</p>';
        }
        ?>
        <table>
            <?php
            for ($i = 0; $i < 3; $i++) {
                echo '<tr>';
                for ($j = 0; $j < 3; $j++) {
                    $cell_value = $field[$i][$j];
                    echo '<td>';
                    echo "<form>
                           <input type='hidden' name='i' value='$i'>
                           <input type='hidden' name='j' value='$j'>
                           <input type='submit' value='$cell_value'>
                           </form>";
                    echo '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
      
    </div>
</body>

</html>
