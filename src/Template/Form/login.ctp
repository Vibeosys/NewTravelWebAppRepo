<?php



use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller;

$this->layout = false;
if(isset($_POST['login'])){
    

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?= $this->Html->css('Login.css') ?> 
    <link href=<?php $this->Html->css('Login.css') ?> rel="stylesheet" />
</head>
    <body class="align">
        <div class="site__container">
            <div class="grid__container">
                <form action="" method="post" class="form form--login">
                    <div class="form__field">
                        <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
                        <input id="login__username" type="text" class="form__input" placeholder="Username" required>
                    </div>
                    <div class="form__field">
                        <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
                        <input id="login__password" type="password" class="form__input" placeholder="Password" required>
                    </div>
                    <div class="form__field" style="margin-left:190px">
                        <input type="submit" name="login" value="Sign In">
                    </div>
                </form>
                <p class="text--center">Not a member? <a href="#">Sign up now</a> <span class="fontawesome-arrow-right"></span></p>
            </div>
        </div>
    </body>
</html>
