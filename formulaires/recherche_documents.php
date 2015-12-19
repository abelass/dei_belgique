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
	// Si le scope sousrubriques
	if (isset($options['parents'])) {
		// Si recherche sur rubriques déterminés on le retournes
		if (is_array($rubriques) AND array_sum($rubriques)>0 AND !in_array('all',$rubriques)){
			$valeurs['_rubriques'] = $rubriques;
			$valeurs['_rubriques_sel'] = $rubriques;
		}
		// sinon on recherche les sousrubriques
		else {
			$sql = sql_select('id_rubrique,titre','spip_rubriques','id_parent=' . $id);
			$rubriques = array();
			while ($data = sql_fetch($sql)) {
				$rubriques[] = $data['id_rubrique'];
				
			}
			$valeurs['_rubriques'] = $rubriques;
		}
	}

	// Si recherche sur mots déterminés on établis les articles correspondants
	if (is_array($mots) AND array_sum($mots)>0 AND !in_array('all',$mots)){
		
		$where = "objet = 'article' AND (";
		$i = 0;
		$total = count($mots);
		foreach ($mots as $mot) {
			$i++;
			$where .= "id_mot = $mot";
			if ($i != $total) $where .= " AND ";
		}
		$where .= ")";
		
		$sql = sql_select("id_objet",'spip_mots_liens',$where);
		
		$articles = array();

		while ($data = sql_fetch($sql)){
			$articles[] = $data['id_objet'];
		}
		
		if (count($articles) > 0) {
			$valeurs['where'] = 'id_article IN (' . implode(',',$articles) . ')';
		}
		else $valeurs['where'] = 'id_article = 0';
	}
	return $valeurs;
}
?>
