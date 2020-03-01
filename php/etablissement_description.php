<?php
	/**
	* 
	*/
	class EtablissementDescription
	{

		private $_printArticle = true;
		private $_printTitle = true;
		
		function __construct()
		{
			
		}

		private function printTitle($name) {
			if ($this->_printArticle) {
				print("<article class=\"category-description\">");
				$this->_printArticle = false;
			}
			
			if ($this->_printTitle) {
				print("<h1>" . $name . "</h1>");
				$this->_printTitle = false;
			}
		}

		private function printEtablissment($etablissmentCategory, $contents) {
			print("<article id=\"etablissment-data\"><h1> Fiche établissement </h1><section><article class=\"category-description\">");
			
			foreach ($contents as $content) {

				$length = count($etablissmentCategory) - 1;
				$i = 0;

				foreach ($etablissmentCategory as $categoryName => $categoryData) {
					
					$this->_printArticle = false;
					$this->_printTitle = true;
					
					foreach ($categoryData as $attribute => $label) {
						
						$value = $content["records"][0];
							
						if (isset($value["fields"][$attribute])) {
							if ($attribute == "url" || $attribute == "element_wikidata") {
								if (isset($value["fields"]["url"])) {
									if (isset($value["fields"]["element_wikidata"])) {
										$this->printTitle($categoryName);
										print("<p><a href=\"" . $value["fields"][$attribute] . "\" target=\"_blank\">" . $label . "</a></p>");
									}
								}
							} else if ($attribute !== "coordonnees") {
								$this->printTitle($categoryName);
								print("<p>" . $label . ": " . Util::formatValue($value["fields"][$attribute]) . "</p>");
							}
						}
					}

					if ($this->_printTitle === false && $i < $length) {
						print("</article><article class=\"category-description\">");
					}

					$i++;
				}

			}

			$databaseActions = new DatabaseActions();
			$clics = $databaseActions->addClick($_POST["etablissment"]);
			print("</article></section><h2 style=\"text-align: center;\">Cette page a été consultée $clics fois !</h2></article>");

		}

		private function printFormations($formationCategory, $contents) {

			print("<article id=\"formation-data\"><h1> Fiche formation </h1><section>");

			foreach ($contents as $content) {

				foreach ($content["records"] as $value) {

					$this->_printArticle = true;

					foreach ($formationCategory as $categoryName => $categoryData) {

						$this->_printTitle = true;
		
						foreach ($categoryData as $attribute => $label) {
								
							if (isset($value["fields"][$attribute])) {
								if ($attribute !== "coordonnees") {
									$this->printTitle($categoryName);
									print("<p>" . $label . ": " . Util::formatValue($value["fields"][$attribute]) . "</p>");
								}
							}
						}

					}

					if ($this->_printArticle === false) {
						print("</article>");
					}

				}

			}

			print("</section></article>");
			
		}

	     public function print() {
			Url::fetch_Specific_Formations_Etablissment_More_Data($etablissment, $formation, $contents);
			Url::fetch_Specific_Etablissment_More_Data($etablissment_2, $contents_2);

			$etablissments = array_merge($etablissment, $etablissment_2);
			$contents = array($contents, $contents_2);

			$this->printEtablissment($etablissments, $contents);
			$this->printFormations($formation, $contents);

			$value = $contents_2["records"][0]["fields"];
			Map::addLocalisation($value["coordonnees"], 1, $value["uo_lib"], $value["url"]);
	     }
	}
?>