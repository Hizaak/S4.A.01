<?php

require_once "Affichage.php";

function initMatriceMarquage($taille) {
    $matriceMarquage = array();
    for ($i = 0; $i < $taille; $i++) {
        $matriceMarquage[$i] = array();
        for ($j = 0; $j < $taille; $j++) {
            $matriceMarquage[$i][$j] = 2;
        }
    }
    return $matriceMarquage;
}

function initTabCache($taille) {
    $tabCache = array();
    for ($i = 0; $i < $taille; $i++) {
        $tabCache[$i] = false;
    }
    return $tabCache;
}

function appliquerMethodeHongroise($matScores, $valMax) {

    $taille = count($matScores);
    $nbSelec = 0;
    $matriceMarquage = initMatriceMarquage($taille);
    $tabCacheL = initTabCache($taille);
    $tabCacheC = initTabCache($taille);

    afficherMat($matScores);
    echo "<br><br>";

    //soustraire la valeur minimale de chaque ligne à celle-ci
    for ($i = 0; $i < $taille; $i++) {
        $valMin = $matScores[$i][0];
        for ($j = 0; $j < $taille; $j++) {
            if ($matScores[$i][$j] < $valMin) {
                $valMin = $matScores[$i][$j];
            }
        }
        for ($j = 0; $j < $taille; $j++) {
            $matScores[$i][$j] -= $valMin;
        }
    }

    afficherMat($matScores);
    echo "<br><br>";

    //idem à chaque colonne
    for ($i = 0; $i < $taille; $i++) {
        $valMin = $matScores[0][$i]; 
        for ($j = 0; $j < $taille; $j++) {
            if ($matScores[$j][$i] < $valMin) {
                $valMin = $matScores[$j][$i];
            }
        }
        for ($j = 0; $j < $taille; $j++) {
            $matScores[$j][$i] -= $valMin;
        }
    }

    afficherMat($matScores);
    echo "<br><br>";

    // Tant que tous les étudiants ne sont pas sélectionnés
    while (true) {

        // Marquer les zéros
        $newZeroSelec = false;
        for ($i = 0; $i < $taille; $i++) {

            // On vérifie s'il y a déjà un zéro sélectionné sur la ligne
            $j = 0;
            $aUnSelecL = false;
            while ($j < $taille) {
                if ($matriceMarquage[$i][$j] == 0) {
                    $aUnSelecL = true;
                    break;
                }
                $j++;
            }

            if ($aUnSelecL == false) {

                // on tente de marquer un zéro
                $j = 0;
                while ($j < $taille) {
                    if ($matScores[$i][$j] == 0) {

                        // On vérifie s'il y a déjà un zéro sélectionné sur la colonne
                        $k = 0;
                        $aUnSelecC = false;
                        while ($k < $taille) {
                            if ($matriceMarquage[$k][$j] == 0) {
                                $aUnSelecC = true;
                                break;
                            }
                            $k++;
                        }
                            
                        // Si non, on marque le zéro
                        if ($aUnSelecC == false) {
                            $matriceMarquage[$i][$j] = 0;
                            $newZeroSelec = true;
                            break;
                        }
                    }
                    $j++;
                }
            }
        }
    
        // On découvre les lignes et colonnes et démarquons les primes
        if ($newZeroSelec) {
            $tabCacheL = initTabCache($taille);
            $tabCacheC = initTabCache($taille);
            for ($k = 0; $k < $taille; $k++) {
                for ($l = 0; $l < $taille; $l++) {
                    if ($matriceMarquage[$k][$l] == 1) {
                        $matriceMarquage[$k][$l] = 2;
                    }
                }
            }
        }
    
        // On compte le nombre de zéros sélectionnés
        $nbSelec = 0;
        for ($i = 0; $i < $taille; $i++) {
            for ($j = 0; $j < $taille; $j++) {
                if ($matriceMarquage[$i][$j] == 0) {
                    $nbSelec++;
                }
            }
        }
    
        // Si tous les étudiants sont sélectionnés, on arrête
        if ($nbSelec >= $taille) {
            break;
        }
    
        // On couvre les colonnes dont un zéro est sélectionné
        for ($i = 0; $i < $taille; $i++) {
            for ($j = 0; $j < $taille; $j++) {
                if ($matriceMarquage[$i][$j] == 0) {
                    $tabCacheC[$j] = true;
                }
            }
        }
    
        //marquege des primes
        $nbMaxPasSelec = False;
        $i = 0;
        while ($i < $taille) {
            $j = 0;
            while ($j < $taille) {
                if ($matScores[$i][$j]==0 and $matriceMarquage[$i][$j]!=0 and $tabCacheL[$i]==false and $tabCacheC[$j]==false) {
                    $matriceMarquage[$i][$j] = 1;

                    //vérifier s'il y a un zéro sélectionné sur la ligne
                    $k = 0;
                    $aUnSelecL = false;
                    while ($k < $taille) {
                        if ($matriceMarquage[$i][$k] == 0) {
                            $aUnSelecL = true;
                            break;
                        }
                        $k++;
                    }

                    // cacher la ligne et découvre la colonne du zéro sélectionné
                    if ($aUnSelecL == true) {
                        $tabCacheL[$i] = true;
                        $tabCacheC[$k] = false;
                        break;
                    }

                    //on a pas sélectionné le nombre max de zéros
                    else {
                        $nbMaxPasSelec = True;
                        break;
                    }
                }
                $j++;
            }
            if ($nbMaxPasSelec == True) {
                break;
            }
            $i++;
        }
        
        echo "iteration<br><br>";
        afficherMat($matScores);
        echo "<br><br>";
        afficherMat($matriceMarquage);
        echo "<br><br>";

        // On sélectionne le nombre max de zéros
        if ($nbMaxPasSelec == True) {
            $z = [];
            $z[] = [$i, $j];
            $i=1;
            $finSuite = false;
            while (true) {
                
                // On ajoute à la suite z le zéro sélectionné de la colonne de z[i-1] (soit z[i-1][1])) 
                $j=0;
                while (true){
                    if ($matriceMarquage[$j][$z[$i-1][1]]==0) {
                        $z[] = [$j, $z[$i-1][1]];
                        break;
                    }
                    $j++;
                    if ($j==$taille) {
                        $finSuite = true;
                        break;
                    }
                }

                // On ajoute à la suite z le 0 marqué d'un prime dans la ligne de z[i-1] (soit z[i-1][0])
                $j=0;
                while (true){
                    if ($matriceMarquage[$z[$i][0]][$j]==1) {
                        $z[] = [$z[$i][0], $j];
                        break;
                    }
                    $j++;
                    if ($j==$taille) {
                        $finSuite = true;
                        break;
                    }
                }

                // On a trouvé la suite
                if ($finSuite) {
                    break;
                }

                $i++;
            }

            //on démarque les primes et sélectionne les zéros
            for ($i = 0; $i < count($z); $i++) {
                if ($i%2==0) {
                    $matriceMarquage[$z[$i][0]][$z[$i][1]] = 0;
                }
                else {
                    $matriceMarquage[$z[$i][0]][$z[$i][1]] = 2;
                }
            }

            // On découvre les lignes et colonnes et démarquons les primes
            $tabCacheL = initTabCache($taille);
            $tabCacheC = initTabCache($taille);
            for ($k = 0; $k < $taille; $k++) {
                for ($l = 0; $l < $taille; $l++) {
                    if ($matriceMarquage[$k][$l] == 1) {
                        $matriceMarquage[$k][$l] = 2;
                    }
                }
            }
        }

        // Opérations avec l'élément libre le plus petit
        else {

            // On trouve l'élément libre le plus petit
            $valMin = $valMax;
            for ($i = 0; $i < $taille; $i++) {
                for ($j = 0; $j < $taille; $j++) {
                    if ($tabCacheL[$i] == false and $tabCacheC[$j] == false) {
                        if ($matScores[$i][$j] < $valMin) {
                            $valMin = $matScores[$i][$j];
                        }
                    }
                }
            }

            for ($i = 0; $i < $taille; $i++) {
                for ($j = 0; $j < $taille; $j++) {
                    // on ajoute la valeur minimale découverte à toutes les lignes couvertes
                    if ($tabCacheL[$i] == true) {
                        $matScores[$i][$j] += $valMin;
                    }
                    // on soustrait la valeur minimale découverte à toutes les colonnes découvertes
                    if ($tabCacheC[$j] == false) {
                        $matScores[$i][$j] -= $valMin;
                    }
                }
            }
        }
    }

    return $matriceMarquage;
}        

?>