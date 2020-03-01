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
			$number = 0;

			foreach ($old as $localisation) {
				if ($localisation["etablissement"] == $new["uai"]) {
					$number++;
				}   
			}
			
			self::addLocalisation($new["coordonnees"], $number, $new["uo_lib"], $new["url"]);
		}

		public static function addCoordinates($etablissments) {
	        Url::fetch_Specific_Etablissments($contents, $etablissments);

	        foreach ($contents["records"] as $localisation) {
				self::add($localisation["fields"], $etablissments);
			}

	     }

	     public static function addMapItems() {
      		foreach (self::$_localisations as $localisation) {
	        	print('L.marker([' . $localisation["x"] . ', ' . $localisation["y"] . ']).addTo(mymap).bindPopup("<center><a href=\"' . $localisation["url"] .'\" target=\"_blank\"></center>' . $localisation["uo_lib"] . " (" . $localisation["number"] . ')</a>").openPopup();');
	       }
		}
		
		public static function addLocalisation($coords, $number, $uoLib, $url) {
			array_push(self::$_localisations, array(
				"x" => $coords[0],
				"y" => $coords[1],
				"number" => $number,
				"uo_lib" => $uoLib,
				"url" => $url
			));
		}
	}
?>