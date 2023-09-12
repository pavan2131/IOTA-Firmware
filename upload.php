<?php
$firmwareFile = exec('python ' . "print_bin_path.py");
$updateRequired = true; 
if ($updateRequired) {
  $firmwareData = file_get_contents($firmwareFile);
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="firmware.bin"');
  header('Content-Length: ' . strlen($firmwareData));
  header('Connection: close');
  echo $firmwareData;
} else {
  http_response_code(304);
}
echo $firmwareFile;
echo shell_exec("python dil_dir.py");
?>

