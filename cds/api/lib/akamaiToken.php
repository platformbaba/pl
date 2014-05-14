<?php
date_default_timezone_set('Asia/Calcutta'); 
	$akamaiAutoTokenKeyPHLS  = 'E30BF20DE78BE5888DC43D7E9CEEADF7';	// Secure
	$akamaiAutoTokenKeyNPHLS = 'E5070362C839ED91E3D304F87C9EED15';  // non Secure
	function getAkamai_Auth_Token($key){
	
		$c = new Akamai_EdgeAuth_Config();
		$g = new Akamai_EdgeAuth_Generate();
		$c->set_key($key);
		
		$token = $g->generate_token($c);
		return $token;
	}
	
if( isset($_GET['getToken']) && $_GET['getToken'] == 'yes' ){
	echo $akamaiToken = getAkamai_Auth_Token($akamaiAutoTokenKey);
}

//E30BF20DE78BE5888DC43D7E9CEEADF7
/**
 * AkamaiToken.php - An Akamai EdgeAuth Token 2.0 implementation for PHP
 *
 * author: James Mutton <jmutton@akamai.com>
 *
 * Copyright (c) 2011, Akamai Technologies, Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Akamai Technologies nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL AKAMAI TECHNOLOGIES BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * AkamaiToken
 * Notes:
 */
//class Akamai_EdgeAuth_ParameterException extends Exception {
//}

/**
 * Class for handling the configuration of the token generator
 */
class Akamai_EdgeAuth_Config {
	protected $algo = "SHA256";
	protected $ip = '';
	protected $start_time = 0;
	protected $window = 6000;
	protected $acl = '';
	protected $url = '';
	protected $session_id = '';
	protected $data = '';
	protected $salt = '';
	protected $key = '';
	protected $field_delimiter = '~';
	protected $early_url_encoding = false;


	protected function encode($val) {
		if ($this->early_url_encoding === true) {
			return rawurlencode($val);
		}
		return $val;
	}

	public function set_algo($algo) {
		if (in_array($algo, array('sha256','sha1','md5'))) {
			$this->algo = $algo;
		} else {
			throw new Akamai_EdgeAuth_ParameterException("Invalid algorithme, must be one of 'sha256', 'sha1' or 'md5'");
		}
	}
	public function get_algo() {return $this->algo;}

	public function set_ip($ip) {
		// @TODO: Validate IPV4 & IPV6 addrs
		$this->ip = $ip;
	}
	public function get_ip() {return $this->ip;}
	public function get_ip_field() {
		if ( $this->ip != "" ) {
			return 'ip='.$this->ip.$this->field_delimiter;
		}
		return "";
	}

	public function set_start_time($start_time) {
		// verify starttime is sane
		if ( is_numeric($start_time) && $start_time > 0 && $start_time < 4294967295 ) {
			$this->start_time = 0+$start_time; // faster then intval
		} else {
			throw new Akamai_EdgeAuth_ParameterException("start time input invalid or out of range");
		}
	}
	public function get_start_time() {return $this->start_time;}
	protected function get_start_time_value() {
		if ( $this->start_time > 0 ) {
			return $this->start_time;
		} else {
			return time();
		}
	}
	public function get_start_time_field() {
		return 'st='.$this->get_start_time_value().$this->field_delimiter;
	}

	public function set_window($window) {
		// verify starttime is sane
		if ( is_numeric($window) && $window > 0 ) {
			$this->window = 0+$window; // faster then intval
		} else {
			throw new Akamai_EdgeAuth_ParameterException("window input invalid");
		}
	}
	public function get_window() {return $this->window;}
	public function get_expr_field() {
		return 'exp='.($this->get_start_time_value()+$this->window).$this->field_delimiter;
	}

	public function set_acl($acl) {
		if ($this->url != "") {
			throw new Akamai_EdgeAuth_ParameterException("Cannot set both an ACL and a URL at the same time");
		}
		$this->acl = $acl;
	}
	public function get_acl() {return $this->acl;}
	public function get_acl_field() {
		if ($this->acl) {
			return 'acl='.$this->encode($this->acl).$this->field_delimiter;
		} elseif (! $this->url) {
			//return a default open acl
			return 'acl='.$this->encode('/*').$this->field_delimiter;
		}
		return '';
	}

	public function set_url($url) {
		if ($this->acl) {
			throw new Akamai_EdgeAuth_ParameterException("Cannot set both an ACL and a URL at the same time");
		}
		$this->url = $url;
	}
	public function get_url() {return $this->url;}
	public function get_url_field() {
		if ($this->url && ! $this->acl) {
			return 'url='.$this->encode($this->url).$this->field_delimiter;
		}
		return '';
	}

	public function set_session_id($session_id) {$this->session_id = $session_id;}
	public function get_session_id() {return $this->session_id;}
	public function get_session_id_field() {
		if ($this->session_id) {
			return 'id='.$this->session_id.$this->field_delimiter;
		}
		return "";
	}

	public function set_data($data) {$this->data = $data;}
	public function get_data() {return $this->data;}
	public function get_data_field() {
		if ($this->data) {
			return 'data='.$this->data.$this->field_delimiter;
		}
		return "";
	}

	public function set_salt($salt) {$this->salt = $salt;}
	public function get_salt() {return $this->salt;}
	public function get_salt_field() {
		if ($this->salt) {
			return 'salt='.$this->salt.$this->field_delimiter;
		}
		return "";
	}

	public function set_key($key) {
		//verify the key is valid hex
		if (preg_match('/^[a-fA-F0-9]+$/',$key) && (strlen($key)%2) == 0) {
			$this->key = $key;
		} else {
			throw new Akamai_EdgeAuth_ParameterException("Key must be a hex string (a-f,0-9 and even number of chars)");
		}
	}
	public function get_key() {return $this->key;}

	public function set_field_delimiter($field_delimiter) {$this->field_delimiter = $field_delimiter;}
	public function get_field_delimiter() {return $this->field_delimiter;}

	public function set_early_url_encoding($early_url_encoding) {$this->early_url_encoding = $early_url_encoding;}
	public function get_early_url_encoding() {return $this->early_url_encoding;}
}

class Akamai_EdgeAuth_Generate {

	protected function h2b($str) {
    	$bin = "";
    	$i = 0;
    	do {
        	$bin .= chr(hexdec($str{$i}.$str{($i + 1)}));
        	$i += 2;
    	} while ($i < strlen($str));
    	return $bin;
	}

	public function generate_token($config) {
		// ASSUMES:($algo='sha256', $ip='', $start_time=null, $window=300, $acl=null, $acl_url="", $session_id="", $payload="", $salt="", $key="000000000000", $field_delimiter="~")
		$m_token = $config->get_ip_field();
		$m_token .= $config->get_start_time_field();
		$m_token .= $config->get_expr_field();
		$m_token .= $config->get_acl_field();
		$m_token .= $config->get_session_id_field();
		$m_token .= $config->get_data_field();
		$m_token_digest = (string)$m_token;
		$m_token_digest .= $config->get_url_field();
		$m_token_digest .= $config->get_salt_field();

		// produce the signature and append to the tokenized string
		$signature = hash_hmac($config->get_algo(), rtrim($m_token_digest, $config->get_field_delimiter()), $this->h2b($config->get_key()));
		return $m_token.'hmac='.$signature;
	}
}

//xecho "BN=". basename(__FILE__);
// CLI Parameter Control
if (!empty($argc) && strstr($argv[0], basename(__FILE__))) {
	// bring in getopt and define some exit codes
	require_once 'Console/Getopt.php';
	define('NO_ARGS',10);
	define('INVALID_OPTION',11);
	// parse args to opts
	$args = Console_Getopt::readPHPArgv(); 
	$long_opts = array( 'help', 'window=', 'start-time=', 'ip=', 'acl=', 'session-id=',
			'payload=', 'url=', 'salt=', 'field-delimiter=', 'acl-delimiter=', 'algo=',
			'key=', 'debug', 'escape-early',);
	$opts = Console_Getopt::getOpt($args, 'h', $long_opts);
	// Check the options are valid 
	if (PEAR::isError($opts)) { 
		fwrite(STDERR, $opts->getMessage()."\n");
		exit(INVALID_OPTION);
	}
	if (!empty($opts[0])) {
		$c = new Akamai_EdgeAuth_Config();
		$g = new Akamai_EdgeAuth_Generate();
		foreach ($opts[0] as $o) {
			if ($o[0] == '--help') {
				//@TODO
			} elseif ($o[0] == '--window') {
				$c->set_window($o[1]);
			} elseif ($o[0] == '--start-time') {
				$c->set_start_time($o[1]);
			} elseif ($o[0] == '--ip') {
				$c->set_ip($o[1]);
			} elseif ($o[0] == '--acl') {
				$c->set_acl($o[1]);
			} elseif ($o[0] == '--session-id') {
				$c->set_session_id($o[1]);
			} elseif ($o[0] == '--payload') {
				$c->set_data($o[1]);
			} elseif ($o[0] == '--url') {
				$c->set_url($o[1]);
			} elseif ($o[0] == '--salt') {
				$c->set_salt($o[1]);
			} elseif ($o[0] == '--field-delimiter') {
				$c->set_field_delimiter($o[1]);
			} elseif ($o[0] == '--acl-delimiter') {
				//@TODO
			} elseif ($o[0] == '--algo') {
				$c->set_algo($o[1]);
			} elseif ($o[0] == '--key') {
				$c->set_key($o[1]);
			} elseif ($o[0] == '--debug') {
				//@TODO
			} elseif ($o[0] == '--escape-early') {
				$c->set_early_url_encoding(true);
			}
		}
		$token = $g->generate_token($c);
		print "$token\n";
	}
	
	

}


?>
