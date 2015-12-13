<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * chargement des valeurs par defaut des champs du #FORMULAIRE_RECHERCHE
 * on peut lui passer l'url de destination en premier argument
 * on peut passer une deuxième chaine qui va différencier le formulaire pour pouvoir en utiliser plusieurs sur une même page
 *
 * @param string $lien URL où amène le formulaire validé
 * @param string $class Une class différenciant le formulaire
 * @return array
 */
function formulaires_recherche_documents_charger_dist($id, $options){
	$rubriques = _request('rubriques');
	$r = (count($rubriques)>0) ? $rubriques : $id;
	$valeurs = array(
		"recherche" => _request('recherche'),
		"rubriques" => $rubriques  ? $rubriques : $id,
		"par" => _request('par'),
		'mots' => _request('mots'),
	);
	if (isset($options['parents']) AND !$r) {
		$sql = sql_select('id_rubrique,titre','spip_rubriques','id_parent=' . $id);
		$rubriques = array();
		while ($data = sql_fetch($sql)) {
			$rubriques[] = $data['id_rubrique'];
		}
		$valeurs['rubriques'] = $rubriques;
	}

	return $valeurs;
}
?>
