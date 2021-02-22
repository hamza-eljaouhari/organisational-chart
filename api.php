<?php 

    require 'config.php';
    require 'util.php';

    header("Content-type: application/json");   

    // ensure GET
    $request_method = $_SERVER["REQUEST_METHOD"];

    if($request_method !== "GET"){
        return;
    }

    $node_id = ensureExistence("node_id");
    $language = ensureExistence("language");
    $search_keyword = ensureExistence("search_keyword");
    $page_num = ensureExistence("page_num");
    $page_size = ensureExistence("page_size");

    // Validation

    // echo($node_id);
    // echo($language);
    // echo($search_keyword);
    // echo($page_num);
    // echo($page_size);
    $json = new stdClass();

    $json->nodes = [];

    if($node_id === null){
        $json->error = "Missing mandatory params";
        echo json_encode($json);
        exit;
    }

    if(intval($node_id) < 1){
        $json->error = "Invalid node id.";
        echo json_encode($json);
        exit;
    }

    if($language === null){
        $json->error = "Missing mandatory params";
        echo json_encode($json);
        exit;
    }

    if($page_num === null){
        $page_num = 0;
    }

    if(intval($page_num) < 0){
        $json->error = "Invalid page number requested.";
        echo json_encode($json);
        exit;
    }

    
    if($page_size === null){
        $page_size = 100;
    }

    if(intval($page_size) < 0){
        $json->error = "Invalid page size requested";
        echo json_encode($json);
        exit;
    }

    // var_dump($node_id);
    // var_dump($language);
    // var_dump($search_keyword);
    // var_dump($page_num);
    // var_dump($page_size);

    echo json_encode($json);
?>