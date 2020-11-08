<?php

require_once('Sesh.php');
class Users extends Sesh
{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function createUser($uname,$upass,$ks3start)
    {
        try
        {
            $new_password = password_hash($upass, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("INSERT INTO tblUsers(username,password,KS3Start)
                                                       VALUES(:uname, :upass, :ks3start)");

            $stmt->bindparam(":uname", $uname);
            $stmt->bindparam(":upass", $new_password);
            $stmt->bindparam(":ks3start", $ks3start);
            $stmt->execute();

            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function login($uname,$upass)
    {
        try
        {
            //$stmt = $this->db->prepare("SELECT * FROM users WHERE user_name=:uname OR user_email=:umail LIMIT 1");
            $stmt = $this->conn->prepare("SELECT * FROM tblUsers WHERE username=:uname");
            //$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
            $stmt->bindParam(':uname', $uname);
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0)
            {
                if(password_verify($upass, $userRow['password']))
                {
                    $_SESSION['users_id'] = $userRow['UsersID'];
                    $_SESSION['username'] = $userRow['username'];
                    $_SESSION['user_type'] = $userRow['user_type'];
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function is_loggedin()
    {
        if(isset($_SESSION['users_id']))
        {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['users_id']);
        return true;
    }
}