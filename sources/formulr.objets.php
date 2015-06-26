<?PHP


/**
 * Objets de base
 * @package FormulR
 * @author Olivier ROUET
 * @version 1.0.0
 */


/**
 * classe Formulr
 *
 * @package FormulR
 */
class Formulr
{


	/**
	 * Données à traiter
	 *
	 * @access public
	 * @var array
	 */
	public $donnees;
	
	
	/**
	 * DN
	 *
	 * @access public
	 * @var string
	 */
	public $structure;
	
	
	/**
	 * Variables cachées
	 *
	 * @access public
	 * @var array
	 */
	public $caches;
	
	
	/**
	 * Constructeur
	 *
	 */
	public function __construct ()
	{
	
		$this->structure = [];
	
	}
	
	
	/**
	 * Initialisation du formulaire
	 *
	 * @param string $document Document contenant la description du formulaire
	 * @return boolean
	 */
	public function initialiser($document)
	{
	
		// initialisation des variables
		$sortie = false;
		
		// traitement
		if (file_exists($document)) {
		
			include($document);
			
			$this->structure = $structure;
			$this->donnees = $structure;
			
			$sortie = true;
		
		}
		
		// sortie
		return $sortie;
	
	}
	
	
	/**
	 * Génère une ligne de formulaire
	 *
	 * @param array $ligne Tableau contenant les paramètres de la ligne
	 * @param boolean $avertissement Activation des avertissements
	 * @return string
	 */
	public function htmlSaisieGenerer($ligne, $avertissement = true)
	{
	
		// initialisation des variables
		$sortie = '';
		$parametres = $ligne['parametres'];
		
		// traitement
		switch ($parametres['format']) {
		
			case 'texte_court':
			
				$class = '';
				
				if ($avertissement && $ligne['erreur']) {
				
					$class .= ' erreur';
				
				}
				
				if ($parametres['obligatoire'] === true) {
				
					$class .= ' obligatoire';
				
				}
				
				$sortie .= '<tr class="' . $class . '">' . "\n";
				
				$sortie .= '<td class="libelle">';
				$sortie .= '<label for="' . $parametres['variable'] . '">';
				$sortie .= htmlspecialchars($parametres['libelle']) . " :";
				$sortie .= '</label>';
				$sortie .= '</td>' . "\n";
				
				$sortie .= '<td class="reponse">';
				$sortie .= '<input id="' . $parametres['variable'] . '" type="text" name="' . $parametres['variable'] . '" value="' . $parametres['valeur'] . '" size="' . $parametres['longueur'] . '" maxlength="' . $parametres['longueur'] . '" />';
				$sortie .= '</td>' . "\n";
				
				$sortie .= '</tr>' . "\n";
			
			break;
			
			
			case 'texte_long':
			
				$class = '';
				
				if ($avertissement && $ligne['erreur']) {
				
					$class .= ' erreur';
				
				}
				
				if ($parametres['obligatoire'] === true) {
				
					$class .= ' obligatoire';
				
				}
				
				$sortie .= '<tr class="' . $class . '">' . "\n";
				
				$sortie .= '<td class="libelle">';
				$sortie .= '<label for="' . $parametres['variable'] . '">';
				$sortie .= htmlspecialchars($parametres['libelle']) . " :";
				$sortie .= '</label>';
				$sortie .= '</td>' . "\n";
				
				$sortie .= '<td class="reponse">' . "\n";
				$sortie .= '<textarea id="' . $parametres['variable'] . '" name="' . $parametres['variable'] . '" cols="' . $parametres['colonnes'] . '" rows="' . $parametres['lignes'] . '">';
				$sortie .= $parametres['valeur'];
				$sortie .= '</textarea>' . "\n";
				$sortie .= '</td>' . "\n";
				
				$sortie .= '</tr>' . "\n";
			
			break;
			
			
			case 'liste':
			
				$class = '';
				
				if ($avertissement && $ligne['erreur']) {
				
					$class .= ' erreur';
				
				}
				
				if ($parametres['obligatoire'] === true) {
				
					$class .= ' obligatoire';
				
				}
				
				$sortie .= '<tr class="' . $class . '">' . "\n";
				
				$sortie .= '<td class="libelle">';
				$sortie .= '<label for="' . $parametres['variable'] . '">';
				$sortie .= htmlspecialchars($parametres['libelle']) . " :";
				$sortie .= '</label>';
				$sortie .= '</td>' . "\n";
				
				$sortie .= '<td class="reponse">' . "\n";
				$sortie .= '<select id="' . $parametres['variable'] . '" name="' . $parametres['variable'] . '">' . "\n";
				
				foreach ($parametres['choix'] as $choix) {
				
					$coche = '';
					
					if ($choix['code'] == $parametres['valeur']) {
					
						$coche = 'selected="selected"';
					
					}
					
					$sortie .= '<option ' . $coche . ' value="' . $choix['code'] . '">' . htmlspecialchars($choix['libelle']) . '</option>' . "\n";
					
				
				}
				
				$sortie .= '</select>' . "\n";
				$sortie .= '</td>' . "\n";
				
				$sortie .= '</tr>' . "\n";
			
			break;
			
			
			case 'coche':
			
				$class = '';
				$checked = '';
				
				if ($parametres['valeur'] === 'oui') {
				
					$checked = 'checked="checked"';
				
				}
				
				if ($avertissement && $ligne['erreur']) {
				
					$class .= ' erreur';
				
				}
				
				if ($parametres['obligatoire'] === true) {
				
					$class .= ' obligatoire';
				
				}
				
				$sortie .= '<tr class="' . $class . '">' . "\n";
				
				$sortie .= '<td class="libelle">';
				$sortie .= '<input id="' . $parametres['variable'] . '" type="checkbox" ' . $checked . ' name="' . $parametres['variable'] . '" value="oui" />';
				$sortie .= '</td>' . "\n";
				
				$sortie .= '<td class="reponse">';
				$sortie .= '<label for="' . $parametres['variable'] . '">';
				$sortie .= htmlspecialchars($parametres['libelle']);
				$sortie .= '</label>';
				$sortie .= '</td>' . "\n";
				
				$sortie .= '</tr>' . "\n";
			
			break;
		
		}
		
		// sortie
		return $sortie;
	
	}
	
	
	/**
	 * Génère le formulaire en HTML
	 *
	 * @param boolean $avertissement Activation des avertissements
	 * @return string
	 */
	public function htmlGenerer($avertissement = true)
	{
	
		// initialisation des variables
		$sortie = '';
		
		// traitement
		$form_id = '';
		$submit_id = '';
		
		if ($this->donnees['id'] != '') {
		
			$form_id = 'id="' . $this->donnees['id'] . '"';
			$submit_id = 'id="' . $this->donnees['id'] . '_submit"';
		
		}
		
		$div_class = '';
		
		if ($this->donnees['class'] != '') {
		
			$div_class = 'class="' . $this->donnees['class'] . '"';
		
		}
		
		$sortie .= '<form ' . $form_id . ' action="' . $this->donnees['action'] . '" method="' . $this->donnees['method'] . '">' . "\n";
		
		$sortie .= '<div ' . $div_class . '>' . "\n";
		
		foreach ($this->donnees['parties'] as $partie) {
		
			$sortie .= '<h3>' . $partie['titre'] . '</h3>' . "\n";
			$sortie .= '<br />' . "\n";
			
			$sortie .= '<table class="formulaire">' . "\n";
			
			foreach ($partie['lignes'] as $ligne) {
			
				switch ($ligne['type']) {
				
					case 'saisie' :
					
						$sortie .= $this->htmlSaisieGenerer($ligne, $avertissement);
					
					break;
					
					
					case 'cache':
					
						$parametres = $ligne['parametres'];
						
						$this->caches[] = [
							'variable' => $parametres['variable'],
							'valeur' => $parametres['valeur'],
						];
					
					break;
					
					
					case 'html':
					
						$parametres = $ligne['parametres'];
						
						$sortie .= '<tr>' . "\n";
						
						$sortie .= '<td colspan="2">' . "\n";
						
						$sortie .= $parametres['contenu'];
						
						$sortie .= '</td>' . "\n";
						
						$sortie .= '</tr>' . "\n";
					
					break;
				
				}
			
			}
			
			$sortie .= '</table>' . "\n";
		
		}
		
		
		$sortie .= '<div>' . "\n";
		
		if (isset($this->structure['mentions'])) {
		
			$mentions = $this->structure['mentions'];
			$sortie .= '<div class="' . $mentions['class'] . '">' . htmlspecialchars($mentions['texte']) . '</div>' . "\n";
		
		}
		
		foreach ($this->caches as $cache) {
		
			$sortie .= '<input type="hidden" name="' . $cache['variable'] . '" value="' . $cache['valeur'] . '" />' . "\n";
		
		}
		
		$sortie .= '<input ' . $submit_id . ' type="submit" value="Enregistrer" />' . "\n";
		
		$sortie .= '</div>' . "\n";
		
		$sortie .= '</div>' . "\n";
		
		$sortie .= '</form>' . "\n";
		
		// sortie
		return $sortie;
	
	}
	
	
	/**
	 * Injecte les données dans le formulaire
	 *
	 * @param array $donnees Données à traiter
	 * @return mixed
	 */
	public function alimenter($donnees)
	{
	
		// initialisation des variables
		$sortie = false;
		$formulaire = $this->structure;
		
		// traitement
		if (isset($formulaire['parties'])) {
		
			$sortie = $formulaire;
			
			$parties = $formulaire['parties'];
			$parties2 = [];
			
			foreach ($parties as $partie) {
			
				$partie2 = $partie;
				$partie2['lignes'] = [];
				
				if (isset($partie['lignes'])) {
				
					$lignes = $partie['lignes'];
					$lignes2 = [];
					
					foreach ($lignes as $cle => $ligne) {
					
						if ($ligne['type'] === 'saisie') {
						
							$parametres = $ligne['parametres'];
							$variable = $parametres['variable'];
							
							if (isset($donnees[$variable])) {
							
								$parametres['valeur'] = $donnees[$variable]['valeur'];
								
								if (count($donnees[$variable]['erreurs']) > 0) {
								
									$ligne['erreur'] = true;
								
								} else {
								
									$ligne['erreur'] = false;
								
								}
							
							}
							
							$ligne['parametres'] = $parametres;
						
						}
						
						if ($ligne['type'] === 'cache') {
						
							$parametres = $ligne['parametres'];
							$variable = $parametres['variable'];
							
							if (isset($donnees[$variable])) {
							
								$parametres['valeur'] = $donnees[$variable]['valeur'];
								
								if (count($donnees[$variable]['erreurs']) > 0) {
								
									$ligne['erreur'] = true;
								
								} else {
								
									$ligne['erreur'] = false;
								
								}
							
							}
							
							$ligne['parametres'] = $parametres;
						
						}
						
						$lignes2[] = $ligne;
					
					}
				
				}
				
				$partie2['lignes'] = $lignes2;
				
				$parties2[] = $partie2;
			
			}
			
			$sortie['parties'] = $parties2;
		
		}
		
		$this->donnees = $sortie;
		
		// sortie
		return $sortie;
	
	}


}


?>
