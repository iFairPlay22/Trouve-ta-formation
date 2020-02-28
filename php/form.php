<?php
	/**
	* 
	*/
	class Form
	{
		
		function __construct()
		{
			
		}

		private function printOptions($contents, $item) {
	        $array = array();
	        foreach ($contents["records"] as $key => $value) {
	           array_push($array, $value["fields"][$item]);
	        }
	        $array = array_unique($array);
	        sort($array); 
	        foreach ($array as $value) {
	           print("<option value=\"" . $value ."\">" . $value ."</option>");
	        }
	     }

		private function printArticle($contents, $column, $label) {
	        print('<article class="section-article-form-article"><input list="' . $column . '" name="' . $column . '" placeholder="' . $label. '"');

	        if (isset($_POST["$column"])) {
	           if ($_POST["$column"] !== "") {
	              print(' value="' . $_POST["$column"] . '"');
	           }
	        }
	        
	        print('/><datalist id="' . $column . '">');

	        self::printOptions($contents, $column);

	        print('</datalist></article>');
		 }
		 
		 public function print() {
			Url::fetch_All_Formations_Etablissments($labels, $contents, false);
			foreach ($labels as $column => $label) {
				self::printArticle($contents, $column, $label);
			}
		 }

	}
?>