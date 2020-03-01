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

		private static function createUrl_refine($url) {



			if (count($_POST) !== 0) {
				foreach ($_POST as $key => $value) {
					if ($value !== "") {
						$url .= "&refine.$key=$value";
					}
				}
			}
			
			return $url;
		}

		private static function createUrl_q($url, $dataArray, $name) {
			
			$length = count($dataArray) - 1;
			$url .= "&q=" . $name . "=";

			for ($i=0; $i <= $length; $i++) { 
				if ($i === $length) {
					$url .= $dataArray[$i]["etablissement"];
				} else {
					$url .= $dataArray[$i]["etablissement"] . " OR " . $name . "="; 
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

			JsManager::console_log($url);

			$contents = file_get_contents($url);

			if($contents === false) {
				print("API connection failed...");
				exit(1);
			}

			$contents = json_decode($contents, true);
		}

		public static function fetch_All_Formations_Etablissments(&$labels, &$contents, $with) {
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

			$url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&sort=-rentree_lib";
		
			$url = self::addApiKey($url);
			
			$url = self::createUrl_facets($labels, $url);
			
			// if (!isset($_POST["begin"])) {
			// 	$databaseActions = new DatabaseActions();
			// 	$etablissementArray = $databaseActions->getTop3();
			// 	$url = self::createUrl_q($url, $etablissementArray, "etablissement");
			// }

			if ($with === true) {
				$url = self::createUrl_refine($url);
				$url .= "&rows=" . ButtonBar::$_limit . "&start=" . (isset($_POST["begin"]) ? $_POST["begin"] : 0);
			} else {
				$url .= "&rows=-1";
			}

			$url .= "&facet=etablissement&facet=diplom&refine.rentree_lib=2017-18";
			
			self::fetchUrl($url, $contents);
		}

		private static function getFacetsArray($categories) {
			$facets = array();
			foreach ($categories as $category => $data) {
				foreach ($data as $attribute => $label) {
					$facets[$attribute] = $label;
				}
			}
			return $facets;
		}

		public static function fetch_Specific_Formations_Etablissment_More_Data(&$etablissment, &$formation, &$contents) {
			
			$etablissment = array(
				"L'établissement" => array(
					"etablissement_lib" => "Nom de l'établissement",
		            "etablissement_type_lib" => "Type d'établissement",
		            "gd_disciscipline_lib" => "Domaine d'études",
		            "sect_disciplinaire_lib" => "Secteur d'études"
				)
			);

			$formation = array(
				"L'établissement" => array(
					"etablissement_lib" => "Nom de l'établissement",
		            "etablissement_type_lib" => "Type d'établissement",
		            "gd_disciscipline_lib" => "Domaine d'études",
		            "sect_disciplinaire_lib" => "Secteur d'études"
				),

				"La discipline" => array(
					"gd_disciscipline_lib" => "Nom de discipline",
		            "discipline_lib" => "Détails sur la discipline",
		            "sect_disciplinaire_lib" => "Secteur de la dispcipline"
				),

				"La formation" => array(
					"diplome_lib" => "Nom de formation",
		            "dn_de_lib" => "Type de diplome",
					"libelle_intitule_1" => "Nom du diplome",
					"niveau_lib" => "Niveau d'études"
				),

				"L'effectif" => array(
					"femmes" => "Etudiantes",
		            "hommes" => "Etudiants",
		            "effectif_total" => "Effectif total"
				)
			 );
			 
			$etablissmentObject = new ArrayObject($etablissment);
			$formationObject = new ArrayObject($formation);
			
			$labels = array_merge($etablissmentObject->getArrayCopy(), $formationObject->getArrayCopy());

			$facets = self::getFacetsArray($labels);

			$url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&sort=-rentree_lib&rows=-1&facet=etablissement";
			$url = self::addApiKey($url);
			$url = self::createUrl_facets($facets, $url);
			$url = $url . "&facet=etablissement&refine.rentree_lib=2017-18&refine.etablissement=" . $_POST["etablissment"] . "&refine.diplom=" . $_POST["diplom"];
			self::fetchUrl($url, $contents);
		}

		public static function fetch_Specific_Etablissments(&$contents_2, $uaiArray) {
			$labels_2 = array(
				"uai" => "Identifiant",
				"coordonnees" => "Localisations",
				"url" => "Url du site",
				"uo_lib" => "Description de l'établissement"
			);

			$url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=-1";
			
			$url = self::addApiKey($url);
			
			$url = self::createUrl_facets($labels_2, $url);
			
			$url = self::createUrl_q($url, $uaiArray, "uai");
			
			self::fetchUrl($url, $contents_2);
		}

		public static function fetch_Specific_Etablissment_More_Data(&$etablissment, &$contents) {
			$etablissment = array(
				"La localisation" => array(
					"pays_etranger_acheminement" => "Pays",
					"reg_nom" => "Région",
	            	"dep_nom" => "Département",
	            	"com_nom" => "Commune",
					"adresse_uai" => "Adresse",
					"aca_nom" => "Académie",
					"coordonnees" => "Géolocalisation"
				),

				"Informations complémentaires" => array(
					"numero_telephone_uai" => "Numéro de téléphone",
					"url" => "Lien du site officiel",
					"element_wikidata" => "Lien wikipédia"
				)
	        );

			$facets = self::getFacetsArray($etablissment);

			$url = "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=-1";
			$url = self::addApiKey($url);
			$url = self::createUrl_facets($facets, $url);
			$url = $url . "&q=" . $_POST["etablissment"];
			self::fetchUrl($url, $contents);
		}
	}
?>