<?php
/**
 * Utilisations de pipelines par DEI Belgique
 *
 * @plugin     DEI Belgique
 * @copyright  2015
 * @author     Rainer
 * @licence    GNU/GPL
 * @package    SPIP\Dei_belgique\Pipelines
 */
if(!defined('_ECRIRE_INC_VERSION'))
	return;

/**
 * Ajout des boutons à la barre d'edition
 *
 * @pipeline porte_plume_barre_outils_pre_charger
 * @param  objet $barres La définition de la barre
 * @return objet La définition de la barre
 */
function dei_belgique_porte_plume_barre_pre_charger($barres) {
	
	$barre=&$barres['edition'];
	
	$barre->ajouterApres(
		'alignerdroite',array(
			// justifier <just>
			"id" => 'justifie',
			"name" => _T('dei_belgique:barre_outil_justifie'),
			"className"=>'outil_justifie',
			"openWith"=>"<justifie>",
			"closeWith"=>"</justifie>",
			"display"=>true,
		)
	);
	
	$barre->ajouterAvant(
		'petitescapitales',array(
			// souligner <souligner>
			"id" => 'souligne',
			"name" => _T('dei_belgique:barre_outil_souligne'),
			"className"=>'outil_souligne',
			"openWith"=>"<souligne>",
			"closeWith"=>"</souligne>",
			"display"=>true,
		)
	);
	
	return $barres;
}

/**
 * Lie les icones au boutons de la barre d'edition
 *
 * @pipeline porte_plume_lien_classe_vers_icone
 * @param  array $flux Les icones de la barre
 * @return array $flux Les icones de la barre
 */
function dei_belgique_porte_plume_lien_classe_vers_icone($flux) {
	return array_merge($flux, array(	
		'outil_justifie' => 'justifie.png',
		'outil_souligne' => 'souligne.png',
	));
}

/**
 * Insertion dans le pipeline post_propre (SPIP)
 * 
 * Remplacement de caracteres apres le passage de propre
 * 
 * @param $texte string
 * 	Le texte a modifier
 * @return $texte string
 */
function dei_belgique_pre_propre($texte) {

	$search = array(
		'<justifie>',
		'</justifie>',
		'<souligne>',
		'</souligne>'
	);
	$replace = array(
		"<p class='justifie'>",
		'',
		'<span class="souligne">',
		'</span>'
	);
		
	$texte = str_replace($search, $replace, $texte);

	return $texte;
}

