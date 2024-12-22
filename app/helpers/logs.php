<?php
function console_log($message)
{
    echo "<script>console.log(";
    echo json_encode($message);
    echo ");</script>";
}   