<?php /** @noinspection LanguageDetectionInspection */
session_start();

    function has_won(){

    }

    function resetGame(){
        session_unset();
        session_destroy();
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }

    require_once __DIR__ . '/../includes/load_data.php';
    $characterDataset = load_data();
    $charactersOnly = $characterDataset;
    unset($charactersOnly["_feature_order"]);

    if (!isset($_SESSION["possible_characters"])){
        $_SESSION["possible_characters"] = [];
        foreach ($charactersOnly as $character => $features) {
            array_push($_SESSION["possible_characters"], $character);
        }
    }


    if (!isset($_SESSION["guesses"])) {
        $_SESSION["guesses"] = [];
    }
    if (!isset($_SESSION["correct_character"])) {
        $char = array_rand($charactersOnly);
        $_SESSION["correct_character"] = $char;
    }



    var_dump($_SESSION["correct_character"]);
    echo"<br>";     
    var_dump($_SESSION["guesses"]);
    echo"<br>";   

    /* HANDLE GUESSES */
    # IF GUESS IS MADE
    if (isset($_POST["guess"])) {
        array_push($_SESSION["guesses"], $_POST["guess"]);
        $guess = $_POST["guess"];
        $correctName = $_SESSION["correct_character"];
        $correctFeatures = $characterDataset[$correctName];

        # If Guess is the correct character set isCorrect
        $isCorrect = ($guess === $_SESSION["correct_character"]);

        if ($isCorrect){
            # $_SESSION["guesses"] = $characterDataset[$_SESSION["correct_character"]];
            # ^ Only Display correct character when guessing the right name
            # Discontinued / Overwriten later, breaking
            $_SESSION["hasWon"] = true;
        }

        echo "<br>";

        # Check If Guess is Feature
        if (in_array($guess, $characterDataset["_feature_order"])){
            
            # If Feature:
            # Loop Trough All Features

            $hasFeature = (bool) $correctFeatures["features"][$guess];

            foreach ($_SESSION["possible_characters"] as $key => $name){
                $features = $charactersOnly[$name]["features"];
                
                if (isset($features[$guess]) && (bool)$features[$guess] != $hasFeature){    
                    unset($_SESSION["possible_characters"][$key]);
                }
            }
            $_SESSION["possible_characters"] = array_values($_SESSION["possible_characters"]);
        }

        #If its a name guess
        elseif (!$isCorrect){
            foreach ($_SESSION["possible_characters"] as $key => $name){
                if ($name == $guess){
                    unset($_SESSION["possible_characters"][$key]);
                    $_SESSION["possible_characters"] = array_values($_SESSION["possible_characters"]);
                }
            }
        }


        unset($_POST["guess"]);
        header("Location: " . $_SERVER["PHP_SELF"]); // ADD THIS
        exit;                                          // ADD THIS
    }

    if (isset($_POST["reset"])) {
        resetGame();
    }




    // Opdracht 7: Bouw het "Wie is het?" spel.
    // 1. Kies een willekeurig personage en sla dit op in de sessie.
    // 2. Maak een formulier waarmee de speler een feature kan kiezen om te vragen.
    // 3. Vergelijk de gekozen feature met die van het geheime personage.
    // 4. Geef antwoord ("Ja" of "Nee").
    // 5. Filter de lijst van overgebleven kandidaten op basis van het antwoord.
    // 6. Toon de overgebleven kandidaten.
    // 7. Voeg een reset-knop toe om een nieuw spel te starten.
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Guess Who – Board Game</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<form method="POST">
    <button type="submit" name="reset" class="reset">Reset</button>
</form>
    <h1>Guess Who?</h1>
    <main>
        <div class="left-card">
            <h2>Quess</h2>
            <form method="POST" action="" id="guessform">
                <h3><label for="guess">Make A Guess: </label></h3>
                <br>
                <select name="guess" id="guess">
                    <?php
                    echo "<optgroup label='Feature'>";
                    foreach ($characterDataset["_feature_order"] as $feature) {
                        echo "<option value='" . $feature . "'>" . $feature . "</option>";
                    }


                    echo "<optgroup label='Name'>";
                    foreach ($_SESSION["possible_characters"] as $character => $name) {
                            echo "<option value='" . $name . "'>" . $name . "</option>";
                    }
                    ?>
                </select>
            </form>
            <div class="wrapper">
                <button type="submit" id="submit" form="guessform">Guess</button>
            </div>


        </div>

        <div class="right-card">
            <h2>Board</h2>
            <div class="grid">
                <?php
                    foreach ($_SESSION["possible_characters"] as $character) {
                        echo "<div class='item'>";
                        echo '<img src="../images/' . $character . '.png">';
                        echo $character;
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </main>
        <div class="win-screen" style='visibility: <?php if (!isset($_SESSION["hasWon"])) {echo "hidden";} else {echo "visible";} ?>;'>
            <h1>You Win!</h1>
            <p>Correct Character was: "<?php echo $_SESSION["correct_character"] ?>"</p>
            <form method="POST">
                <button type="submit" name="reset" class="play-again">Play Again</button>
            </form>
        </div>
</body>
</html>
