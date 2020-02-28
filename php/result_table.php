<?php
	/**
	* 
	*/
	class ResultTable
	{
		
		function __construct()
		{
			
		}

		 private static function match($line) {
	        foreach ($_POST as $key => $value) {
	           if ($key == "end" || $key == "begin" || $value == "")
	              continue;
	           if ($line[$key] != $value) {
	              return false;
	           }
	        }
	        return true;
	     }

	     private static function printLine($line, $header) {
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

	    private static function printHeader($labels) {
	      print("<article><table><tr>");
	        foreach ($labels as $column => $label) {
	            print("<th>" . $label . "</th>");
	        }
	        print("<th>Fiche détaillée</th></tr>");
	     }

		public static function printResult($contents, $labels, $limit) {
			self::printHeader($labels);

	        $parameters = array(
	            "nbResults" => 0,
	            "hasBefore" => false,
	            "hasAfter" => false
	        );

	        $localisations = array();
	        
	        foreach ($contents["records"] as $key => $value) {
	           if (self::match($value["fields"])) {
	              if ($parameters["nbResults"] < $_POST["begin"]) {
	                $parameters["hasBefore"] = true;
	              }
	              if ($_POST["begin"] <= $parameters["nbResults"] && $parameters["nbResults"] < $_POST["end"]) {
	                self::printLine($value["fields"], $labels);
	                array_push($localisations, array(
	                  //"etablissement_lib" => $value["fields"]["etablissement_lib"], 
	                  "etablissement" => $value["fields"]["etablissement"]
	                ));
	              }
	              if ($_POST["end"] <= $parameters["nbResults"] && !($parameters["hasAfter"])) {
	                $parameters["hasAfter"] = true;
	              }
	              $parameters["nbResults"]++;
	           }                     
	        }
	        print("</table>");

	        if ($parameters["hasBefore"] || $parameters["hasAfter"]) {
	            print('<div style="display: flex; align-items: center; justify-content: center; margin-top: 15px;"><div style="display: flex; align-items: center; justify-content: space-around; width:30%;">');
	            if ($parameters["hasBefore"])
	                Button::printBeforeButton($limit);
	            if ($parameters["hasAfter"])
	                Button::printAfterButton($limit);
	            print('</div></div>');
	        }  

	        if ($parameters["nbResults"] <= 0) {
	            print('<p style="text-align: center;">Aucun résultat ne correspond à vos critères de tri.</p>');
	        } else {
	            $printElements = ($parameters["nbResults"] < intval($_POST["end"])) ? $parameters["nbResults"] : (intval(intval($_POST["end"])) - (intval($_POST["begin"])));
	            print('<p style="text-align: center;">'. $printElements . " / " . $parameters["nbResults"] . " résultats affichés </p>");

	            $localisations = Map::addCoordinates($localisations);
	        }

	        print("</article>");

	        return $localisations;
     }
	}
?>