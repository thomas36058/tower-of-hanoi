# Tower of Hanoi PHP Server

Welcome to the Tower of Hanoi PHP Server! This simple server allows you to play the classic Tower of Hanoi game through HTTP requests.

## 🎮 How the Game Works

The Tower of Hanoi is a mathematical game or puzzle consisting of three rods and a number of disks of various diameters. The puzzle starts with the disks stacked on one rod in order of decreasing size, the smallest at the top.

The objective of the game is to move the entire stack to the last rod, obeying the following rules:
1. Only one disk may be moved at a time.
2. Each move consists of taking the upper disk from one of the stacks and placing it on top of another stack or on an empty rod.
3. No disk may be placed on top of a disk that is smaller than it.

## 🚀 Key Assumptions and Specifications

- There are 7 disks in the game.
- At the beginning of the game, all 7 disks are on the first peg.
- The game is designed for a single session. There's no support for multiple games at the same time.
- The game state is kept in memory and not persisted to a database.

## 🛠️ Setup Instructions

1. Make sure you have PHP installed on your system. You can check by running:
   ```
   php --version
   ```

2. Clone this repository to your local machine:
   ```
   git clone https://github.com/thomas36058/tower-of-hanoi.git
   cd tower-of-hanoi
   ```

3. Start the PHP server:
   ```
   php -S localhost:8000
   ```

   The server will start running on `http://localhost:8000`.

## 🕹️ How to Play

You can interact with the game using HTTP requests. Here are the available endpoints:

1. **Get the current game state**
   - Method: GET
   - URL: `http://localhost:8000/status`
   - This will return the current state of the game, including the position of all disks and whether the game is finished.

2. **Make a move**
   - Method: POST
   - URL: `http://localhost:8000/move/{from}/{to}`
   - Replace `{from}` with the number of the peg you want to move from (1, 2, or 3)
   - Replace `{to}` with the number of the peg you want to move to (1, 2, or 3)
   - Example: To move a disk from peg 1 to peg 3, use `http://localhost:8000/move/1/3`

3. **Reset the game**
   - Method: POST
   - URL: `http://localhost:8000/reset`
   - This will reset the game to its initial state with all 7 disks on the first peg.

## 📝 Example Usage

You can use cURL in your terminal to interact with the game:

1. Get the current state:
   ```
   curl http://localhost:8000/status
   ```

2. Make a move:
   ```
   curl -X POST http://localhost:8000/move/1/3
   ```

3. Reset the game:
   ```
   curl -X POST http://localhost:8000/reset
   ```
