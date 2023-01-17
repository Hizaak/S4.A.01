<?php
function initMatriceMarquage($taille) {
    $matriceMarquage = array();
    for ($i = 0; $i < $taille; $i++) {
        $matriceMarquage[$i] = array();
        for ($j = 0; $j < $taille; $j++) {
            $matriceMarquage[$i][$j] = null;
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

    while (true) {

        $newZeroSelec = false;
        for ($i = 0; $i < $taille; $i++) {

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

                $j = 0;
                while ($j < $taille) {
                    if ($matScores[$i][$j] == 0) {

                        $k = 0;
                        $aUnSelecC = false;
                        while ($k < $taille) {
                            if ($matriceMarquage[$k][$j] == 0) {
                                $aUnSelecC = true;
                                break;
                            }
                            $k++;
                            }
                            
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
    
        if ($newZeroSelec) {
            $tabCacheL = initTabCache($taille);
            $tabCacheC = initTabCache($taille);
            for ($k = 0; $k < $taille; $k++) {
                for ($l = 0; $l < $taille; $l++) {
                    if ($matriceMarquage[$k][$l] == 1) {
                        $matriceMarquage[$k][$l] = null;
                    }
                }
            }
        }
    
        $nbSelec = 0;
        for ($i = 0; $i < $taille; $i++) {
            for ($j = 0; $j < $taille; $j++) {
                if ($matriceMarquage[$i][$j] == 0) {
                    $nbSelec++;
                }
            }
        }
    
        if ($nbSelec >= $taille) {
            break;
        }
    
        for ($i = 0; $i < $taille; $i++) {
            for ($j = 0; $j < $taille; $j++) {
                if ($matriceMarquage[$i][$j] == 0 && !$tabCacheC[$j]) {
                    $tabCacheC[$j] = true;
                    break;
                }
            }
        }
    
        for ($i = 0; $i < $taille; $i++) {
            for ($j = 0; $j < $taille; $j++) {
                if ($matriceMarquage[$i][$j] == 0 && !$tabCacheL[$i]) {
                    $tabCacheL[$i] = true;
                    break;
                }
            }
        }
    
        $valMin = $valMax;
        for ($i = 0; $i < $taille; $i++) {
            if (!$tabCacheL[$i]) {
                for ($j = 0; $j < $taille; $j++) {
                    if (!$tabCacheC[$j] && $matScores[$i][$j] < $valMin) {
                        $valMin = $matScores[$i][$j];
                    }
                }
            }
        }
    
        for ($i = 0; $i < $taille; $i++) {
            if ($tabCacheL[$i]) {
                for ($j = 0; $j < $taille; $j++) {
                    if ($tabCacheC[$j]) {
                        $matScores[$i][$j] += $valMin;
                    }
                }
            }
        }
    
        for ($i = 0; $i< $taille; $i++) {
            if (!$tabCacheL[$i]) {
                for ($j = 0; $j < $taille; $j++) {
                    if (!$tabCacheC[$j]) {
                        $matScores[$i][$j] -= $valMin;
                    }
                }
                }
            }
            for ($i = 0; $i < $taille; $i++) {
                for ($j = 0; $j < $taille; $j++) {
                    if (!$tabCacheL[$i] && !$tabCacheC[$j] && $matScores[$i][$j] == 0 && $matriceMarquage[$i][$j] == null) {
                        $matriceMarquage[$i][$j] = 1;
                    }
                }
            }
        }
        return $matriceMarquage;
    }        
    










?>