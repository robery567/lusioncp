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
		return $this->ssh->exec('uptime | cut -c 13-17');
	}

	public function ramMemory() {
		$kernel = $this->ssh->exec('uname -s');

		switch($kernel) {
			case 'Linux':
				$used = $this->ssh->exec('free | grep Mem | awk \'{print $3/$2 * 100.0}\'');
				$free = $this->ssh->exec('free | grep Mem | awk \'{print $4/$2 * 100.0}\'');
				$total = $this->ssh->exec('free | grep Mem | awk \'{print $1/1024.0*1024.0}\'');
				return $used . '/' . $free . ' din ' . $total . ' MB';
				break;
			case 'FreeBSD':
				$mem_hw 		= mem_rounded($this->ssh->exec('sysctl hw.physmem'));
				$mem_phys 		= $this->ssh->exec('sysctl hw.physmem');
				$mem_all 		= $this->ssh->exec('sysctl wm.stats.vm.v_page_count') 		* $this->ssh->exec('sysctl hw.pagesize');
				$mem_wire 		= $this->ssh->exec('sysctl wm.stats.vm.v_wire_count') 		* $this->ssh->exec('sysctl hw.pagesize');
				$mem_active 	= $this->ssh->exec('sysctl vm.stats.vm.v_active_count') 	* $this->ssh->exec('sysctl hw.pagesize');
				$mem_inactive 	= $this->ssh->exec('sysctl vm.stats.vm.v_inactive_count') 	* $this->ssh->exec('sysctl hw.pagesize');
				$mem_cache 		= $this->ssh->exec('sysctl vm.stats.vm_v_cache_count') 		* $this->ssh->exec('sysctl hw.pagesize');
				$mem_free 		= $this->ssh->exec('sysctl vm.stats.vm_v_free_count') 		* $this->ssh->exec('sysctl hw.pagesize');

				$mem_gap_vm    = $mem_all - ($mem_wire + $mem_active + $mem_inactive + $mem_cache + $mem_free);
				$mem_gap_sys   = $mem_phys - $mem_all;
				$mem_gap_hw    = $mem_hw   - $mem_phys;

				$mem_total = $mem_hw;
				$mem_avail = $mem_inactive + $mem_cache + $mem_free;
				$mem_used  = $mem_total - $mem_avail;
				
				$free = ($mem_inactive + $mem_cache + $mem_free)/$mem_total*100.0;
				$used  = ($mem_total - $mem_avail)/$mem_total*100.0;
				$total = $mem_total/1024*1024;

				return $used . '/' . $free . ' din ' . $total . ' MB';
				break;
			default:
				break;
		}
	}

	public function cpuUsage() {
		
	}
 }