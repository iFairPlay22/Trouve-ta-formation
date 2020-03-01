<?php
	/**
	* 
	*/
	class EtablissementDescription
	{

		private $_printTitle = true;
		
		function __construct()
		{
			
		}

		private function formatValue($value) {
			if (is_string($value) && 0 < strlen($value)) {
				$value = strtolower($value);
				$value[0] = strtoupper($value[0]);
			}
			return $value;
		}

		private function printTitle($name) {
			if ($this->_printTitle) {
				print("<h1>" . $name . "</h1>");
				$this->_printTitle = false;
			}
		}

		private function printEtablissment($etablissmentCategory, $contents) {
			
			foreach ($contents as $content) {

				foreach ($etablissmentCategory as $categoryName => $categoryData) {
					
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
								print("<p>" . $label . ": " . $this->formatValue($value["fields"][$attribute]) . "</p>");
							}
						}
					}
					
					print("</article><article class=\"category-description\">");
				}

			}

		}

		private function printFormations($formationCategory, $contents) {

			print("<section>");

			foreach ($contents as $content) {

				foreach ($content["records"] as $value) {

					print("<article class=\"category-description\">");

					foreach ($formationCategory as $categoryName => $categoryData) {

						$this->_printTitle = true;
		
						foreach ($categoryData as $attribute => $label) {
								
							if (isset($value["fields"][$attribute])) {
								if ($attribute !== "coordonnees") {
									$this->printTitle($categoryName);
									print("<p>" . $label . ": " . $this->formatValue($value["fields"][$attribute]) . "</p>");
								}
							}
						}

					}

					print("</article>");

				}

			}

			print("</section>");
			
		}

	     public function print() {
			$databaseActions = new DatabaseActions();
			$clics = $databaseActions->addClick($_POST["etablissment"]);

			Url::fetch_Specific_Formations_Etablissment_More_Data($etablissment, $formation, $contents);
			Url::fetch_Specific_Etablissment_More_Data($etablissment_2, $contents_2);

			$etablissments = array_merge($etablissment, $etablissment_2);
			$contents = array($contents, $contents_2);

			print("<article><h1 style=\"text-align: center;\"> Fiche établissement </h1></article><section><article class=\"category-description\">");
			$this->printEtablissment($etablissments, $contents);
			print("</article></section>");

			print("<article><h1 style=\"text-align: center;\">Cette page a été consultée $clics fois !</h1></article>");
			
			print("<article><h1 style=\"text-align: center;\">Fiche de formation </h1></article>");
			$this->printFormations($formation, $contents);

			Map::setLocalisations(
				array(
					array(
						"x" => $contents_2["records"][0]["fields"]["coordonnees"][0],
						"y" => $contents_2["records"][0]["fields"]["coordonnees"][1],
						"number" => 1,
						"uo_lib" => $contents_2["records"][0]["fields"]["uo_lib"],
						"url" => $contents_2["records"][0]["fields"]["url"]
						)
					)
				);
	     }
	}
?>