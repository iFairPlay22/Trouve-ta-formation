<?php

	function fetchUrl($url, &$contents) {
		$contents = file_get_contents($url);
	
		if($contents === false) {
			print("API connection failed...");
			exit(1);
		}

		$contents = json_decode($contents, true);
	}

	function createUrl_facets($labels, $url) {

		foreach ($labels as $key => $value) {
			$url .= "&facet=" . $key;
		}

		return $url;
	}

	function createUrl_q($url, $uaiArray) {
		
		$length = count($uaiArray);
		$url .= "q=uai=";

		for ($i=0; $i < $length; $i++) { 
			if ($i === $length - 1) {
				$url .= $uaiArray[$i]["com_ins"]; 
			} else {
				$url .= $uaiArray[$i]["com_ins"] . " OR uai="; 
			}
		}

		return $url;
	}

	function fetchUrl_1(&$labels, &$contents) {
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

		/*
			ewen.bouquet@free.fr
			trouvetaformation0
		*/
		fetchUrl(createUrl_facets($labels, "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=500&sort=-rentree_lib&facet=etablissement&facet=etablissement"), $contents);
	}

	function fetchUrl_2(&$contents_2, $uaiArray) {
		$labels_2 = array(
			"uai",
			"coordonnees",
			"url",
			"uo_lib"
		);

		//q=uai=... OR uai=... OR uai=...

		$url = createUrl_facets($labels_2, "https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur");

		$url = createUrl_q($url, $uaiArray);

		fetchUrl($url, $contents_2);
	}

	$default = "Pas de spécifications";

	$limit = 6;

?>