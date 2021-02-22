<?php 

function ensureExistence($param){
    if(isset($_GET[$param])){
        return $_GET[$param];
    }

    return null;
}