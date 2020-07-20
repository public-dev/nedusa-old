<?php

include "../sys/main.inc.php";
$ctrl = new Sys();
$ctrl->init(2, "Login");
if(isset($_POST['login']))
{
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username) || empty($password)) {
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
        } else {
                $ctrl->Login($username, $password);
        }
}
?>

<main>

<form method='POST' class="form sign-form">
        <a class='title'>Login</a>
        <div class="form-input">
                <input type="text" name="username" autofocus required>
                <div class="form-placeholder">Username</div>
        </div>
        <div class="form-input">
                <input type="password" name="password" required>
                <div class="form-placeholder">Password</div>
                <div class="form-show-password fas fa-eye-slash"></div>
        </div>

        <input type='submit' name='login' class="next-button" value='>'>
        <a href="">Can't log in?</a>
        <a href="signup.php">Create Account</a>
</form>

</main>

<script>
        var fields = document.querySelectorAll(".form-input input");
        document.querySelector(".form-show-password").addEventListener("click", function()
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
</script>

<?php

$ctrl->end();

?>