# Tower of Hanoi API

This project implements a simple HTTP API for playing the Tower of Hanoi game. The game starts with 7 disks on the first peg, and the goal is to move all disks to the third peg following the rules of the game.

## Game Rules

1. Only one disk can be moved at a time.
2. Each move consists of taking the upper disk from one of the stacks and placing it on top of another stack or on an empty rod.
3. No larger disk may be placed on top of a smaller disk.

## API Endpoints

The API provides two main endpoints:

### 1. Get Game State

- **URL:** `/state`
- **Method:** `GET`
- **Success Response:**
  - **Code:** 200
  - **Content:** JSON object containing the current state of the game
    ```json
    {
      "towers": [[7,6,5,4,3,2,1],[],[]],
      "moves_made": 0,
      "status": "in_progress"
    }
    ```

### 2. Make a Move

- **URL:** `/move/{from}/{to}`
- **Method:** `POST`
- **URL Params:** 
  - `from`: Number of the peg to move from (1, 2, or 3)
  - `to`: Number of the peg to move to (1, 2, or 3)
- **Success Response:**
  - **Code:** 200
  - **Content:** JSON object containing a success message and the new game state
- **Error Response:**
  - **Code:** 400
  - **Content:** JSON object with an error message

## How to Play

1. Start by getting the initial state of the game:
   ```
   GET /state
   ```

2. Make moves by sending POST requests:
   ```
   POST /move/1/2  (moves a disk from peg 1 to peg 2)
   ```

3. Continue making moves and checking the state until all disks are on the third peg.

4. The game is completed when the `status` in the state response is "completed".

## Example Gameplay

1. Get initial state:
   ```
   GET /state
   ```

2. Move the top disk from peg 1 to peg 3:
   ```
   POST /move/1/3
   ```

3. Move the top disk from peg 1 to peg 2:
   ```
   POST /move/1/2
   ```

4. Move the disk from peg 3 to peg 2:
   ```
   POST /move/3/2
   ```

5. Continue making valid moves until all disks are on peg 3.

6. Check the state periodically to see your progress:
   ```
   GET /state
   ```

Remember, the goal is to move all disks to the third peg in the minimum number of moves. Good luck!