<?php
    class Util
    {
        public static function formatValue($value) {
			if (is_string($value) && 0 < strlen($value)) {
				$value = strtolower($value);
				$value[0] = strtoupper($value[0]);
			}
			return $value;
		}
    }
    
?>