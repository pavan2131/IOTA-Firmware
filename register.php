<?php
$title = "Register";
include 'header.php';
include 'navbar.php';

if (post('register_user')) {
    try {
        extract(post());
        //check if user exists in database
        $sql = "SELECT * FROM rosx_user WHERE email_id='$email'";
        $check = $conn->query($sql);
        if ($check->num_rows > 0) {
            error("User already exists");
        } else {
            $password = password_hash(trim($password), PASSWORD_DEFAULT);
            $user_token = base64_encode($email);
            $create = $conn->query("INSERT INTO `rosx_user`( `username`, `password`, `email_id`, `usage_type`, `user_token`) VALUES ('$username','$password','$email','$usage_type','$user_token')");
            if ($create) {

                $createUser = [
                    'email' => $email,
                    'emailVerified' => true,
                    'password' => $password,
                    'displayName' => $username,
                    'disabled' => false,
                ];

                $createdUser = $auth->createUser($createUser);


                $uid = $createdUser->uid;



                $final = $conn->query("UPDATE `rosx_user` SET `google_uid`='$uid' WHERE email_id='$email'");
                if ($final) {

                    $project_id=md5(uniqid().time());
                    //for an user create an rtdb entry with uid under the child RosXIOTA 
                    $rtdb->getReference($uid)->set([
                        $project_id => [
                            "config" => [
                                "AUX1" => 0,
                                "AUX2" => 0,
                                "AUX3" => 0,
                                "AUX4" => 0,
                                "AUX5" => 0,
                                "AUX6" => 0,
                                "AUX7" => 0,
                                "AUX8" => 0,
                                "AUX9" => 0,
                                "AUX10" => 0,
                            ],
                            "info"=>[
                              "description"=>"This is a demo project",
                              "name"=>"Demo Project",
                              "project_id"=>$project_id,
                            ],
                            "DEVICE_STATUS" => "OFFLINE",
                            "ROSXBAG" => json_encode([
                                "AUX11" => 0
                            ])
                        ]
                    ]);


                    success("User created successfully <br> Please login to continue <br> <a href='login.php?email=$email' class='btn btn-primary'>Click here</a>");

                    // redirect("login.php?email=$email");
                } else {
                    //delete user from database
                    $conn->query("DELETE FROM `rosx_user` WHERE email_id='$email'");
                    error("Something went wrong");
                }
            } else {
                $conn->query("DELETE FROM `rosx_user` WHERE email_id='$email'");
                error("Something went wrong");
            }
        }
    } catch (Exception $e) {
        error($e->getMessage());
    }
}


?>
<main class="py-4">
    <div class="container-fluid">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register | <?= config('app_name') ?></div>

                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>
                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control " name="username" value="" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control " name="password" required autocomplete="current-password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="usage_type" class="col-md-4 col-form-label text-md-end">Usage Type</label>
                                    <div class="col-md-6">
                                        <select name="usage_type" class="form-control" id="usage_type">
                                            <option value="">Select Usage Type</option>
                                            <?php
                                            foreach (config('usage_type') as $value) {
                                                echo "<option value='$value'>$value</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-outline-primary" name="register_user" value="<?= uniqid(); ?>">
                                            Register
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
