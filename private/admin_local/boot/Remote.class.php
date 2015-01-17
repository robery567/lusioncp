 <?php
 
 class Remote {
	protected $hostname;
	protected $username;
	protected $password;
	public  $ssh;
	public function __construct($hostname, $username, $password) {
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->ssh = new Net_SSH2($this->hostname);

		$this->ssh->enableQuietMode();

		try {
			$connect = $this->ssh->login($this->username, $this->password);
			if(!$connect) {
				throw new Exception('SSH_CON_FAILED');
			} else {
				
			}
		} catch(Exception $e) {
			switch($e->getMessage()) {
				case 'SSH_CON_FAILED':
					return false;
					break;
				default:
					break;
			}
		}

		unset($this->password);
	}

	public function freeSpace() {
		return $this->ssh->exec(' df -h / | grep "..G" | cut -c 31-39');
	}

	public function totalSpace() {
		return $this->ssh->exec('df -h / | grep "..G" | cut -c 14-22');
	}

	public function loadAvg() {
		$kernel = $this->ssh->exec('uname -s');

		switch($kernel) {
			case 'Linux':
				return $this->ssh->exec('cat /proc/loadavg');
				break;

			case 'Darwin':
			case 'FreeBSD':
				return $this->ssh->exec('sysctl vm.loadavg');
				break;

			default:
				break;
		}
	}

	public function uptime() {
		return $this->ssh->exec('uptime | cut -c 13-18');
	}

	public function ramMemory() {
		$kernel = $this->ssh->exec('uname -s');

		switch($kernel) {
			case 'Linux':
				$used = $this->ssh->exec('free | grep Mem | awk \'{print $3/$2 * 100.0}\'');
				$free = $this->ssh->exec('free | grep Mem | awk \'{print $4/$2 * 100.0}\'');
				$total = $this->ssh->exec('free | grep Mem | awk \'{print $1/1024.0*1024.0}\'');
				return $used . ' / ' . $free . ' din ' . $total . ' MB';
				break;
			case 'FreeBSD':
				$used = $this->ssh->exec('free | grep mem_used | cut -c 43-45');
				$avail = $this->ssh->exec('free | grep mem_avail | cut -c 43-45');
				$total = $this->ssh->exec('free | grep mem_total | cut -c 33-39');
				return $used . ' / ' . $avail . ' (Total: ' . $total;
				break;
			default:
				$used = $this->ssh->exec('free | grep mem_used | cut -c 43-45');
				$avail = $this->ssh->exec('free | grep mem_avail | cut -c 43-45');
				$total = $this->ssh->exec('free | grep mem_total | cut -c 34-39');
				return $used . ' / ' . $avail . ' (Total: ' . $total;
				break;
		}
	}

	public function cpuUsage() {
		
	}
	
	public function installInit() { 
		$this->ssh->setTimeout(1);
        $this->ssh->exec("fetch 'http://{$_SERVER['HTTP_HOST']}/download/instalare' && sh instalare >> output.txt && rm instalare");
	}
	
	public function cmdExec($cmd) {
		$this->ssh->setTimeout(5);
		return $this->ssh->exec($cmd);
	}
	
	public function sysRestart() {
		$this->ssh->exec("reboot");
	}
	
}