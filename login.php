<?php
$title="Login";
include 'header.php';
include 'navbar.php';
$login=false;
if(post('login_user')){
    extract(post());
    $sql=$conn->query("SELECT * FROM rosx_user WHERE email_id='$email'");
    if($sql->num_rows>0){
        $user=$sql->fetch_assoc();
        if(password_verify($password,$user['password'])){
            $_SESSION['auth_token']=base64_encode($user['google_uid']);
            $_SESSION['user_email']=$user['email_id'];
            $_SESSION['user_name']=$user['username'];
            $_SESSION['google_id']=$user['google_uid'];
            $login=true;
        }else{
            warning("Invalid password");
        }
    }else{
        error("User not found");
    }
}
if(get('error')){
    error(get('error'));
}
if($login){
    success("Login Success");
    ?>
    <h5 class="text-center text-primary">Redirecting you to dashboard in <span id="time"></span></h5>
    <script>
        var time=5;
        var timer=setInterval(function(){
            time--;
            document.getElementById('time').innerHTML=time;
            if(time==0){
                clearInterval(timer);
                window.location.href="dashboard.php?login=success";
            }
        },1000);
    </script>
    <?php
}

?>
<main class="py-4">
    <div class="container-fluid">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login | <?= config('app_name')?></div>

                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control " name="email" value="<?= get('email')?>" required autocomplete="email" autofocus>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control " name="password" required autocomplete="current-password">

                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary" name="login_user" value="<?= uniqid();?>">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include 'footer.php';
