<?php
namespace BandSite;

class LoginViewModel extends BaseViewModel
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

            if (empty($username) || empty($password)) {
                array_push($this->errors, "All fields are required");
                throw new \Exception("Validation errors");
                
            }

            $result = $this->pdo->query("SELECT u.*, i.id as image_id 
            FROM user u
            LEFT JOIN image i ON u.id = i.user_id
            WHERE username = '$username'");

           if ($result->rowCount() !== 1) {
            array_push($this->errors, "User not found");
            throw new \Exception("User not found error");
           }

           $user = $result->fetchObject();

           if (!password_verify($password, $user->password)) {
            array_push($this->errors, "Invalid username or password");
            throw new \Exception("Bad password");
           }


           //logged in
           $this->log->info("User logged in with userId $user->id");
           $_SESSION['userId'] = $user->id;
           $_SESSION['username'] = $user->username;
           $_SESSION['imageId'] = $user->image_id;
           header("Location: index.php");
        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
        }
    }
}
