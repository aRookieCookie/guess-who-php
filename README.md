# 🕵️‍♂️ PHP "Guess Who?" Board Game

A lightweight, session-based implementation of the classic "Guess Who" logic game. This project manages game state and character filtering dynamically using PHP sessions.

## 🚀 Core Features

* **Dynamic Filtering:** Automatically eliminates characters from the board based on feature guesses (e.g., "Does the character have a hat?").
* **Session Management:** Uses `$_SESSION` to track the secret character, remaining candidates, and win status without a database.
* **Win Detection:** Detects correct name guesses and triggers a victory overlay.
* **PRG Pattern:** Implements Post/Redirect/Get to ensure page refreshes don't re-trigger the last guess.
* **Flexible Dataset:** Driven by a modular data loading system.

## 📁 File Structure

* `index.php`: The main controller handling game logic, session updates, and the UI.
* `includes/load_data.php`: Helper script to load characters and feature sets.
* `css/style.css`: Styles for the character grid and the "You Win!" overlay.
* `images/`: Directory for character portraits (expected format: `CharacterName.png`).

## 🎮 How to Play

1.  **The Objective:** Identify the secret character chosen by the computer.
2.  **Ask about a Feature:** Select a feature from the dropdown. 
    * If the secret character has it, everyone without it is hidden.
    * If the secret character lacks it, everyone with it is hidden.
3.  **Guess a Name:** If you think you've found the match, select their name.
    * **Correct:** Victory screen appears!
    * **Incorrect:** That specific character is removed from the board.
4.  **Reset:** Use the "Play Again" or "Reset" button to clear the session and start a fresh round.

## ⚙️ Game Logic

The filtering engine compares boolean feature states between the secret character and the remaining pool:

1.  The user submits a feature guess $F$.
2.  The script determines the "truth" of $F$ for the secret character.
3.  The script iterates through `possible_characters` and `unset()` any character whose feature value for $F$ does not match.

```php
if (isset($features[$guess]) && (bool)$features[$guess] != $hasFeature) {    
    unset($_SESSION["possible_characters"][$key]);
}
