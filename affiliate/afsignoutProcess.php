<?php

session_start();

if(isset($_SESSION["afuser"])){
    session_destroy();

    echo("success");
}else{
    echo("error");
}













?>