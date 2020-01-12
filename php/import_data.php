<?php
	$contents = file_get_contents("https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=-1&sort=-rentree_lib&facet=etablissement_lib&facet=niveau_lib&facet=diplome_lib&facet=gd_disciscipline_lib&facet=sect_disciplinaire_lib&facet=reg_etab_lib&facet=dep_ins_lib&facet=com_etab_lib&facet=com_ins");//&facet=com_ins
	
	if($contents === false) {
		print("No content...");
	}

	$contents = json_decode($contents, true);
	
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
	
	$default = "Pas de spécifications";

	$limit = 6;

/*
	$list = array();
	foreach ($contents["records"] as $key => $value) {
		array_push($list, $value["fields"]["disciplines_selection"]);
	}
*/
?>