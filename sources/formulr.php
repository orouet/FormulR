<?PHP


//
function formulr_type_verifier($donnee, $type)
{

	$sortie = false;
	
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
	
	}
	
	return $sortie;

}


//
function formulr_tableau_valider($recherches, $entrees)
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
				
					$valeur = $donnee;
					
					$erreurs[] = [
						'code' => 1,
						'libelle' => 'type incorrect',
					];
					
					if ($obligatoire === true) {
					
						$bilan['anomalies']++;
					
					}
				
				}
			
			} else {
			
				if ($obligatoire === true) {
				
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

//
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


//
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



//
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


?>