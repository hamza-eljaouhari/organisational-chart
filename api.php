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

    if($search_keyword === null){
        $search_keyword = '';
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $sql = getQuery();

        $stmt = $conn->prepare($sql);
        
        $offset = intval($page_num) * intval($page_size);

        $stmt->bindParam(':LANGUAGE', $language, PDO::PARAM_STR);
        $stmt->bindParam(':NODE_ID', intval($node_id), PDO::PARAM_INT);
        $stmt->bindParam(':SEARCH_KEYWORD', $search_keyword, PDO::PARAM_STR);
        $stmt->bindParam(':OFFSET', $offset , PDO::PARAM_INT);
        $stmt->bindParam(':PAGE_SIZE', intval($page_size), PDO::PARAM_INT);

        $stmt->execute();

        // execute the stored procedure
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $json->nodes = $results;
        $json->children_count = count($results);


        echo json_encode($json);

      } catch(PDOException $e) {

        echo "Connection failed: " . $e->getMessage();
        
      }
?>