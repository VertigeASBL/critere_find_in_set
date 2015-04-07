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
function critere_find_in_set_dist($idb, &$boucles, $crit) {
    // Je sais pas à quoi ça sert, mais Cédric Morin fait comme ça dans bonux
    $boucle = &$boucles[$idb];

    // Récupérer le champ qui contient la liste d'élément
    $champ = $crit->param[1][0]->texte;

    // Les paramètre du find_in_set
    if ($crit->param[0][0]->type == 'champ') {

        // récupération de la balise du critère
        $arg = calculer_liste(array($crit->param[0][0]), array(), $boucles, $boucle->id_parent);

        // On créer le where
        $boucle->where[] = array("construire_find_in_set($arg, '$champ')");
    }
    // Dans le cas ou on entre manuellement la recherche dans la boucle
    elseif ($crit->param[0][0]->type == 'texte') {

        // On récupère la recherche
        $recherche = $crit->param[0][0]->texte;

        // On créer le wherer
        $boucle->where[] = array("construire_find_in_set($recherche, '$champ')");
    }
}


// Cette fonction va servir à contruire proprement le find_in_set
// Mais surtout à ne pas en créer si ce que l'on recherche est vide !
function construire_find_in_set($find, $champ) {

    // C'est vide on inihibe le where
    if (empty($find))
        return '1=1';
    else {
        // Si find est un tableau, on va chainer les FIND_IN_SET
        if (is_array($find)) {

            // On va nettoyer le tableau des éventuels élements vides
            $find = array_filter($find);

            $sql = array();
            foreach($find as $_find) {
                $_find = sql_quote($_find);
                $sql[] = "FIND_IN_SET($_find, $champ)";
            }
            $sql = implode(' AND ', $sql);
            return $sql;
        }
        else {
            $find = sql_quote($find);
            return "FIND_IN_SET($find, $champ)";
        }
    }
}
