<?php
//namespace LusionCP\Network;

class Remote {

	protected $_hostname;
	protected $_username;
	protected $_password;

	public  $ssh;

	public function __construct($hostname, $username, $password) {
		$this->_hostname = $hostname;
		$this->_username = $username;
		$this->_password = $password;
		$this->ssh = new Net_SSH2($this->_hostname);
		$this->ssh->enableQuietMode();

		if(ping($this->_hostname)) {
			 $this->ssh->login($this->_username, $this->_password);
		}
		unset($this->_password);
	}

	public function cmdExec($cmd) {
		$this->ssh->setTimeout(5);
		return $this->ssh->exec($cmd);
	}

	public function freeSpace() {
		return $this->ssh->exec('df -h / | grep "..G" | cut -c 30-39');
	}

	public function totalSpace() {
		return $this->ssh->exec('df -h / | grep "..G" | cut -c 14-22');
	}

	public function loadAvg() {
		return $this->ssh->exec("uptime | awk -F 'load averages:' '{ print $2 }'");
	}

	public function uptime() {
		return $this->ssh->exec('uptime | cut -c 12-17');
	}

	public function ramMemory() {
		$used = $this->ssh->exec('free | grep mem_used | cut -c 42-45');
		$avail = $this->ssh->exec('free | grep mem_avail | cut -c 42-45');
		$total = $this->ssh->exec('free | grep mem_total | cut -c 32-38');
		return $used . ' / ' . $avail . ' (Total: ' . $total . ')';
	}

	public function cpuUsage() {
    $cpus = $this->ssh->exec('sysctl hw.ncpu');
    for($i = 1; $i <= $cpus; $i++) {
      $cpu += $this->ssh->exec("sysctl dev.cpu.{$i}.cx_usage");
    }
    return $cpu / $cpus;
	}

	public function installInit() {
		$this->ssh->setTimeout(1);
		$this->ssh->exec("fetch 'http://{$_SERVER['HTTP_HOST']}/download/install' && sh install >> output.txt && rm install");
	}

	public function sysRestart() {
		$this->ssh->exec('shutdown -r now "Maintenance reboot issued by LusionCP."');
	}

	public function getKernel() {
			return $this->ssh->exec('uname -s');
	}
}
