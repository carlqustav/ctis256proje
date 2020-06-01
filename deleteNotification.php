<?php
    require "db.php" ;
    sleep(5);
    try {
        $stmt = $db->prepare("truncate table share") ;
        $stmt->execute() ;
    } catch(PDOException $ex) {
        var_dump($ex);
        echo json_encode(["status" => "error", "message" => "Query syntax error"]) ;
    }
    
    // Redirection
    //header("Location: index.php?page=main") ; // reloading main page.
    //exit;
?>