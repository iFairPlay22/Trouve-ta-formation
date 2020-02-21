<?php
	/**
	* 
	*/
	class EtablissementDescription
	{
		
		function __construct()
		{
			
		}

	     public static function printResult($id) {
	     	Url::fetchUrl_1_id($categories, $contents, $id);

	     	print("<article>");

	     	foreach ($categories as $categoryName => $categoryData) {
	     		print("<h1>" . $categoryName . "</h1>");
	     		foreach ($categoryData as $attribute => $label) {

	     			if (substr($label, 0, 4) == "Lien") {
	     				print("<p><a href=\"" . $contents["records"][0]["fields"][$attribute] . "\" target=\"_blank\">" . $label . "</a></p>");
	     			} else {
	     				print("<p>" . $label . " => " . $contents["records"][0]["fields"][$attribute] . "</p>");
	     			}

		     	}
	     	}

	        print("</article>");
	     }
	}
?>