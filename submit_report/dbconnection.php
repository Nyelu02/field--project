<?php

function dbconnection()
{
    $con=mysqli_connect("localhost", "root", "", "submit_report");
    return $con;
}


?>