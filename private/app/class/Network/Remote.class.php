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
    (int) $cpuCount = $this->ssh->exec('sysctl hw.ncpu | cut -c 10-11');
    for($i = 0; $i <= $cpuCount; $i++) {
      $cpuUsage += $this->ssh->exec("sysctl dev.cpu.{$i}.cx_usage | cut -c 21-26");
    }
    return $cpuUsage / $cpuCount . '%';
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
	
	public function getAccountsNumber() {
		return $this->ssh->exec("mysql -u root -e 'SELECT COUNT(*) FROM account.account;'");
	}
}
