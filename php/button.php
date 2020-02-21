<?php
	/**
	* 
	*/
	class Button
	{
		
		function __construct()
		{
			
		}

		public static function printBeforeButton($limit) {
	        print('<form method="POST">');
	        foreach ($_POST as $key => $value) {
	           if ($key === "begin" || $key === "end") {
	              print('<input name="' . $key . '" value="' . ((integer) $value - $limit) . '" type="hidden"/>');
	           } else {
	              print('<input name="' . $key . '" value="' . $value . '" type="hidden"/>');
	           }
	        }
	        print('<input type="submit" value="Précédent" class="section-article-form-article-inputbutton"/></form>');
	     }

	     public static function printAfterButton($limit) {
	        print('<form method="POST">');
	        foreach ($_POST as $key => $value) {
	           if ($key === "begin" || $key === "end") {
	              print('<input name="' . $key . '" value="' . ((integer) $value + $limit) . '" type="hidden"/>');
	           } else {
	              print('<input name="' . $key . '" value="' . $value . '" type="hidden"/>');
	           }
	        }
	        print('<input type="submit" value="Suivant" class="section-article-form-article-inputbutton"/></form>');
	     }
	}
?>