<?php
	$contents = file_get_contents("https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=-1&sort=-rentree_lib&facet=etablissement_lib&facet=niveau_lib&facet=diplome_lib&facet=gd_disciscipline_lib&facet=sect_disciplinaire_lib&facet=reg_etab_lib&facet=dep_ins_lib&facet=com_etab_lib");
	if($contents === false){
	    print("No content...");
	}

	$contents = json_decode($contents, true);

/*
	$list = array();
	foreach ($contents["records"] as $key => $value) {
		array_push($list, $value["fields"]["disciplines_selection"]);
	}

*/
?>
