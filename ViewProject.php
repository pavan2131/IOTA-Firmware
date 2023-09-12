<?php
$title = "My Project";
include 'header.php';
is_logged_in();
include 'sidebar.php';


$project = $rtdb->getReference(session('google_id'))->getSnapshot()->getValue()[get('project')] ?? [];
// array_print($project);
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<?php include 'ServerFunction.php' ?>
<div class="card m-4">
    <div class="card-header bg-primary border-1 border-primary">
        <h5 class="text-white fw-bolder">
            <?= $project['info']['name'] ?>
        </h5>
        <hr>
        <h6 class="text-white fw-bolder">
            <?= $project['info']['description'] ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            if ($project['hw_config']) {
                $i = 0;

                foreach ($project['hw_config'] as $key => $cfg) {
                    

                    /* This code block is creating a slider element for the hardware configuration of a
                  project. It checks if the type of the configuration is "slider" and if so, it
                  creates a slider element with a label, a minimum value of 0, a maximum value of
                  180, and an ID. It also includes an `onchange` event that calls the
                  `sendSliderData` function, passing in the ID, value, and function of the
                  configuration. This function updates the value of the slider element in Firebase. */
                    if ($cfg['type'] == "slider") {
            ?>
                        <div class="col-md-4 mb-2">
                            <div class="card bg-danger p-2 shadow-lg" style="width:14rm">
                            <div class="form-group">
                                <label for="<?= $cfg['name'] ?>" class="form-label text-white font-weight-bolder"><?= $cfg['name'] ?></label>
                                <input type="range" value="0" class="form-range" step="1" min="0" max="180" id="<?= $cfg['name'] ?>" onchange="sendSliderData('<?= $cfg['id'] ?>',this.value,'<?= $cfg['function'] ?>')">
                                <br>
                                <p class="text-white font-weight-bolder">Channel : <?= $cfg['function']; ?></p>
                            </div>
                            </div>
                        </div>
                    <?php
                    }

                    /* This code block is creating a checkbox element for the hardware configuration of
                    a project. It checks if the type of the configuration is "button" and if so, it
                    creates a checkbox element with a label and an ID. It also includes an
                    `onchange` event that calls the `handleButtonClick` function, passing in the ID
                    and function of the configuration. This function updates the value of the
                    checkbox element in Firebase. */
                    if ($cfg['type'] == "button") {
                    ?>
                        <div class="col-md-4 mb-2">
                            <div class="card shadow-lg bg-warning p-2 text-center">
                            <div class="checkbox ">
                                <label for="<?= $cfg['name'] ?>" class="form-label font-weight-bolder text-white h5 "><?= $cfg['name'] ?></label>
                                <br>
                                <input type="checkbox" data-toggle="toggle" id="<?= $cfg['name'] ?>" onchange="handleButtonClick('<?= $cfg['id'] ?>','<?= $cfg['function'] ?>')">
                                <br>
                            </div>
                            <p class="text-white font-weight-bolder">Channel : <?= $cfg['function']; ?></p>
                            </div>
                           
                        </div>
                    <?php
                    }



                    /* This code block is creating a display element for the hardware configuration of a project. It checks
                    if the type of the configuration is "display" and if so, it creates a card element with a title, a
                    value (initialized to 0), and a channel number. It also includes a script that calls the
                    `DisplayDataFromAux` function every 5 seconds, passing in the ID and function of the configuration.
                    This function updates the value of the display element with the latest data from Firebase. */

                    if ($cfg['type'] == "display") {
                    ?>
                        <div class="col-md-4 mb-2  p-2 ">
                            <div class="card shadow-lg card-hover text-center bg-primary" style="width:14rm">
                                <p class="text-white font-weight-bolder m-2 ">
                                    <?= $cfg['name'] ?>
                                </p>
                                <h1 id="DisplayValuesOfFb" class="text-white font-weight-bolder">0</h1>
                                <p class="text-white font-weight-bold">Channel : <?= $cfg['function']; ?></p>
                            </div>
                        </div>
                        <script>
                            setInterval(function() {
                                DisplayDataFromAux('<?= $cfg['id'] ?>', '<?= $cfg['function'] ?>');
                            }, 5000);
                        </script>
                    <?php
                    }


                    if ($cfg['type'] == "line_graph") {
                    ?>
                        <div class="col-md-4 mb-2 card shadow-lg p-2 ">
                            <canvas id="LRG_<?= $cfg['id'] ?>" style="width: 100%; max-height:350px"></canvas>
                        </div>
                        <script>
                            LineGraphRequest("LRG_<?= $cfg['id'] ?>", '<?= $cfg['function'] ?>', '<?= $cfg['name'] ?>');
                        </script>

                    <?php
                    }
                    
                    if ($cfg['type'] == "bar_graph") {
                        ?>
                            <div class="col-md-4 mb-2 card shadow-lg p-2 ">
                                <canvas id="BRG_<?= $cfg['id'] ?>" style="width: 100%;  max-height:350px"></canvas>
                            </div>
                            <script>
                                BarGraphRequest("BRG_<?= $cfg['id'] ?>", '<?= $cfg['function'] ?>', '<?= $cfg['name'] ?>');
                            </script>
    
                        <?php
                     }
                }
            }

            ?>
        </div>

    </div>
</div>

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php

include 'footer.php';
