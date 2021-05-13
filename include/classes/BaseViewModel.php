<?php
namespace BandSite;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class BaseViewModel {
	
	protected $pdo;
	protected $log;

	public function __construct() {
		$this->pdo = $this->getPdoConnection();
		$this->log = $this->setupLogger();
		$this->isLoggedIn();
		$this->getUsername();
		

	}

	public function isLoggedIn(): bool {
		return isset($_SESSION["userId"]);
	}


	public function getUsername(): string {
		return $_SESSION['username'] ?? '';
	}

	public function haveUserImage(): bool {
        return isset($_SESSION["imageId"]);
	}
	
    public function getImageId(): int {
        return $_SESSION['imageId'];
    }

	protected function authenticate(): void {
		if (!$this->isLoggedIn()) {
			header('Location: login.php');
			exit();
		}
	}

	private function setupLogger() {
		$log = new Logger(static::class);
		$log->pushHandler(new StreamHandler(__dir__ . '/../../logs/band-site.log', Logger::DEBUG));

		return $log;
	}

	private function getPdoConnection() {
		try {
			$pdoOptions = [ \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION ];

			return new \PDO('mysql:host=localhost;dbname=bandmerchdb', 'root', '', $pdoOptions);
		} catch (\PdoException $e) {
			// log error
			$this->log->error($e->getMessage());
			exit();
		}
	}
}
