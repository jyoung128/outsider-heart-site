<?php
namespace BandSite;

class RegisterViewModel extends BaseViewModel 
{
    const ER_DUP_UNIQUE = '23000';

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
            $sql = "INSERT INTO user(username, password) VALUES('$username', '$hash')";
            $this->pdo->query($sql);

            //Get newly made user id for image upload
            $result = $this->pdo->query("SELECT * FROM user WHERE username = '$username'");
            $user = $result->fetchObject();
            $userId = $user->id;
            $this->handleImageUpload($userId);

            header("Location: login.php");

        } catch (\PdoException $e){
            $this->log->error("MariaDB error code: " . $e->getCode());

            if (self::ER_DUP_UNIQUE === $e->getCode()) {
				array_push($this->errors, 'Username already taken');
            }
            
        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
        }
    }

    private function handleImageUpload(int $userId): void {
        try{
            $profilepic = $_FILES['profilepic'];
            $filename = $profilepic['name'];
            $size = $profilepic['size'];
            $type = $profilepic['type'];
            $tmpPath = $profilepic['tmp_name'];

            if (!file_exists($tmpPath)) {
                throw new \Exception("$filename not found at temp location; bailing");
            }

            $handler = fopen($tmpPath, 'r');
            $data = fread($handler, $size);
            fclose($handler);


            $this->pdo->query("DELETE FROM image WHERE user_id = $userId");

            $data = $this->pdo->quote($data);
            $sql = "INSERT INTO image(filename, mimetype, imagedata, user_id)
            VALUES('$filename', '$type', $data, '$userId')";

            $this->pdo->query($sql);

            $this->pdo->query("i.id as `image_id`
            LEFT JOIN image i ON user.id = i.user_id");

        } catch (\Exception $e){
            $this->log->error($e->getMessage());
        }
    }
}