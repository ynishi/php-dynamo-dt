<?php
spl_autoload_register(function ($name) {
    $path = __dir__ . '/' . $name . ".php";
    try {
        if (file_exists($path)) {
            include $path;
        }
    } catch (Exception $e) {
        throw new Exception("Unable to load $name at $path.");
    }
});

?>
