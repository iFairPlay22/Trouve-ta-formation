<?php
	/**
	* 
	*/
	class Map
	{
		
		function __construct()
		{
			
		}

		public static function addCoordinates(&$localisations) {
	        Url::fetchUrl_2($contents_2, $localisations);

	        $result = array();

	        foreach ($contents_2["records"] as $localisation) {

	          $res = array(
	              "x" => $localisation["fields"]["coordonnees"][0],
	              "y" => $localisation["fields"]["coordonnees"][1],
	              "etablissement_lib" => $localisation["fields"]["uo_lib"],
	              "url" => $localisation["fields"]["url"],
	              "nbResults" => 1
	            );
	            
	            array_push($result, $res);
	        }

	        return $result;

	     }

	     public static function addMapItems($localisations) {
      		foreach ($localisations as $localisation) {
	        	print('L.marker([' . $localisation["x"] . ', ' . $localisation["y"] . ']).addTo(mymap).bindPopup("<center><a href=\"' . $localisation["url"] . '\"</center>' . $localisation["etablissement_lib"] . '</a>").openPopup();');
	       }
	    }
	}
?>