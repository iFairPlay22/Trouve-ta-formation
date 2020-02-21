<?php
	/**
	* 
	*/
	class Url
	{
		
		function __construct()
		{
			
		}

		private static function createUrl_facets($labels, $url) {

			foreach ($labels as $key => $value) {
				$url .= "&facet=" . $key;
			}

			return $url;
		}

		private static function createUrl_q($url, $uaiArray) {
			
			$length = count($uaiArray) - 1;
			$url .= "&q=uai=";

			for ($i=0; $i <= $length; $i++) { 
				if ($i === $length) {
					$url .= $uaiArray[$i]["com_ins"]; 
				} else {
					$url .= $uaiArray[$i]["com_ins"] . " OR uai="; 
				}
			}

			return $url;
		}

		private static function addApiKey($url) {
			/*
				ewen.bouquet@free.fr
				trouvetaformation0
			*/
			return $url . "&apikey=e19263d0e7da770ba2244ac710dd4b31eb95d0e519f206c6a737398d";
		}

		private static function fetchUrl($url, &$contents) {

			$contents = file_get_contents($url);
		
			if($contents === false) {
				print("API connection failed...");
				exit(1);
			}

			JsManager::console_log($url);

			$contents = json_decode($contents, true);
		}

		public static function fetchUrl_1(&$labels, &$contents) {
			$labels = array(
	            "niveau_lib" => "Niveau d'études",
	            "diplome_lib" => "Nom de formation",
	            "etablissement_lib" => "Nom de l'établissement",
	            "gd_disciscipline_lib" => "Domaine d'études",
	            "sect_disciplinaire_lib" => "Secteur d'études",
	            "reg_etab_lib" => "Région",
	            "dep_ins_lib" => "Département",
	            "com_etab_lib" => "Ville"
	         );

			$url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&sort=-rentree_lib&rows=-1&facet=etablissement";
			$url = self::addApiKey($url);
			$url = self::createUrl_facets($labels, $url);
			$url = $url . "&refine.rentree_lib=2017-18";
			self::fetchUrl($url, $contents);
		}

		public static function fetchUrl_1_id(&$labels, &$contents, $id) {
			$labels = array(
				"La formation" => array(
					"diplome_lib" => "Nom de formation",
		            "niveau_lib" => "Niveau d'études",
		            "dn_de_lib" => "Type de diplome",
		            "etablissement_type2" => "Complément du type de diplome",
		            "libelle_intitule_1" => "Nom du diplome"
				),

				"La discipline" => array(
					"gd_disciscipline_lib" => "Nom de discipline",
		            "discipline_lib" => "Descriptif de la discipline",
		            "sect_disciplinaire_lib" => "Secteur de la dispcipline"
				),

				"L'établissement" => array(
					"etablissement_lib" => "Nom de l'établissement",
		            "etablissement_type_lib" => "Type d'établissement",
		            "gd_disciscipline_lib" => "Domaine d'études",
		            "sect_disciplinaire_lib" => "Secteur d'études"

				),

				"L'effectif" => array(
					"femmes" => "Nombre de femmes",
		            "hommes" => "Nombre d'hommes",
		            "effectif_total" => "Effectif total"
				),

				"La localisation" => array(
					"reg_etab_lib" => "Région",
	            	"dep_ins_lib" => "Département",
	            	"com_etab_lib" => "Ville"
				),

				"Informations complémentaires" => array(
					"element_wikidata" => "Lien wikipédia"
				)
	         );

			$facets = array();
			foreach ($labels as $category => $data) {
				foreach ($data as $attribute => $label) {
					array_push($attribute, $facets);
				}
			}

			$url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&sort=-rentree_lib&rows=-1&facet=etablissement";
			$url = self::addApiKey($url);
			$url = self::createUrl_facets($labels, $url);
			$url = $url . "$q=" . $id ."&refine.rentree_lib=2017-18";
			self::fetchUrl($url, $contents);
		}

		public static function fetchUrl_2(&$contents_2, $uaiArray) {
			$labels_2 = array(
				"uai" => "Identifiant",
				"coordonnees" => "Localisations",
				"url" => "Url du site",
				"uo_lib" => "Description de l'établissement"
			);

			//q=uai=... OR uai=... OR uai=...

			$url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur";
			$url = self::addApiKey($url);
			$url = self::createUrl_facets($labels_2, $url);
			$url = self::createUrl_q($url, $uaiArray);
			self::fetchUrl($url, $contents_2);
		}
	}
?>