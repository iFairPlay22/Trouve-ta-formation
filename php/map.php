<?php
	/**
	* 
	*/
	class Map
	{

		private static $_localisations = array();
		
		function __construct()
		{
			
		}

		private static function add($new, $old) {
			$res = array(
				"x" => $new["coordonnees"][0],
				"y" => $new["coordonnees"][1],
				"number" => 0,
				"uo_lib" => $new["uo_lib"],
				"url" => $new["url"]
			);

			foreach ($old as $localisation) {
				if ($localisation["etablissement"] == $new["uai"]) {
					$res["number"]++;
				}   
			}
			
			return $res;
		}

		public static function addCoordinates($etablissments) {
	        Url::fetch_Specific_Etablissments($contents, $etablissments);

	        foreach ($contents["records"] as $localisation) {
				array_push(self::$_localisations, self::add($localisation["fields"], $etablissments));
			}

	     }

	     public static function addMapItems() {
      		foreach (self::$_localisations as $localisation) {
	        	print('L.marker([' . $localisation["x"] . ', ' . $localisation["y"] . ']).addTo(mymap).bindPopup("<center><a href=\"' . $localisation["url"] .'\" target=\"_blank\"></center>' . $localisation["uo_lib"] . " (" . $localisation["number"] . ')</a>").openPopup();');
	       }
	    }
	}
?>