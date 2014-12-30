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
 }