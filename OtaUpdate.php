<?php
$title = "Ota Update";
include 'header.php';
is_logged_in();
include 'sidebar.php';
?>
<div class="container mt-4">
    <h2>Code Editor</h2>
    <div class="form-group">
        <label for="codeInput">Enter your code:</label>
        <textarea class="form-control" id="codeInput" rows="10"></textarea>
    </div>
    <button class="btn btn-primary mt-3" onclick="compileCode()">Complile Code</button>
    <button class="btn btn-success mt-3" onclick="uploadCode()">Upload Code</button>
</div>
<script>

    $.post("firebaseUpdate.php", {
        "function": "CodeCompliler",
        "project": "<?= get('project') ?>",
        "type": "GetCodeContents"
    }, function(data) {
        if (data != '') {
            $('#codeInput').val(data);
        } else {
            var defaultCode = "\nvoid setup() {\n  // Your setup code here\n}\n\n\nvoid loop() {\n  // Your loop code here\n}";
            $('#codeInput').val(defaultCode);
        }
    });


    compileCode = () => {
        let code = $('#codeInput').val();
        $.post("firebaseUpdate.php", {
            "function": "CodeCompliler",
            "project": "<?= get('project') ?>",
            "type": "ComplieCode",
            "code": code
        }, function(data) {
            if (data) {
                alert('The Program has been Complied Successfully.. Please Update the Code to Device !');
            } else {
                alert("Failed to Compile the code !!");
            }
            setTimeout(function() {
                location.reload();
            }, 1000)
        });
    }

    uploadCode =()=>{
        $.post("firebaseUpdate.php", {
            "function": "rosxupdate",
            "project": "<?= get('project') ?>",
            "type": "UpdateOta",
        }, function(data) {
            if (data==="success") {
                alert('The Program has been Pushed to OTA Successfully.. !');
            } else {
                alert("Failed to Update the code to OTA !!");
            }
            setTimeout(function() {
                location.reload();
            }, 1000)
        });
    }
</script>
<?php

include 'footer.php';
