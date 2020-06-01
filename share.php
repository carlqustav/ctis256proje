<?php
    require "db.php" ;

    $did = $_GET["did"] ?? ""; 
    $oid = $_GET["oid"] ?? ""; 
    try {
        $stmt = $db->prepare("insert into share (bm_id, own_id) values ($did, $oid)") ;
        $stmt->execute() ;
        if ( $stmt->rowCount() > 0) {
            echo json_encode(["status" => "ok", "message" => "$did bookmark shared."]) ;
        } else {
            echo json_encode(["status" => "error", "message" => "id is missing or invalid"]) ;
        }
    } catch(PDOException $ex) {
        
        var_dump($ex);
        echo json_encode(["status" => "error", "message" => "Query syntax error"]) ;
    }
  
    // Redirection
    //header("Location: index.php?page=main") ; // reloading main page.
    //exit;
?>