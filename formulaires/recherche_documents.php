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
	$mots = _request('mots') ? _request('mots') : array();
	$valeurs = array(
		"recherche" => _request('recherche'),
		"par" => _request('par'),
		'mots' => _request('mots'),
		'rubrique' => $id,
		);
	$clear = array();
	if (isset($options['parents'])) {
		if (is_array($rubriques) AND array_sum($rubriques)>0 AND !in_array('all',$rubriques)){
			$valeurs['_rubriques'] = $rubriques;
			$valeurs['_rubriques_sel'] = $rubriques;
		}
		else {
			$sql = sql_select('id_rubrique,titre','spip_rubriques','id_parent=' . $id);
			$rubriques = array();
			while ($data = sql_fetch($sql)) {
				$rubriques[] = $data['id_rubrique'];
				
			}
			$valeurs['_rubriques'] = $rubriques;
			if (in_array('all',$rubriques)) $clear['rubriques'] = TRUE;
		}
	}

	if (in_array('all',$mots)) $clear['mots'] = TRUE;
	
	$valeurs['clear'] = $valeurs;
	
	return $valeurs;
}
?>
