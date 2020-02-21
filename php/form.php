<?php
	/**
	* 
	*/
	class Form
	{
		
		function __construct()
		{
			
		}

		private static function printOptions($contents, $default, $item) {
	        $array = array();
	        foreach ($contents["records"] as $key => $value) {
	           array_push($array, $value["fields"][$item]);
	        }
	        $array = array_unique($array);
	        sort($array); 
	        foreach ($array as $value) {
	           print("<option value=\"" . $value ."\">" . $value ."</option>");
	        }
	        print("<option value=\"" . $default ."\">" . $default ."</option>");
	     }

		public static function printForm($contents, $default, $column, $label) {
	        print('<article class="section-article-form-article"><input list="' . $column . '" name="' . $column . '" placeholder="' . $label. '"');

	        if (isset($_POST["$column"])) {
	           if ($_POST["$column"] !== "") {
	              print(' value="' . $_POST["$column"] . '"');
	           }
	        }
	        
	        print('/><datalist id="' . $column . '">');

	        self::printOptions($contents, $default, $column);

	        print('</datalist></article>');
	     }

	}
?>