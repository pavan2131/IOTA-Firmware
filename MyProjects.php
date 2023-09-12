<?php 

$title="My Projects";
include 'header.php';
is_logged_in();
include 'sidebar.php';
$myprojs=$rtdb->getReference(session('google_id'))->getSnapshot()->getValue() ?? [];



?>
<div class="card m-3">
    <div class="card-header">
        <h3 class="card-title">My Projects</h3>
    </div>
    <div class="card-body">
            <div class="row">
                <?php 
                    foreach($myprojs as $key=>$val) : ?>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-primary border-1 border-primary">
                                    <h5 class="text-white fw-bolder"><?= $val['info']['name'] ?></h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                    <?= $val['info']['description'] ?>
                                    </p>
                                    <p>
                                        ID : <?= $val['info']['project_id'] ?>  
                                    </p>
                                    <b>
                                        STATUS : <?= $val['DEVICE_STATUS'] ?? 'OFFLINE' ?>
                                    </b>
                                    <br>
                                    <a href="ViewProject.php?project=<?= $val['info']['project_id'] ?>" class="btn btn-primary mt-3">View Project</a>
                                    <a href="LoadProjectConfiguration.php?project=<?= $val['info']['project_id'] ?>" class="btn btn-warning mt-3">Edit Configurations</a>
                                    <a href="OtaUpdate.php?project=<?= $val['info']['project_id'] ?>" class="btn btn-danger mt-3">OTA Update</a>
                                </div>
                            </div>
                        </div>


                <?php   
                    endforeach;
                ?>
            </div>
    </div>
</div>

<?php
include 'footer.php';