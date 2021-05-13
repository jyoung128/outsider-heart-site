<?php
namespace BandSite;

class ResetViewModel extends BaseViewModel 
{

    public $errors = [];

    public function __construct(){
        parent::__construct();
        $this->handleSubmit();

    }

    private function handleSubmit(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return;
        }

        try {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm'];

            if (empty($username) || empty($password) || empty($confirm)) {
                array_push($this->errors, "All fields are required");
            }

            if ($password !== $confirm) {
                array_push($this->errors, "Passwords must match");
            }

            if (count($this->errors) > 0) {
                throw new \Exception("Validation errors: " . count($this->errors));
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE user SET password = '$hash' WHERE username = '$username'";
            $this->pdo->query($sql);
            header("Location: login.php");

        } catch (\PdoException $e){
            $this->log->error("MariaDB error code: " . $e->getCode());
            
        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
        }
    }
}