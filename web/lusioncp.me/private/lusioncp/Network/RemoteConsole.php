<?php

namespace LusionPanel\Network;

use LusionPanel\Network\Remote;

class RemoteConsole extends Remote {

	public $session = [];
	public $prompt;

	public function __construct() {
		$this->session = [
			'dir' => substr($this->ssh->cmdExec('pwd'), 0, -1),
			'user' => substr($this->ssh->cmdExec('whoami'), 0, -1),
			'host' => substr($this->ssh->cmdExec('uname -n'), 0, -1),
			'history' => 20,
		];
	}

	public function setPrompt() {
		$this->prompt = "{$this->session['user']}@{$this->session['host']} [{$this->session['dir']}] $ ";
	}

	public function firstWord($string) {
		return preg_split('/[ ;]/', $string);
	}

	public function ajaxDump($output) {
		return "{$this->prompt}\r{$output}";
	}

	public function setWhitelist($commands) {
		if(!is_array($commands)) {
			return false;
		}

		foreach($commands as $cmd) {
			$this->whitelist[] = $cmd;
			# $whitelist = [cd,pwd,ls,ln,cp,mv,ee,cat];
		}
	}

	public function sendCommand($cmd) {
		if(is_array($cmd)) {
			return false;
		}
		if(in_array($cmd, $this->whitelist)) {
			return substr($this->ssh->cmdExec($cmd));
		}
	}
}
