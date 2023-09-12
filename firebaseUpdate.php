<?php

include "config.php";
$project_id = post('project');
$user_id = session('google_id');
$func = post('function');


if (post('type') == "slider") {
    $value = post('value');
    $rtdb->getReference($user_id . "/" . $project_id . "/config/" . $func)->set($value);
    echo "success";
}
if (post('type') == "button") {
    $value = (int)post('value');
    $rtdb->getReference($user_id . "/" . $project_id . "/config/" . $func)->set($value);
    echo "success";
}
if (post('type') == "UpdateOta") {
    $value = (int)post('value');
    $rtdb->getReference($user_id . "/" . $project_id . "/config/" . $func)->set((int)1);
    echo "success";
}

if (post('type') == "display") {
    $snap = $rtdb->getReference($user_id)->getSnapshot()->getValue()[$project_id]['config'];
    if (!empty($snap)) {
        echo $snap[$func] ?? 0;
    }
}

if (post('type') == "line_graph") {
    $snap = $rtdb->getReference($user_id)->getSnapshot()->getValue()[$project_id]['config'];
    if (!empty($snap)) {
        echo $snap[$func] ?? 0;
    }
}
if (post('type') == "bar_graph") {
    $snap = $rtdb->getReference($user_id)->getSnapshot()->getValue()[$project_id]['config'];
    if (!empty($snap)) {
        echo $snap[$func] ?? 0;
    }
}

if (post('type') == "ComplieCode") {
    $code = post('code') ?? null;
    if ($code) {
        $file = __DIR__.'/prgm/prgm.ino';
        $handle = fopen($file, 'w');
        if ($handle) {
            // Clear the contents of the file
            ftruncate($handle, 0);
            fwrite($handle, $code);
            // Close the file handle
            fclose($handle);
            echo 'success';
        } else {
            http_response_code(500);
        }
    } else {
        throw new Exception("Iota Server Error: Can not Complile and Empty code");
    }
}


if(post('type')=="GetCodeContents"){
    $file = __DIR__.'/prgm/prgm.ino';
    $data= fopen($file,'r');
    $contents =filesize($file) > 0 ? fread($data, filesize($file)) : null;
    fclose($data);
    http_response_code(200);
    echo $contents;
}