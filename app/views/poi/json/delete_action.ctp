<?php
    Configure::write('debug', 0);
    $data = array('success' => $success);
    echo $javascript->object($data);
?>