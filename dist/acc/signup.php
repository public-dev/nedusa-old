<?php

include "../sys/main.inc.php";
$ctrl = new Sys();
$ctrl->init(2, "Signup");
if(isset($_POST['signup']))
{
        $username = $_POST['username'];
        $password = $_POST['pwd'];
        $passwordc = $_POST['pwdc'];
        $email = $_POST['email'];

        if(empty($username) || empty($password) || empty($passwordc) || empty($email)) {
                $ctrl->warn("Fill in all fields");
        } else if(strlen($username) < 3 ) {
                $ctrl->warn("Username too short");
        } else if(strlen($username) > 25 ) {
                $ctrl->warn("Username too long");
        } else if(strlen($password) < 8) {
                $ctrl->warn("Password too short");
        } else if(strlen($password) > 50) {
                $ctrl->warn("Password too long");
        } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                $ctrl->warn("Invalid Username");
        } else if(!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
                $ctrl->warn("Invalid Password");
        } else if($password != $passwordc) {
                $ctrl->warn("Passwords don't match");
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "") {
                $ctrl->warn("Invalid Email");
        } else {
                $ctrl->Signup($username, $password, $email);
        }
}
?>

<main>

<form method='POST' class="form sign-form">
        <a class='title'>Signup</a>
        <div class="form-input">
                <input type="text" name="username" autofocus required>
                <div class="form-placeholder">Username</div>
        </div>
        <div class="form-input">
                <input type="password" name="pwd" required>
                <div class="form-placeholder">Password</div>
                <div class="form-show-password fas fa-eye-slash"></div>
        </div>

        <div class="form-input">
                <input type="password" name="pwdc" required>
                <div class="form-placeholder">Password</div>
                <div class="form-show-password fas fa-eye-slash"></div>
        </div>

        <div class="form-input">
                <input type="email" name="email" required>
                <div class="form-placeholder">E-mail</div>
        </div>

        <input type='submit' name='signup' class="next-button" value='>'>
        <a href="">Can't sign up?</a>
        <a href="login.php">Login</a>
</form>

</main>

<script>
        var fields = document.querySelectorAll(".form-input input");
        document.querySelectorAll(".form-show-password")[0].addEventListener("click", function()
        {
                if(this.classList[2] == 'fa-eye-slash') {
                        this.classList.remove("fa-eye-slash");
                        this.classList.add("fa-eye");
                        fields[1].type = "text";
                } else {
                        this.classList.remove("fa-eye");
                        this.classList.add("fa-eye-slash");
                        fields[1].type = "password";
                }
        });
        document.querySelectorAll(".form-show-password")[1].addEventListener("click", function()
        {
                if(this.classList[2] == 'fa-eye-slash') {
                        this.classList.remove("fa-eye-slash");
                        this.classList.add("fa-eye");
                        fields[2].type = "text";
                } else {
                        this.classList.remove("fa-eye");
                        this.classList.add("fa-eye-slash");
                        fields[2].type = "password";
                }
        });
</script>

<?php

$ctrl->end();

?>