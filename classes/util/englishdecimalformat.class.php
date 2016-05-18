<?php


class EnglishDecimalFormat {

  var $majorNames = array(
    "",
    " thousand",
    " million",
    " billion",
    " trillion",
    " quadrillion",
    " quintillion"
    );

  var $tensNames = array(
    "",
    " ten",
    " twenty",
    " thirty",
    " fourty",
    " fifty",
    " sixty",
    " seventy",
    " eighty",
    " ninety"
    );

  var $numNames = array(
    "",
    " one",
    " two",
    " three",
    " four",
    " five",
    " six",
    " seven",
    " eight",
    " nine",
    " ten",
    " eleven",
    " twelve",
    " thirteen",
    " fourteen",
    " fifteen",
    " sixteen",
    " seventeen",
    " eighteen",
    " nineteen"
    );
	
	
	function convertLessThanOneThousand($number_) {
    $soFar = "";

    if (($number_ % 100) < 20){
        $soFar = $this->numNames[$number_ % 100];
        $number_ /= 100;
    }
    else {
        $soFar = $this->numNames[$number_ % 10];
        $number_ /= 10;

        $soFar = $this->tensNames[$number_ % 10] . $soFar;
        $number_ /= 10;
     }
    if ($number_ == 0) return $soFar;
    
    return $this->numNames[$number_] . " hundred" . $soFar;
	}

	function Convert($number = 0) {

			/* special case */
	    if ($number == 0) { return "zero"; }
	
			$prefix = "";
	
	    if ($number < 0) {
	        $number = -$number;
	        $prefix = "negative";
      }
	
	    $soFar = "";
	    $place = 0;
	
	    do {
	      $n = $number % 1000;
	      if ($n != 0){
	         $s = $this->convertLessThanOneThousand($n);
	         $soFar = $s . $this->majorNames[$place] . $soFar;
        }
	      $place++;
	      $number /= 1000;
      } while ($number > 0);
      
      $freturn = trim($prefix . $soFar);
      $arrFR = explode(" ",$freturn);
      if (count($arrFR)>0) {
      	if (trim($arrFR[0]) == 'hundred' ) {
      		$arrFR = array_slice($arrFR,1);
      	}
      	$freturn = implode(" ",$arrFR);
      }
	
	    return  $freturn;
	}

}

?>