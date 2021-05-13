<?php
namespace BandSite;

class LogoutViewModel extends BaseViewModel {

    public function __construct(){
        parent::__construct();
        $this->logout();
    }

    private function logout(): void {
        $this->log->info("Logged out user with userId:" . $_SESSION['userId']);
        $_SESSION = [];
        header("Location: index.php");
    }
}