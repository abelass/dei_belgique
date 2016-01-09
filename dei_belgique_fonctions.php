<?php
/**
 * Fonctions utiles au plugin DEI Belgique
 *
 * @plugin     DEI Belgique
 * @copyright  2015
 * @author     Rainer
 * @licence    GNU/GPL
 * @package    SPIP\Dei_belgique\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/*
 * Filtre pour afficher mettre en évidence le terme recherché
 * @param string $string le texte à parser
 * @param array $options 
 * 	resume : si le terme n'est pas trouvé, n'affiche rien.
 * 	wrapper : entourer le résultat d'un string déterminé
 * 	taille : nombre characterers avant et après le terme
 * @return string
 */
function recherche_avancee_google_like($string, $options=array()){
	
	$resume = isset($options['resume']) ? $options['resume'] : ($options['resume'] != 'non' ? $string : '');
	$wrapper = isset($options['wrapper']) ? '<i class="rsusp">[...]</i>' : '';
	$taille = isset($options['taille']) ? $options['taille'] : 55;

	// Convertir en texte brut sans accent
	$string = textebrut($string);

	$string = translitteration($string);

	$rech = translitteration(_request('recherche'));

	// Supprimer les caracteres qui m...

	$badguy = array("^", "/", "\\", "$", "@", "*");

	$rech = str_replace($badguy,"",$rech);

	// en avant

	$query = rtrim(str_replace("+", " ", $rech));  

	$qt = explode(" ", $query);
	if ($wrapper) {
		
		$num = count ($qt);
	
		// $cc = ceil(55 / $num);
	
		 $cc=$taille;
	
	
		for ($i = 0; $i < $num; $i++) 
	
		{
			$tab[$i] = preg_split("/\b($qt[$i])/i",$string,2, PREG_SPLIT_DELIM_CAPTURE);
	
			if (count($tab[$i])>1) {
				// Chaine avant
				$avant = substr($tab[$i][0],-$cc,$cc);
				$mots = split(" ",$avant,2);
				if (count($mots)>1) $avant = $mots[1];

			// Chaine apres
				$apres = substr($tab[$i][2],0,$cc);
				$apres = preg_replace('@(.+)\s\S+@s', '\1', $apres);

				// Concatener
				if ($string_re=='') {
					$string_re = $wrapper;
				}
				$string_re .= " $avant<span class=spip_surligne>".$tab[$i][1]."</span>$apres $wrapper";
			}
		}
	}
	else {
		
		$tab = preg_split("/\b($qt[$i])/i",$string,2, PREG_SPLIT_DELIM_CAPTURE);
		$pattern = array();
		$replace = array();
		
		foreach ($qt AS $t) {
			$pattern[] =  "/$t/";
			$replace[] = "<span class=spip_surligne>" . $t . "</span>";
		}
		
		$string_re = preg_replace($pattern,$replace,$string);
	}
	// Si rien trouve : renvoyer les premiers mots en resume

	if ($resume != '' AND $string_re == ''){

		$mots = split(" ",$string,40);

		for ($i = 0; $i < count($mots)-1; $i++)

		{	$string_re .= $mots[$i]." ";

			if (strlen($string_re)>2*$cc) break;

		}

		$string_re = $resume;

	}

	return $string_re;

}
?>