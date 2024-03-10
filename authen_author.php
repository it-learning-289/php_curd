<?php
<<<<<<< HEAD
class Authen
{
=======
//Authen
class Authen
{
    
>>>>>>> 9a1db96 (dev_tien testing class author)
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate()
    {
        global $pdo;
<<<<<<< HEAD
=======
        // Simulate authentication, you would normally check in a database
        // $validUsernames = ['user1', 'user2', 'user3'];
        // $validPasswords = ['pass1', 'pass2', 'pass3'];

        // if (in_array($this->username, $validUsernames) && in_array($this->password, $validPasswords)) {
        //     return true;
        // } else {
        //     return false;
        // }

        //test
>>>>>>> 9a1db96 (dev_tien testing class author)
        $sqlId = "SELECT username, `password` FROM user_login WHERE username = '$this->username'";
        $resultId = $pdo->query($sqlId);
        $result = $resultId->fetchAll(PDO::FETCH_ASSOC);
        if (!(count($result) == 1 && $result[0]['password'] == $this->password)) {
<<<<<<< HEAD
            // header("HTTP/1.1 401 Unauthen");
            // echo json_encode(array("message" => "Authen Failed"));
            return false;
        }
        return true;
    }
}

//AUTHOR
class Author
{
    private $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function checkPermission($username)
    {    
        global $pdo;
        $sql = "SELECT user_login.id, user_login.username , roles.role, roles.name_role FROM user_login inner JOIN user_role ON user_login.id = user_role.user_id inner JOIN roles ON roles.id= user_role.role_id where user_login.username ='$username' and  roles.role= '$this->role'";
        $result = $pdo->query($sql);
        $result = $result->fetch(PDO::FETCH_ASSOC);
        // dd($this->role);
        // dd($result);
        return $result;
    }
}
=======
            header("HTTP/1.1 401 Unauthen");
            echo json_encode(array("message" => "Authen Failed"));
            exit;
        }
    }
}

//Author
class Author {
    private $role;
    public function __construct($role) {
        $this->role = $role;
    }

    public function checkPermission($requiredRole) {
        if ($this->role === $requiredRole) {
            return true;
        } else {
            return false;
        }
    }
}

>>>>>>> 9a1db96 (dev_tien testing class author)
