<?php
	/**
	* 
	*/
	class ButtonBar
	{

		public static $_limit = 6;
		
		function __construct()
		{
			
		}

		private static function printBeforeButton() {
			$begin = false;
	        print('<form method="POST">');
	        foreach ($_POST as $key => $value) {
	           if ($key === "begin") {
	              print('<input name="' . $key . '" value="' . min(array($value - self::$_limit, 0)) . '" type="hidden"/>');
				  $begin = true;
	           } else {
	              print('<input name="' . $key . '" value="' . $value . '" type="hidden"/>');
	           }
			}
			if (!$begin) {
				print('<input name="begin" value="' . self::$_limit . '" type="hidden"/>');
			}
	        print('<input type="submit" value="Précédent" class="section-article-form-article-inputbutton"/></form>');
	     }

	     private static function printAfterButton() {
			$begin = false;
	        print('<form method="POST">');
	        foreach ($_POST as $key => $value) {
	           if ($key === "begin") {
				  print('<input name="' . $key . '" value="' . min(array($value + self::$_limit, 0)) . '" type="hidden"/>');
				  $begin = true;
	           } else {
	              print('<input name="' . $key . '" value="' . $value . '" type="hidden"/>');
	           }
			}
			if (!$begin) {
				print('<input name="begin" value="' . self::$_limit . '" type="hidden"/>');
			}
	        print('<input type="submit" value="Suivant" class="section-article-form-article-inputbutton"/></form>');
	     }

		public static function print($printBefore, $printAfter) {
			if ($printBefore || $printAfter) {
	            print('<div style="display: flex; align-items: center; justify-content: center; margin-top: 15px;"><div style="display: flex; align-items: center; justify-content: space-around; width:30%;">');
	            if ($printBefore)
	                self::printBeforeButton();
	            if ($printAfter)
					self::printAfterButton();
	            print('</div></div>');
	        }  
		}
	}
?>