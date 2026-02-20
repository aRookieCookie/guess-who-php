<ol>
<?php
    require_once __DIR__ . '/../includes/load_data.php';
    $characterDataset = load_data();

    // Opdracht 3: Toon alle personages die een vrouw zijn.
    // Tip: Loop door alle personages en controleer de 'woman' feature.
    foreach($characterDataset as $character => $features) {
        if ($character === "_feature_order") {
        continue;
    }    

        if ($features["features"]["woman"] == 1){
            echo "<li>$character</li>";
        }
    }
?>
        </ol>