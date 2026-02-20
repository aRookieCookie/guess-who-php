<?php
    require_once __DIR__ . '/../includes/load_data.php';
    $characterDataset = load_data();

    // Opdracht 5: Toon alle personages met hun afbeelding.
    // Tip: De images staan in de map '../images/' en hebben de naam van het personage + '.png'.
    // Gebruik HTML om de lijst en images weer te geven.
    foreach($characterDataset as $character => $features) {
        if ($character === "_feature_order") {
        continue;
        }    

        echo "<h1>{$character}</h1> <img src='../images/{$character}.png'>";

    }