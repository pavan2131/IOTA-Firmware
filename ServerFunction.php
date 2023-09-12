<script>
    DisplayDataFromAux = (id, func) => {
        let element_id = id;
        let element_function = func;
        $.post("firebaseUpdate.php", {
            "id": element_id,
            "function": element_function,
            "project": "<?= get('project') ?>",
            "type": "display"
        }, function(data) {
            $('#DisplayValuesOfFb').text(data);
        });
    }


    sendSliderData = (id, value, func) => {
        let element_id = id;
        let element_value = value;
        let element_function = func;
        $.post("firebaseUpdate.php", {
            "id": element_id,
            "value": element_value,
            "function": element_function,
            "project": "<?= get('project') ?>",
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
        $.post("firebaseUpdate.php", {
            "id": element_id,
            "value": element_value,
            "function": element_function,
            "project": "<?= get('project') ?>",
            "type": "button"
        }, function(data) {

        });

    }

    LineGraphRequest = (id, func, name) => {
        const chart = new Chart(document.getElementById(id), {
            type: "line",
            data: {
                labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                datasets: [{
                    label: func + ' Channel ' + name ?? "Line Graph",
                    data: [],
                    borderColor: "#8e5ea2",
                    fill: false,
                }, ],
            },
        });
        const interval = setInterval(() => {
            $.post("firebaseUpdate.php", {
                "function": func,
                "project": "<?= get('project') ?>",
                "type": "line_graph"
            }, function(data) {
                chart.data.datasets[0].data.push(data);
                if(chart.data.datasets[0].data.length>10){
                    chart.data.datasets[0].data.shift()
                }
            
                chart.update();
            });
        }, 4000);
    }


    BarGraphRequest = (id, func, name) => {
        const chart = new Chart(document.getElementById(id), {
            type: "bar",
            data: {
                labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                datasets: [{
                    label: func + ' Channel ' + name ?? "Line Graph",
                    data: [],
                    borderColor: "rgba(0,0,0,0.2)",
                    fill: false,
                }, ],
            },
        });
        const interval = setInterval(() => {
            $.post("firebaseUpdate.php", {
                "function": func,
                "project": "<?= get('project') ?>",
                "type": "bar_graph"
            }, function(data) {
                chart.data.datasets[0].data.push(data);
                if(chart.data.datasets[0].data.length>10){
                    chart.data.datasets[0].data.shift()
                }
            
                chart.update();
            });
        }, 4000);
    }
</script>