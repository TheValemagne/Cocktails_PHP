<main>
    <h1>Résultat de recherche</h1>

    <?php
    include_once('Donnees.inc.php');
    if (isset($_POST['requette'])) {
        try {
            $split = splitSearchString($_POST['requette']);

            $wanted = [];
            $unwanted = [];
            $notRecognized = [];
            foreach ($split['contains'] as $wantedItem) {
                if (findInData($wantedItem, $Hierarchie)) {
                    $wanted[] = $wantedItem;
                } else {
                    $notRecognized[] = $wantedItem;
                }
            }
            foreach ($split['notContains'] as $unwantedItem) {
                if (findInData($unwantedItem, $Hierarchie)) {
                    $unwanted[] = $unwantedItem;
                } else {
                    $notRecognized[] = $unwantedItem;
                }
            }

            if (!empty($wanted)) {
                echo "<p>Liste des aliments souhaités : " . implode(', ', $wanted) . "</p>";
            }
            if (!empty($unwanted)) {
                echo "<p>Liste des aliments non souhaités : " . implode(', ', $unwanted) . "</p>";
            }
            if (!empty($notRecognized)) {
                echo "<p>Éléments non reconnus dans la requête : " . implode(', ', $notRecognized) . "</p>";
            }

            if (empty($wanted) && empty($unwanted)) {
                echo "<p>Problème dans votre requête : recherche impossible</p>";
            } else {
                $recipes = findRecipies($wanted, $unwanted, $Hierarchie, $Recettes);

                print_r($recipes); // todo replace with bootstrap card function
            }

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }

    }

    ?>
</main>
