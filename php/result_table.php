<?php
	/**
	* 
	*/
	class ResultTable
	{
		private $_top3 = true;
		private $_labels = array();
		private $_contents = array();
		private $_etablissments = array();
		
		function __construct($top3)
		{
			$this->_top3 = $top3;
			if ($this->_top3) {
				URL::fetch_Top3_Etablissments($this->_labels, $this->_contents);
			} else {
				URL::fetch_All_Formations_Etablissments($this->_labels, $this->_contents, true);
			}
		}

		 private function printHeader() {
			
			print("<h1 style=\"text-align: center;\">" . ($this->_top3 ? "Les établissements les plus cliqués" : "Résultats de la recherche") . "</h1><center><table><tr>");
			  foreach ($this->_labels as $column => $label) {
				print("<th>" . $label . "</th>");
			  }
			  if (!$this->_top3) {
				print("<th>Fiche détaillée</th></tr>");
			  }
		   }

	     private function printLine($line, $header) {
	        print("<tr>");

	        foreach ($header as $key => $value) {
	           print("<td>" . Util::formatValue($line[$key]) . "</td>");
			}
			
			if (!$this->_top3) {
				print("<td>
							<form method=\"POST\">
								<input name=\"etablissment\" value=\"" . $line["etablissement"] . "\" type=\"hidden\">
								<input name=\"diplom\" value=\"" . $line["diplom"] . "\" type=\"hidden\">
								<input type=\"submit\" value=\"En savoir plus\" class=\"section-article-form-article-inputbutton\">
							</form>
						</td>");
			}

	        print("</tr>");
	     }
		 
		private function printContents() {
	        
	        foreach ($this->_contents["records"] as $key => $value) {
			   self::printLine($value["fields"], $this->_labels);        
			   if (!$this->_top3) {
					array_push($this->_etablissments, array(
						"etablissement" => $value["fields"]["etablissement"]
					));
			   } else {
				   Map::addLocalisation($value["fields"]["coordonnees"], 1, $value["fields"]["uo_lib"], $value["fields"]["url"]);
			   }      
			}
			
	        print("</table></center>");
		}

		private function printMessage() {
			print("<article>");

			$all = $this->_contents["nhits"];
			$results = ButtonBar::$_limit < $all ? ButtonBar::$_limit : $all;

			if (!$this->_top3) {
				$buttonBar = New ButtonBar();
				$buttonBar->print(isset($_POST["begin"]) ? 0 < $_POST["begin"] : false, $all !== 0);
			}

			if ($all <= 0) {
	            print('<p style="text-align: center;">Aucun résultat ne correspond à vos critères de tri.</p>');
	        } else {
	            print('<p style="text-align: center;">'. min(array(ButtonBar::$_limit, $all)) . " / " . $all . " résultats affichés </p>");
				if (!$this->_top3) {
					Map::addCoordinates($this->_etablissments);
				}
			}

			print("</article>");
		}

		public function print() {
			self::printHeader();
			self::printContents();
	        self::printMessage();
     	}
	}
?>