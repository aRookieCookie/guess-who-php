<?php
    require_once __DIR__ . '/../includes/load_data.php';
    $characterDataset = load_data();

    // Opdracht 4: Toon alle personages die een man zijn, kaal zijn en een bril hebben.
    // Tip: Combineer meerdere voorwaarden in je if-statement.
    foreach($characterDataset as $character => $features) {
        if ($character === "_feature_order") {
        continue;
    }    

        if ($features["features"]["man"] == 1){
            if($features["features"]["bald"] == 1){
                if($features["features"]["beard"] == 1){
                    echo "<li>$character</li>";
                }
            }
            
        }
    }