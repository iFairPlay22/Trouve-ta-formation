<?php
	/**
	* 
	*/
	class ResultTable
	{
		private $_labels = array();
		private $_contents = array();
		private $_etablissments = array();
		
		function __construct()
		{
			
		}

		 private function printHeader() {
			print("<table><tr>");
			  foreach ($this->_labels as $column => $label) {
				  print("<th>" . $label . "</th>");
			  }
			  print("<th>Fiche détaillée</th></tr>");
		   }

	     private function printLine($line, $header) {
	        print("<tr>");

	        foreach ($header as $key => $value) {
	           print("<td>" . $line[$key] . "</td>");
	        }

	        print("<td>
	        	<form method=\"POST\">
	        		<input name=\"id\" value=\"" . $line["etablissement"] . "\" type=\"hidden\">
	        		<input type=\"submit\" value=\"En savoir plus\" class=\"section-article-form-article-inputbutton\">
	        	</form>
	        	</td>");

	        print("</tr>");
	     }
		 
		private function printContents() {
	        
	        foreach ($this->_contents["records"] as $key => $value) {
	           self::printLine($value["fields"], $this->_labels);                   
			   array_push($this->_etablissments, array(
				"etablissement" => $value["fields"]["etablissement"]
			  ));
			}
			
	        print("</table>");
		}

		private function printMessage() {
			$all = $this->_contents["nhits"];
			$results = ButtonBar::$_limit < $all ? ButtonBar::$_limit : $all;

			$buttonBar = New ButtonBar();
			$buttonBar->print(isset($_POST["begin"]) ? 0 < $_POST["begin"] : false, $all !== 0);

			if ($all <= 0) {
	            print('<p style="text-align: center;">Aucun résultat ne correspond à vos critères de tri.</p>');
	        } else {
	            print('<p style="text-align: center;">'. min(array(ButtonBar::$_limit, $all)) . " / " . $all . " résultats affichés </p>");
	            Map::addCoordinates($this->_etablissments);
			}
		}

		public function print() {
			URL::fetch_All_Formations_Etablissments($this->_labels, $this->_contents, true);

			self::printHeader();
			self::printContents();

			print("<article>");

	        self::printMessage();

	        print("</article>");
     }
	}
?>