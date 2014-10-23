<?php
/**
 * Fonctions utiles au plugin Critère find_in_set
 *
 * @plugin     Critère find_in_set
 * @copyright  2014
 * @author     Vertige (Didier)
 * @licence    GNU/GPL
 * @package    SPIP\Findinset\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Critère SPIP find_in_set
 * Utilisation
 * {find_in_set recherche, champ_sql}
 *
 * @access public
 */
function critere_find_in_set($idb, &$boucles, $crit, $left=false) {
    // Je sais pas à quoi ça sert, mais Morin fait comme ça dans bonux
    $boucle = &$boucles[$idb];

    // Les paramètre du find_in_set
    $recherche = $crit->param[0][0]->texte;
    $champ = $crit->param[1][0]->texte;

    // Ajouter le critère FIND_IN_SET au where de la boucle
    $boucle->where[] = array("'FIND_IN_SET(\'$recherche\', $champ)'");
}