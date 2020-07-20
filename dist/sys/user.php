<?php

class User
{
        public $loggedIn = false;
        public $id = 0;
        public $username = "";
        public $email = "";
        public $status = "";
        public $signed_up = "";
        public $isAdmin = false;

        public $key = "";

        protected $conn;

        public function __construct($conn) {
                $this->conn = $conn;

                if($this->isLoggedIn())
                {
                        $info = $this->fetchUserData($this->id);

                        if(!$info)
                        {
                                $this->logOut();
                        } else {
                                $this->loggedIn = true;
                                $this->username = $info['uname'];
                                $this->email = $info['email'];
                                $this->status = $info['ustatus'];
                                $this->isAdmin = $info['isAdmin'];
                        }
                }
        }


        protected function isLoggedIn()
        {
                if (isset($_SESSION['key']) && isset($_SESSION['id'])) {
                        $this->key = $_SESSION['key'];
                        $this->id = $_SESSION['id'];
                        return true;
                }
                return false;
        }

        protected function fetchUserData($id)
        {
                $sql = "SELECT * FROM users WHERE uid = ? LIMIT 1";

                $query = $this->conn->prepare($sql);
                $query->execute([$id]);

                $row = $query->fetch();

                if($row == 0)
                {
                        return false;
                }
                return $row;
        }

        protected function generateSession($uid)
        {
                $key = random_str(128);

                $key_check = "SELECT * FROM sessions WHERE key = ?";

                $kc_query = $this->conn->prepare($key_check);
                $kc_query->execute($key);

                $kcc = $kc_query->fetchColumn();

                if($kcc)
                {
                        return StartSession();
                }

                $sess_sql = "INSERT into sessions (id, user) VALUES (?, ?)";

                $sess_query = $this->conn->prepare($sess_sql);
                $sess_query->execute([$key, $uid]);

                return $key;
        }

        public function logout()
        {
                if($this->loggedIn)
                {
                        $this->deleteSession($this->key);
                        $this->key = "";
                        $this->id = "";
                        $this->loggedIn = false;
                        unset($_SESSION['key']);
                        unset($_SESSION['id']);

                        return 0;
                }

                return 1;
                
        }

        protected function deleteSession($key)
        {
                $sql = "DELETE from users WHERE key = ?";
                $query = $this->conn->prepare($sql);
                $query->execute([$key]);
        }

        public function login($username, $password)
        {
                $sql = "SELECT * FROM users WHERE uname = ? LIMIT 1";
                $query = $this->conn->prepare($sql);
                $query->execute([$username]);
                $row = $query->fetch();
                if($row == 0)
                {
                        return "Invalid Username";
                }

                $hash = $row['passwd'];

                if(password_verify($password, $hash))
                {
                        $_SESSION['key'] = $this->generateSession($row['uid']);
                        $_SESSION['id'] = $row['uid'];
                        header("Location: ../");
                } else {
                        return "Invalid Username or Password";
                }
        }

        public function signup($username, $pwd, $email)
        {
                $sql_fetch_username = "SELECT username FROM users WHERE username = ?";
                $sql_fetch_email = "SELECT email FROM users WHERE email = ?";

                $query_username = $this->conn->prepare($sql_fetch_username, [$username]);
                $query_email = $this->conn->prepare($sql_fetch_email, [$email]);
                
                $query_username->execute();
                $query_email->execute();

                $unu = $query_username->fetchColumn();
                $enu = $query_email->fetchColumn();

                if($unu)
                {
                        echo "Username in use";
                } else if($enu)
                {
                        echo "Email in use";
                } else {
                        $password = password_hash($pwd, PASSWORD_DEFAULT);

                        $sql_store = "INSERT into users (passwd, uname, email) VALUES (?, ?, ?)";

                        $query = $this->conn->prepare($sql_store);
                        $query->execute([$password, $username, $email]);

                        echo "Done";
                }
        }
}

?>