<?PHP


/**
 *
 * @package FormulR
 * @author Olivier ROUET
 * @version 1.0.0
 */


/**
 * Vérification d'un type
 * @package FormulR
 *
 * @param string $donnee
 * @return boolean
 */
function formulr_type_verifier($donnee, $type)
{

	// initialisation des variables
	$sortie = false;
	
	// traitement
	switch ($type) {
	
		case 'chaine':
		
			$sortie = is_string($donnee);
		
		break;
		
		
		case 'telephone':
		
			$sortie = formulr_chaine_telephone($donnee);
		
		break;
		
		
		case 'nombre' :
		
			$sortie = is_numeric($donnee);
		
		break;
		
		
		case 'date':
		
			$sortie = formulr_chaine_date($donnee);
		
		break;
		
		
		case 'email':
		
			$sortie = formulr_chaine_email($donnee);
		
		break;
		
		
		case 'code_postal':
		
			$sortie = formulr_chaine_code_postal($donnee);
		
		break;
	
	}
	
	// sortie
	return $sortie;

}



/**
 * Vérification d'un code postal
 * @package FormulR
 *
 * @param string $chaine
 * @return boolean
 */
function formulr_chaine_code_postal($chaine)
{

	// initialisation des variables
	$sortie = false;
	$tableau = array();
	$expression = '/[0-9]{4,5}/';
	
	// traitement
	if (preg_match($expression, $chaine, $tableau)) {
	
		$sortie = $tableau;
	
	}
	
	// sortie
	return $sortie;

}

/**
 * Vérification d'un numéro de téléphone
 * @package FormulR
 *
 * @param string $chaine
 * @return boolean
 */
function formulr_chaine_telephone($chaine)
{

	// initialisation des variables
	$sortie = false;
	$tableau = array();
	$expression = '/[0]{1}[1-9]{1}[0-9]{8}/';
	
	// traitement
	if (preg_match($expression, $chaine, $tableau)) {
	
		$sortie = $tableau;
	
	}
	
	// sortie
	return $sortie;

}



/**
 * Vérification d'une date
 * @package FormulR
 *
 * @param string $chaine
 * @return boolean
 */
function formulr_chaine_date($chaine)
{

	// initialisation des variables
	$sortie = false;
	$tableau = array();
	$expression = '/[0-9]{1,2}[\/]{1}[0-9]{1,2}[\/]{1}[0-9]{1,4}/';
	
	// traitement
	if (preg_match($expression, $chaine, $tableau)) {
	
		$sortie = $tableau;
	
	}
	
	// sortie
	return $sortie;

}



/**
 * Vérification d'un e-mail
 * @package FormulR
 *
 * @param string $chaine
 * @return boolean
 */
function formulr_chaine_email($chaine)
{

	// initialisation des variables
	$sortie = false;
	$tableau = array();
	$expression = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
	
	// traitement
	if (preg_match($expression, $chaine, $tableau)) {
	
		$sortie = $tableau;
	
	}
	
	// sortie
	return $sortie;

}



/**
 * Cherche et valide des correspondances entre un tableau d'entrées et un tableau de recherches
 * @package FormulR
 *
 * @param string $chaine
 * @return mixed
 */
function formulr_donnees_valider($recherches, $entrees)
{

	// initialisation des variables
	$sortie = false;
	$donnees = $_REQUEST;
	
	//traitement
	if (is_array($entrees)) {
	
		$donnees = $entrees;
	
	}
	
	if (is_array($recherches)) {
	
		$resultats = [];
		$bilan = [
			'total' => 0,
			'anomalies' => 0,
		];
		
		foreach ($recherches as $recherche) {
		
			$libelle = $recherche['libelle'];
			$type = $recherche['type'];
			$etat = $recherche['etat'];
			$vide = $recherche['vide'];
			$obligatoire = $recherche['obligatoire'];
			$defaut = $recherche['defaut'];
			$valeur = $recherche['valeur'];
			$erreurs = $recherche['erreurs'];
			
			$bilan['total']++;
			
			if (isset($donnees[$libelle])) {
			
				$donnee = $donnees[$libelle];
				
				if (formulr_type_verifier($donnee, $type) !== false) {
				
					if ($donnee !== $vide) {
					
						$valeur = $donnee;
					
					} else {
					
						$valeur = $defaut;
						
						if ($obligatoire === true) {
						
							$bilan['anomalies']++;
							
							$erreurs[] = [
								'code' => 0,
								'libelle' => 'variable vide',
							];
						
						}
					
					
					}
				
				} else {
				
					if ($obligatoire === true) {
					
						$bilan['anomalies']++;
						
						if ($donnee !== $vide) {
						
							$valeur = $donnee;
						
						} else {
						
							$valeur = $defaut;
						
						}
						
						$erreurs[] = [
							'code' => 1,
							'libelle' => 'type incorrect',
						];
					
					} else {
					
						if ($donnee !== $vide) {
						
							$valeur = $donnee;
							
							$erreurs[] = [
								'code' => 1,
								'libelle' => 'type incorrect',
							];
						
						} else {
						
							$valeur = $defaut;
						
						}
					
					
					}
				
				}
			
			} else {
			
				if ($obligatoire === true) {
				
					$bilan['anomalies']++;
					
					$erreurs[] = [
						'code' => 2,
						'libelle' => 'variable absente',
					];
				
				} else {
				
					$variable = $defaut;
				
				}
			
			}
			
			$resultat = [
				'libelle' => $libelle,
				'type' => $type,
				'etat' => $etat,
				'vide' => $vide,
				'obligatoire' => $obligatoire,
				'defaut' => $defaut,
				'valeur' => $valeur,
				'erreurs' => $erreurs,
			];
			
			$resultats[$libelle] = $resultat;
			
			unset($libelle);
			unset($type);
			unset($etat);
			unset($vide);
			unset($obligatoire);
			unset($defaut);
			unset($valeur);
			unset($erreurs);
			unset($resultat);
			unset($recherche);
		
		}
		
		$sortie = [
			'bilan' => $bilan,
			'resultats' => $resultats,
		];
	
	}
	
	// sortie
	return $sortie;

}


?>
