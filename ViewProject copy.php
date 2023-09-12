<?php
$title = "My Project";
include 'header.php';
is_logged_in();
include 'sidebar.php';


$project = $rtdb->getReference(session('google_id'))->getSnapshot()->getValue()[get('project')] ?? [];
// array_print($project);
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

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
                    if ($cfg['type'] == "slider") {
            ?>
                        <div class="col-md-4 my-2">
                            <div class="form-group">
                                <label for="<?= $cfg['name'] ?>" class="form-label"><?= $cfg['name'] ?> : <?= $cfg['function']; ?></label>
                                <input type="range" class="form-range" step="1" min="0" max="100" id="<?= $cfg['name'] ?>" onchange="sendSliderData('<?= $cfg['id'] ?>',this.value,'<?= $cfg['function'] ?>')">
                            </div>
                        </div>
                    <?php

                    } else if ($cfg['type'] == "button") {
                    ?>
                        <div class="col-md-4">
                            <div class="checkbox">
                                <label for="<?= $cfg['name'] ?>" class="form-label"><?= $cfg['name'] ?> : <?= $cfg['function']; ?></label>
                                <input type="checkbox" data-toggle="toggle" id="<?= $cfg['name'] ?>" onchange="handleButtonClick('<?= $cfg['id'] ?>','<?= $cfg['function'] ?>')">

                                </label>
                            </div>
                        </div>
                    <?php

                    } else if ($cfg['type'] == "display") {
                    ?>
                        <div class="col-md-4">
                            <div class="card shadow-lg card-hover text-center bg-primary" style="width:14rm">
                                <p class="text-white font-weight-bolder m-2 ">
                                    <?= $cfg['name'] ?>
                                </p>
                                <h1 id="DisplayValuesOfFb" class="text-white font-weight-bolder">0</h1>
                            </div>
                        </div>
                        <script>
                            setInterval(function() {
                                DisplayDataFromAux('<?= $cfg['id'] ?>', '<?= $cfg['function'] ?>');
                            }, 5000);
                        </script>
            <?php

                    }

                    else if ($cfg['type'] == "line_graph") {
                        ?>
                            
                        <div class="chartCard" style="display: flex; justify-content: center; align-items: center; height: 400px;width: 50%;">
  <div class="chartBox" style="width: 100%; height: 50%;">
    <canvas id="myChart" style="width: 100%; height: 100%;"></canvas>
  </div>
</div>





<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = null;
  var a = [100];

  function createChart(data) {
    var labels = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    a.push(data);
    var values = a.slice(-10);

    if (myChart === null) {
      myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: '<?= $cfg['name'] ?>',
            data: values,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4
          }]
        },
        options: {
          scales: {
        
     
            y: {
        
              beginAtZero: true,
              max: Math.max(...values) + 2
            }
          }
        }
      });
    } else {
      myChart.data.datasets[0].data = values;
      myChart.options.scales.y.max = Math.max(...values) + 2;
      myChart.update();
    }
  }

  function LineDataFromAux(id, func) {
    let element_id = id;
    let element_function = func;
    $.post("firebaseUpdate.php", {
      "id": element_id,
      "function": element_function,
      "project": "<?= get('project') ?>",
      "user": "<?= session('google_id') ?>",
      "type": "line_graph"
    }, function(data) {
      $('#LineValuesOfFb').text(data);
      createChart(JSON.parse(data));
    });
  }

  setInterval(function() {
    LineDataFromAux('<?= $cfg['id'] ?>', '<?= $cfg['function'] ?>');
  }, 5000);
</script>


                <?php
                        }

                        else if ($cfg['type'] == "bar_graph") {
                            ?>
                                
    
                            <div class="chartCard" style="display: flex; justify-content: center; align-items: center; height: 400px;width: 50%;">
      <div class="chartBox" style="width: 100%; height: 50%;">
        <canvas id="myChart2" style="width: 100%; height: 100%;"></canvas>
      </div>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
    <script>
      var ctx2 = document.getElementById('myChart2').getContext('2d');
      var myChart2 = null;
      var a = [100];
    
      function createChart2(data) {

        var labels = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        a.push(data);
        var values = a.slice(-10);
    
        if (myChart2 === null) {
          myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [{
                label: '<?= $cfg['name'] ?>',
                data: values,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
              }]
            },
            options: {
              scales: {
            
         
                y: {
            
                  beginAtZero: true,
                  max: Math.max(...values) + 2
                }
              }
            }
          });
        } else {
          myChart2.data.datasets[0].data = values;
          myChart2.options.scales.y.max = Math.max(...values) + 2;
          myChart2.update();
        }
      }
   
     
      function BarDataFromAux(id, func) {
        let element_id = id;
       
        let element_function = func;
        $.post("firebaseUpdate.php", {
          "id": element_id,
          "function": element_function,
          "project": "<?= get('project') ?>",
          "user": "<?= session('google_id') ?>",
          "type": "bar_graph"
        }, function(data) {
          createChart2(JSON.parse(data));
        });
      }
    
      setInterval(function() {
        BarDataFromAux('<?= $cfg['id'] ?>', '<?= $cfg['function'] ?>');
      }, 5000);
    </script>
    
    
                    <?php
                            }



                        else if ($cfg['type'] == "linear_regression") {
                            ?>
                                
    
                            <div class="chartCard" style="display: flex; justify-content: center; align-items: center; height: 400px;width: 50%;">
      <div class="chartBox" style="width: 100%; height: 50%;">
        <canvas id="myChar2" style="width: 100%; height: 100%;"></canvas>
      </div>
    </div>
    
    
    
    <script>
      var ct4 = document.getElementById('myChar2').getContext('2d');
      var myChar4 = null;
      var a = [];
    
      function createChar4(data) {

        var labels = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        a.push(data);
        if(a.length>=10){
        var values = a.slice(-10);
        }else{
            var values = a
        }
        // values=[0,2,3,20]
        function learnig_rate(yArray) {
                var xSum = 0,
                    ySum = 0,
                    xxSum = 0,
                    xySum = 0;
                var xArray = [];
                for (var i = 1; i <= yArray.length; i++) {
                    xArray.push(i);
                }
                var count = xArray.length;
                for (var i = 0, len = count; i < count; i++) {
                    xSum += xArray[i];
                    ySum += yArray[i];
                    xxSum += xArray[i] * xArray[i];
                    xySum += xArray[i] * yArray[i];
                }
                var slope = (count * xySum - xSum * ySum) / (count * xxSum - xSum * xSum);
                var intercept = (ySum / count) - (slope * xSum) / count;
                var xValues = [];
                var yValues = [];
                for (var x = 0; x < xArray.length; x += 1) {
                    xValues.push(xArray[x]);
                    yValues.push(xArray[x] * slope + intercept);
                }
      
                function predict(x, slope, intercept) {
                    var p = x * slope + intercept;
                    return p;
                }
                var pre = predict(xArray.length + 1, slope, intercept);
                let j = 20;
                while (pre > 100) {
                    pre = pre - j;
                    if (j > 5) {
                        j = j / 2;
                    }
                }
      return [pre,xValues,yValues]
              }
            //   console.log(values);
              [predict,x_,y_]=learnig_rate(values);
            console.log(predict);
            console.log(y_);

        if (myChar4 === null) {
          myChar4 = new Chart(ct4, {

            data: {
            labels: labels,
              datasets: [{
                label: '<?= $cfg['name'] ?>',
                data: y_,
                type: 'line',
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',

                
              },
          {
            data: values,
            label: 'Actual values',
            type: 'scatter',
            backgroundColor: 'rgba(255, 99, 71, 0.8)'
          },
          {
            
            label: 'Predicted value: ' + predict,
            type: 'scatter',
            backgroundColor: 'white'
          
          }]
            }
          });
        } else {
            [predict,x_,y_]=learnig_rate(values);
          myChar4.data.datasets[0].data = y_;
        //   myChar4.options.scales.y.max = Math.max(...values) + 2;
          myChar4.update();
        }
      }
   
     
      function linear_regressionDataFromAux(id, func) {
        let element_id = id;
       
        let element_function = func;
        $.post("firebaseUpdate.php", {
          "id": element_id,
          "function": element_function,
          "project": "<?= get('project') ?>",
          "user": "<?= session('google_id') ?>",
          "type": "linear_regression"
        }, function(data) {
          createChar4(JSON.parse(data));
        });
      }
    
      setInterval(function() {
        linear_regressionDataFromAux('<?= $cfg['id'] ?>', '<?= $cfg['function'] ?>');
      }, 5000);
    </script>
    
    
                    <?php
                            }

                            else if ($cfg['type'] == "line_extended_graph") {
                                ?>
    <h1>hello</h1>
    <div class="chartCard" style="display: flex; justify-content: center; align-items: center; height: 400px;width: 50%;">
  <div class="chartBox" style="width: 100%; height: 50%;">
    <canvas id="myChart3" style="width: 100%; height: 100%;"></canvas>
  </div>
</div>




<script>
  var ctx3 = document.getElementById('myChart3').getContext('2d');
  var myChart3 = null;
  var a = [100];
  var i=10;
  var labels = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

  function createChart3(data) {
    a.push(data);
    var values = a;
    
    i=i+1;
    labels.push(i);
    i=i+1;
    labels.push(i);
    i=i+1;
    labels.push(i);
    if (myChart3 === null) {
      myChart3 = new Chart(ctx3, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: '<?= $cfg['name'] ?>',
            data: values,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4
          }]
        },
        options: {
          scales: {
        
     
            y: {
        
              beginAtZero: true,
              max: Math.max(...values) + 2
            }
          }
        }
      });
    } else {
      myChart3.data.datasets[0].data = values;
      myChart3.options.scales.y.max = Math.max(...values) + 2;
      myChart3.update();
    }
  }

  function LineExDataFromAux(id, func) {
    let element_id = id;
    let element_function = func;
    $.post("firebaseUpdate.php", {
      "id": element_id,
      "function": element_function,
      "project": "<?= get('project') ?>",
      "user": "<?= session('google_id') ?>",
      "type": "line_extended_graph"
    }, function(data) {
      createChart3(JSON.parse(data));
    });
  }

  setInterval(function() {
    LineExDataFromAux('<?= $cfg['id'] ?>', '<?= $cfg['function'] ?>');
  }, 5000);
</script>
    <?php
                            }





































                            

                    if ($i % 3 == 0) {
                        echo '</div><div class="row">';
                    }
                    $i++;
                }
            }

            ?>
        </div>

    </div>
</div>
<script>
    DisplayDataFromAux = (id, func) => {
        let element_id = id;
        let element_function = func;
        $.post("firebaseUpdate.php", {
            "id": element_id,
            "function": element_function,
            "project": "<?= get('project') ?>",
            "user": "<?= session('google_id') ?>",
            "type": "display"
        }, function(data) {
            $('#DisplayValuesOfFb').text(data);
        });
    }
   

    sendSliderData = (id, value, func) => {
        let element_id = id;
        let element_value = value;
        let element_function = func;
        console.log(element_id)
        $.post("firebaseUpdate.php", {
            "id": element_id,
            "value": element_value,
            "function": element_function,
            "project": "<?= get('project') ?>",
            "user": "<?= session('google_id') ?>",
            "type": "slider"
        }, function(data) {

        });

    }
    valueb = false;
    handleButtonClick = (id, func) => {
        valueb = !valueb;
        if (valueb) {
            var val = 1;
        } else {
            var val = 0;
        }
        let element_id = id;
        let element_value = val;
        let element_function = func;
        console.log(element_id)
        $.post("firebaseUpdate.php", {
            "id": element_id,
            "value": element_value,
            "function": element_function,
            "project": "<?= get('project') ?>",
            "user": "<?= session('google_id') ?>",
            "type": "button"
        }, function(data) {

        });

    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php

include 'footer.php';
