<?php

/**
 * Mailer class for sending emails. part of extensible framework.
 * 
 * @todo handling of attachments
 */

class Mailer {
	
	/**#@+
	 * Mailer member variables
	 */
	
	/**
	 * Recipient's name
	 */
	var $toName;
	
	/**
	 * Recipient's email address
	 */
	var $toAddr;
	
	/**
	 * Sender's name
	 */
	var $fromName;	
	
	/**
	 * Sender's email address
	 */
	var $fromAddr;
	
	/**
	 * Message subject
	 */
	var $subject;
	
	/**
	 * Message Body
	 */
	var $payload;
	
	/**
	 * Additional Headers
	 */
	var $headers;
	
	/**#@-*/
	
	
	var $data = array();
	
	function Mailer() {
		$this->headers = array();
	}
	
	/**
	 * Sets the message recipient
	 *
	 * @param string $addr Recipient's email address
	 * @param string $name Recipient's name
	 */
	function setTo( $addr, $name='' ) {
		$this->toAddr = $addr;
		if ( $name ) $this->toName = $name;
	}
	
	/**
	 * Sets the Sender's name and address
	 *
	 * @param string $addr Sender's address
	 * @param string $name Sender's name
	 */
	function setFrom( $addr, $name='' ) {
		$this->fromAddr = $addr;
		if ( $name ) $this->fromName = $name;
	}
	
	/**
	 * Sets the message subject
	 *
	 * @param string $subj Message subject
	 */
	function setSubject( $subj ) {
		$this->subject = $subj;	
	}
	
	/**
	 * Sets the message body
	 *
	 * @param string $content Message body
	 */
	function setPayload( $content ) {
		$this->payload = $content;	
	}
	
	/**
	 * Adds more mail headers
	 *
	 * @param string $name Header name
	 * @param string $value Header Value
	 */
	function addHeader( $name, $value ) {
		$this->headers[$name] = $value;	
	}
	
	/**
	 * Executs the mail sending code
	 *
	 * @return var mailer's result code  
	 */
	function send() {
		$lineTo = $this->toAddr;
		$lineSubject = $this->subject;

		$lineFrom = "From: ".$this->fromName." <".$this->fromAddr.">\r\n";

		$lineHeaders = $lineFrom;
		foreach ( $this->headers as $hname=>$hvalue ) {
			$lineHeaders .= "$hname: $hvalue\r\n";
		}

		return @mail( $lineTo, $lineSubject, $this->payload, $lineHeaders );
	}
	
}

?>