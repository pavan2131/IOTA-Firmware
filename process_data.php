<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $textData = $_POST['text_data'];
    $formattedTextData = nl2br($textData);
    $file = 't.ino'; // Specify the name of the file
    $newContent = $textData;// Specify the new content
    file_put_contents($file, $newContent);
    // echo "Received Text Data: " . $formattedTextData;
   shell_exec("python hello.py");
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<a href="upload.php" download>
  <button>GO</button>
</a>
</body>
</html>
