<?php

include_once "config.php";
include "user.php";

include_once "db.php";
include "functions.php";

class Sys extends Database
{
        protected $user;

        public function __construct() {
                session_start();
                $this->conn = $this->connect();
                $this->user = new User($this->conn);
                
                if($this->user->loggedIn)
                {
                        
                }
        }

        public function isLoggedIn()
        {
                return $this->user->loggedIn;
        }
        public function init(int $header, string $title)
        {
                global $header_inforum;
                global $header_inforum_lgin;
                $admin = "";
                if($this->user->isAdmin)
                {
                        $admin = "<li><a><i class='fas fa-user-shield'></i> Admin</a></li>";
                }
                $bc = "no-header";
                $hdr = "";
                if ($header == 1) {
                        $bc = "of-header";
                        $hdr = "<div id='header-logo'></div><div id='header-side'></div><div id='header-foot'></div>";
                } else if ($header == 2) {
                        $bc = "if-header";
                        if($this->isLoggedIn() == true)
                        {
                                $hdr = "
                                <header>
                                <div id='nice-menu'>
                                        <div id='nm-header'>
                                                <div class=\"content\">
                                                <a class='header-text'>Nice Menu</a>
                                                <a class='fas fa-times' href='#'></a>
                                                </div>
                                        </div>
                                        <div id='nm-content'>
                                                <ul>
                                                <li><a class='bold-text'>Links</a></li>
                                                <li><a href=''>FAQ: Socialism</a></li>
                                                <li><a>Contact</a></li>
                                                <li><a>Support</a></li>
                                                </ul>
                                                <ul>
                                                <li><a class='bold-text'>Account</a></li>
                                                <li><a href='/acc/login.php'>Login</a></li>
                                                <li><a href='/acc/signup.php'>Signup</a></li>
                                                <li><a>Logout</a></li>
                                                </ul>
                                        </div>
                                </div>
                                <div id='header-side'>
                                <div class='content'>
                                        <ul>
                                                <li><a class='bold-text'>".$this->user->username."</a></li>
                                                <li><a><i class='fas fa-home'></i> Home</a></li>
                                                <li><a><i class='fas fa-user'></i> Profile</a></li>
                                                <li><a><i class='fas fa-envelope'></i> Messages</a></li>
                                                $admin
                                                <li><a href='/acc/logout.php'><i class='fas fa-sign-out-alt'></i> Logout</a></li>
                                        </ul>
                                </div>
                                </div>
                                <div id='header-foot'><div class='content'>
                                        <a>N</a>
                                        <a class='rsl'><i class='fas fa-home'></i></a>
                                        <a class='rsl'><i class='fas fa-question'></i></a>
                                        <a class='rsl'><i class='fas fa-list'></i></a>
                                        <a class='rsl'><i class='fas fa-calendar-alt'></i></a>
                                        <a class='rsl'><i class='fas fa-file-alt'></i></a>
                                        <a class='rsl' href='#nice-menu'><i class='fas fa-arrow-up'></i></a>
                                </div></div>
                                </header>
                                ";
                        } else {
                                $hdr = $header_inforum;
                        }
                } else {
                        $bc = "no-header";
                        $hdr = "";
                }
                echo "<!doctype HTML>

                <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>$title - nedusa.xyz</title>
                <link rel='stylesheet' href='css/main.css'>
                </head>
                <body>
                $hdr";
                
        }

        public function end()
        {
                echo "<script src=\"https://kit.fontawesome.com/ff79981b79.js\" crossorigin=\"anonymous\"></script></body></html>";
        }

        public function Signup($username, $pwd, $email)
        {
                $this->user->signup($username, $pwd, $email);
        }

        public function Login($usn, $pwd)
        {
                echo($this->user->login($usn, $pwd));

        }

        public function logout()
        {
                $this->user->logout();
        }
}

?>

