<?php

session_start();

if(isset($_SESSION["user"])){
    session_destroy();

    echo("success");
}else{
    echo("error");
}













?>