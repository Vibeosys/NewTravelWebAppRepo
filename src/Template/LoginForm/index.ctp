<?php



use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller;

$this->layout = false;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?= $this->Html->css('Login.css') ?> 
    
</head>
    <body class="align">
        <div class="site__container">
             <?php session_start();
                if(isset($_SESSION['message'])){?>
            <div class="message-div"><div class="img-span" ></div><?= h($_SESSION['message'])?></div>
                <?php unset($_SESSION['message']);}?>
            <div class="grid__container">
                <form action= "login/validate" method="POST" class="form form--login">
                    <div class="form__field">
                        <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
                        <input id="login__username" name="username" type="text" class="form__input" placeholder="Username" required>
                    </div>
                    <div class="form__field">
                        <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
                        <input id="login__password" name="password" type="password" class="form__input" placeholder="Password" required>
                    </div>
                    <div class="form__field" style="margin-left:190px">  
                            <input type="submit" name="login" value="Sign In">
                       </div>
                </form>
            </div>
        </div>
    </body>
</html>
