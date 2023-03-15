
<?php

require_once "ReponseQCM.php";
require_once "ReponseLibre.php";
require_once "Etudiant.php";
require_once "Main.php";
/**
 * @param type $listEtud
 * @param type $listPremAn
 * @param type $listSecAn
 * @brief Ficher contenant les fonctions de calculs
 */


/**
* @brief Fonction qui separe les étudiants en deux listes : 1ère année et 2ème année
*  - Passage par référence de la liste d'étudiants, de la liste des étudiants de 1ère année et de la liste des étudiants de 2ème année
*  - Le resultat est stocké dans les tableau $listPremAn et $listSecAn
* @param type $listEtud
* @param type $repPremAn
* @param type $repSecAn
*/
function separerEtud(&$listEtud,&$listPremAn,&$listSecAn){
    for ($i = 0; $i < count($listEtud); $i++) {
        if ($listEtud[$i]->getNiveau() == 1) {
            $listPremAn[] = $listEtud[$i];
        } else {
            $listSecAn[] = $listEtud[$i];
        }
    }

}
/**
 * @brief Fonction qui calcule la distance entre les réponses des étudiants de 1ère année et de 2ème année
 * - Passage de la liste des étudiants de 1ère année et de la liste des étudiants de 2ème année
 * @param type $repPremAn
 * @param type $repSecAn
 * @return nt $distance 
 * @bug on arrive pas à faire un passage par référence des deux tableaux
 */

function calculerDistanceReponses($repPremAn,$repSecAn){
    $nbRepPremAn=count($repPremAn);
    //on creer un nouvel array avec  tout les elements sauf le dernier des deuxieme annee
    $nbRepSecAn=count($repSecAn); 
    $DEUXversUN = 0;
    for($i = 0; $i < $nbRepSecAn; $i++){
        // Si la réponse de l'étudiant de 2ème année est dans la liste des réponses de l'étudiant de 1ère année
        if(in_array($repSecAn[$i], $repPremAn)){
            $DEUXversUN += 1;
        }
    }
    
    $UNversDEUX = 0;
    for($i = 0; $i < $nbRepPremAn; $i++){
        // Si la réponse de l'étudiant de 1ère année est dans la liste des réponses de l'étudiant de 2ème année
        if(in_array($repPremAn[$i], $repSecAn)){
            $UNversDEUX += 1;
        }

    }

    $distance = (($UNversDEUX/$nbRepPremAn)*($DEUXversUN/$nbRepSecAn));
    return $distance;

}

?>