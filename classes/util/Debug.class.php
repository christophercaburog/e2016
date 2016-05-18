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
 * $Revision: 2184 $
 * $Id: Debug.class.php 2184 2008-10-06 17:11:10Z ipso $
 * $Date: 2008-10-06 10:11:10 -0700 (Mon, 06 Oct 2008) $
 */

/**
 * @package Core
 */
class Debug {
	static protected $enable = TRUE; 			//Enable/Disable debug printing.
	static protected $verbosity = 5; 			//Display debug info with a verbosity level equal or lesser then this.
	static protected $buffer_output = TRUE; 	//Enable/Disable output buffering.
	static protected $debug_buffer = NULL; 		//Output buffer.
	static protected $enable_tidy = FALSE; 		//Enable/Disable tidying of output
	static protected $enable_display = TRUE;	//Enable/Disable displaying of debug output
	static protected $enable_log = TRUE; 		//Enable/Disable logging of debug output
	static $tidy_obj = NULL;

	function setEnable($bool) {
		self::$enable = $bool;
	}

	function getEnable() {
		return self::$enable;
	}

	function setBufferOutput($bool) {
		self::$buffer_output = $bool;
	}

	function setVerbosity($level) {
		global $db;

		self::$verbosity = $level;

		if (is_object($db) AND $level == 11) {
			$db->debug=TRUE;
		}
	}
	function getVerbosity() {
		return self::$verbosity;
	}

	function setEnableTidy($bool) {
		self::$enable_tidy = $bool;
	}

	function getEnableTidy() {
		return self::$enable_tidy;
	}

	function setEnableDisplay($bool) {
		self::$enable_display = $bool;
	}

	function getEnableDisplay() {
		return self::$enable_display;
	}

	function setEnableLog($bool) {
		self::$enable_log = $bool;
	}

	function getEnableLog() {
		return self::$enable_log;
	}

	static function Text($text = NULL, $file = __FILE__, $line = __LINE__, $method = __METHOD__, $verbosity = 9) {
		if ( $verbosity > self::getVerbosity() OR self::$enable == FALSE ) {
			return FALSE;
		}

		if ( empty($method) ) {
			$method = "[Function]";
		}

		$text = 'DEBUG ['. $line .']:'. "\t" .'<b>'. $method .'()</b>: '. $text ."<br>\n";

		if ( self::$buffer_output == TRUE ) {
			self::$debug_buffer[] = array($verbosity, $text);
		} else {
			if ( self::$enable_display == TRUE ) {
				echo $text;
			} elseif ( OPERATING_SYSTEM != 'WIN' AND self::$enable_log == TRUE ) {
				syslog(LOG_WARNING, $text );
			}
		}

		return true;
	}

	static function Arr($array, $text = NULL, $file = __FILE__, $line = __LINE__, $method = __METHOD__, $verbosity = 9) {
		if ( $verbosity > self::getVerbosity() OR self::$enable == FALSE ) {
			return FALSE;
		}

		if ( empty($method) ) {
			$method = "[Function]";
		}

		ob_start();
		//var_dump($array);
		print_r($array);
		$ob_contents = ob_get_contents();
		ob_end_clean();

		$output = 'DEBUG ['. $line .'] Array: <b>'. $method .'()</b>: '. $text ."\n";
		$output .= "<pre>\n". $ob_contents ."</pre><br>\n";

		if (self::$buffer_output == TRUE) {
			self::$debug_buffer[] = array($verbosity, $output);
		} else {
			if ( self::$enable_display == TRUE ) {
				echo $output;
			} elseif ( OPERATING_SYSTEM != 'WIN' AND self::$enable_log == TRUE ) {
				syslog(LOG_WARNING, $text );
			}
		}

		return TRUE;
	}

	static function getOutput() {
		$output = NULL;
		if ( count(self::$debug_buffer) > 0 ) {
			foreach (self::$debug_buffer as $arr) {
				$verbosity = $arr[0];
				$text = $arr[1];

				//if ($verbosity <= self::getVerbosity() ) {
					$output .= $text;
				//}
			}

			return $output;
		}

		return FALSE;
	}

	static function emailLog() {
		if ( PRODUCTION === TRUE ) {
			$output = self::getOutput();

			if (strlen($output) > 0) {
				if ( isset($_SERVER['SERVER_NAME']) ) {
					$server_domain = $_SERVER['SERVER_NAME'];
				} else {
					$server_domain = 'localhost';
				}

				mail('root@'.$server_domain,'TimeTrex - Error!', $output, "From: timetrex@".$server_domain."\n");
			}
		}
		return TRUE;
	}

	static function writeToLog() {
      
		if (self::$enable_log == TRUE AND self::$buffer_output == TRUE) {

            
			$date_format = 'D M j G:i:s T Y';
			$file_name = dirname(__FILE__). DIRECTORY_SEPARATOR .'../../logs/hris.log';

			$eol = "\n";
			if ( is_writable( dirname(__FILE__). DIRECTORY_SEPARATOR .'../../logs/' ) ) {
              
				$output = '---------------[ '. Date('r') .' (PID: '.getmypid().') ]---------------'.$eol;
				if ( is_array(self::$debug_buffer) ) {
					foreach (self::$debug_buffer as $arr) {

						$verbosity = $arr[0];
						$text = $arr[1];

						if ($verbosity <= self::getVerbosity() ) {
							$output .= $text;
						}
					}
				}
				$output .= '---------------[ '. Date('r') .' (PID: '.getmypid().') ]---------------'.$eol;

				$fp = @fopen( $file_name,'a' );
				@fwrite($fp, $output);
				@fclose($fp);
				unset($output);
			}
		}

		return FALSE;
	}

	static function Display() {
		//if (self::$enable == TRUE AND self::$buffer_output == TRUE) {
		if (self::$enable_display == TRUE AND self::$buffer_output == TRUE) {

			$output = self::getOutput();

			if ( function_exists('memory_get_usage') ) {
				$memory_usage = memory_get_usage();
			} else {
				$memory_usage = "N/A";
			}

			if (strlen($output) > 0) {
				echo "<br>\n<b>Debug Buffer</b><br>\n";
				echo "============================================================================<br>\n";
				echo "Memory Usage: ". $memory_usage ."<br>\n";
				echo "----------------------------------------------------------------------------<br>\n";
				echo $output;
				echo "============================================================================<br>\n";
			}

		}
	}

	static function Tidy() {
		if (self::$enable_tidy == TRUE ) {

			$tidy_config = Environment::getBasePath() .'/includes/tidy.conf';

			self::$tidy_obj = tidy_parse_string( ob_get_contents(), $tidy_config );

			//erase the output buffer
			ob_clean();

			//tidy_clean_repair();
			self::$tidy_obj->cleanRepair();

			echo self::$tidy_obj;

		}
		return TRUE;
    }

	static function DisplayTidyErrors() {
		if ( self::$enable_tidy == TRUE
				AND ( tidy_error_count(self::$tidy_obj) > 0 OR tidy_warning_count(self::$tidy_obj) > 0 ) ) {
			echo "<br>\n<b>Tidy Output</b><br><pre>\n";
			echo "============================================================================<br>\n";
			echo htmlentities( self::$tidy_obj->errorBuffer );
			echo "============================================================================<br></pre>\n";
		}
	}

	static function clearBuffer() {
		self::$debug_buffer = NULL;
		return TRUE;
	}
}
?>