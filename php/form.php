<?php
	/**
	* 
	*/
	class Form
	{
		
		function __construct()
		{
			
		}

		private static function printOptions($contents, $item) {
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

		private static function printFormArticle($contents, $column, $label) {
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
		 
		 public static function printForm($labels, $contents) {
			foreach ($labels as $column => $label) {
				self::printFormArticle($contents, $column, $label);
			 }
		 }

	}
?>