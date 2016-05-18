<?php
/*********************************************************************************
 * The contents of this file are subject to the TimeTrex Public License Version
 * 1.1.0 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.TimeTrex.com/TPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by TimeTrex" logo and
 *    (ii) the TimeTrex copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * The Original Code is: TimeTrex Open Source
 * The Initial Developer of the Original Code is TimeTrex Payroll Services
 * Portions created by TimeTrex are Copyright (C) 2004-2007 TimeTrex Payroll Services;
 * All Rights Reserved.
 *
 ********************************************************************************/
/*
 * $Revision: 2158 $
 * $Id: Option.class.php 2158 2008-09-15 23:26:15Z ipso $
 * $Date: 2008-09-15 16:26:15 -0700 (Mon, 15 Sep 2008) $
 */

/**
 * @package Core
 */
class Option {
	static function getByKey($key, $options, $false = FALSE ) {
		if ( isset($options[$key]) ){
			//Debug::text('Returning Value: '. $options[$key] , __FILE__, __LINE__, __METHOD__, 9);

			return $options[$key];
		}

		return $false;
		//return FALSE;
	}

	static function getByValue($value, $options, $value_is_translated = TRUE ) {
		// I18n: Calling gettext on the value here enables a match with the translated value in the relevant factory.
		//       BUT... such string comparisons are messy and we really should be using getByKey for most everything.
		//		 Exceptions can be made by passing false for $value_is_translated.
		if ( $value_is_translated == TRUE ) {
			$value = $value ;
		}
		if ( is_array( $value ) ) {
			return FALSE;
		}

		if ( !is_array( $options ) ) {
			return FALSE;
		}

		$flipped_options = array_flip($options);

		if ( isset($flipped_options[$value]) ){
			//Debug::text('Returning Key: '. $flipped_options[$value] , __FILE__, __LINE__, __METHOD__, 9);

			return $flipped_options[$value];
		}

		return FALSE;
	}

	//Takes $needles as an array, loops through them returning matching
	//keys => value pairs from haystack
	//Useful for filtering results to a select box, like status.
	static function getByArray($needles, $haystack) {

		if (!is_array($needles) ) {
			$needles = array($needles);
		}

		$needles = array_unique($needles);

		foreach($needles as $needle) {
			if ( isset($haystack[$needle]) ) {
				$retval[$needle] = $haystack[$needle];
			}
		}

		if ( isset($retval) ) {
			return $retval;
		}

		return FALSE;
	}

	static function getArrayByBitMask( $bitmask, $options ) {
		$bitmask = (int)$bitmask;

		if ( is_numeric($bitmask) AND is_array($options) ) {
			foreach( $options as $key => $value ) {
				//Debug::Text('Checking Bitmask: '. $bitmask .' mod '. $key .' != 0', __FILE__, __LINE__, __METHOD__,10);
				if ( ($bitmask & (int)$key) !== 0 ) {
					//Debug::Text('Found Bit: '. $key, __FILE__, __LINE__, __METHOD__,10);
					$retarr[] = $key;
				}
			}
		}

		if ( isset($retarr) ) {
			return $retarr;
		}

		return FALSE;
	}

	static function getBitMaskByArray( $keys, $options ) {
		$retval = 0;
		if ( is_array($keys) AND is_array($options) ) {
			/*
			for ($i = 1 ; $i < 16 ; ++$i) {
				 echo "2 ^ $i = ".pow(2,$i)."n";
			}
			*/
			foreach( $keys as $key ) {
				if ( isset($options[$key]) ) {
					$retval |= $key;
				} else {
					Debug::Text('Key is not a valid bitmask int: '. $key, __FILE__, __LINE__, __METHOD__,10);
				}
			}
		}

		return $retval;
	}
}
?>
