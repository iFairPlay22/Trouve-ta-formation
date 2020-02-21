<?php
	/**
	* 
	*/
	class Map
	{
		
		function __construct()
		{
			
		}

		private static function add($localisations, $new, $old) {
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

		public static function addCoordinates($localisations) {
	        Url::fetchUrl_2($contents_2, $localisations);

	        $result = array();

	        foreach ($contents_2["records"] as $localisation) {
				array_push($result, self::add($result, $localisation["fields"], $localisations));
			}

	        return $result;

	     }

	     public static function addMapItems($localisations) {
      		foreach ($localisations as $localisation) {
	        	print('L.marker([' . $localisation["x"] . ', ' . $localisation["y"] . ']).addTo(mymap).bindPopup("<center><a href=\"' . $localisation["url"] .'\" target=\"_blank\"></center>' . $localisation["uo_lib"] . " (" . $localisation["number"] . ')</a>").openPopup();');
	       }
	    }
	}
?>