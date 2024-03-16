# Tic-Tac-Toe PHP Web Application

This is a simple Tic-Tac-Toe game implemented in PHP. Players can play against a bot and the game state is maintained using PHP sessions.

## Getting Started

To run this application locally, follow these steps:

1. **Clone the repository:**
   git clone <url>
2. **Build the Docker container:**
   docker build -t tic-tac-toe 
3. **Run the Docker container:**
   docker run -d -p 8080:80 tic-tac-toe
4. **Access the application:**
Open your web browser and navigate to `http://localhost:8080`

## How to Play

- The game is played on a 3x3 grid.
- Players take turns placing their symbol (X or O) on an empty cell.
- The first player to get three of their symbols in a row (horizontally, vertically, or diagonally) wins the game.
- If all cells are filled without any player achieving three in a row, the game ends in a tie.

## Files Description

- `index.php`: Main PHP file containing the game logic and user interface.
- `style.css`: CSS file for styling the game interface.
- `reset.php`: PHP script to reset the game state and start a new game.
- `Dockerfile`: Dockerfile for building the Docker image.
- `README.md`: This file.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).






   
