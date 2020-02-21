<?php
	/**
	* 
	*/
	class EtablissementDescription
	{

		private $_index = 0;
		
		function __construct()
		{
			
		}

		private function printCategories($categories, $contents) {
			
			foreach ($categories as $categoryName => $categoryData) {

				print("<h1>" . $categoryName . "</h1>");
				foreach ($categoryData as $attribute => $label) {JsManager::console_log($contents["records"][0]["fields"]);
					
					if (isset($contents["records"][0]["fields"][$attribute])) {
						if ($attribute == "url" || $attribute == "element_wikidata") {
							print("<p><a href=\"" . $contents["records"][0]["fields"][$attribute] . "\" target=\"_blank\">" . $label . "</a></p>");
						} else if ($attribute !== "coordonnees") {
							print("<p>" . $label . ": " . $contents["records"][0]["fields"][$attribute] . "</p>");
						}
					}
				}

				if ($this->_index % 2 == 1 && $this->_index < 5) {
					print("</article><article>");
				}
				$this->_index++;
			}
		
		}

	     public function printResult($id) {
			Url::fetchUrl_1_id($categories, $contents, $id);
			Url::fetchUrl_2_id($categories_2, $contents_2, $id);

			print("<section><article>");
			$this->printCategories($categories, $contents);
			$this->printCategories($categories_2, $contents_2);
			print("</article></section>");

			return array(array(
				"x" => $contents_2["records"][0]["fields"]["coordonnees"][0],
				"y" => $contents_2["records"][0]["fields"]["coordonnees"][1],
				"number" => 1,
				"uo_lib" => $contents_2["records"][0]["fields"]["uo_lib"],
				"url" => $contents_2["records"][0]["fields"]["url"]
			));
	     }
	}
?>