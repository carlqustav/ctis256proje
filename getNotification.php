<?php
    require "db.php" ;
    $id = $_GET["id"];
    try {
        $stmt = $db->prepare("select * from share,bookmark where share.bm_id = bookmark.id and own_id != $id ") ;
        $stmt->execute() ;
        if ( $stmt->rowCount() > 0) {
            $notif = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($notif);
        } else {
            echo json_encode(["status" => "nothing"]) ;
        }
    } catch(PDOException $ex) {
        
        var_dump($ex);
        echo json_encode(["status" => "error", "message" => "Query syntax error"]) ;
    }
  
    // Redirection
    //header("Location: index.php?page=main") ; // reloading main page.
    //exit;
?>