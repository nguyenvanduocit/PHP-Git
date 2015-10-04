<?php
namespace PHPGit;
use Symfony\Component\Process\Process;

/**
 * Class PHPGit
 *
 * Easy to use git in php
 *
 * @package PHPGit
 */
class PHPGit {
	/** @var string path to git bin*/
	protected static $binPath = null;
	/** @var string path to repo */
	protected $repoPath = null;
	/** @var ProcessBuilder Command builder*/
	protected $processBuilder = null;
	/** @var Process the last process */
	protected $lastProcess = null;

	/**
	 * Constructor
	 *
	 * @param      $repoPath
	 * @param null $binPath
	 */
	public function __construct( $repoPath, $binPath = null ){
		$this->repoPath = $repoPath;
		if(!$binPath){
			$binPath = $this->detectBinPath();
		}
		static::setBinPath($binPath);
		$this->processBuilder = new ProcessBuilder(static::$binPath, $this->repoPath);
	}

	/**
	 * @return string
	 */
	public function detectBinPath(){
		switch(PHP_OS){
			case 'DAR':
			case 'LINUX':
				return '/usr/local/git';
			case 'WIN':
			case 'WINNT':
				return 'git';
			default:
				throw new \InvalidArgumentException('Can not detect bin path');
		}
	}

	/**
	 * Excute a command
	 * @return Process
	 */
	public function exec(){
		$args = func_get_args();
		$this->lastProcess = $this->processBuilder->getProcess($args);
		$this->lastProcess->run();
		return $this->lastProcess;
	}
	public function exist(){
		return file_exists($this->repoPath.DIRECTORY_SEPARATOR.'.git');
	}
	/**
	 * get $binPath
	 *
	 * @return string
	 */
	public static function getBinPath() {
		return self::$binPath;
	}

	/**
	 * set $binPath
	 *
	 * @param string $binPath
	 */
	public static function setBinPath( $binPath ) {
		self::$binPath = $binPath;
	}

	/**
	 * get repoPath
	 *
	 * @return string
	 */
	public function getRepoPath() {
		return $this->repoPath;
	}

	/**
	 * set repoPath
	 *
	 * @param string $repoPath
	 */
	public function setRepoPath( $repoPath ) {
		$this->repoPath = $repoPath;
	}

	/**
	 * get processBuilder
	 *
	 * @return ProcessBuilder
	 */
	public function getProcessBuilder() {
		return $this->processBuilder;
	}

	/**
	 * Set processBuilder
	 *
	 * @param ProcessBuilder $processBuilder
	 */
	public function setProcessBuilder( $processBuilder ) {
		$this->processBuilder = $processBuilder;
	}

	/**
	 * @return Process
	 */
	public function getLastProcess() {
		return $this->lastProcess;
	}


}