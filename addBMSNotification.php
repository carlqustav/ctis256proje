<?php
    require "db.php" ;

    $bmid = $_GET["bmid"] ?? "";
    $title =  $_GET["title"] ?? "";
    $url =  $_GET["url"] ?? "";
    $note =  $_GET["note"] ?? "";
    $owner =  $_GET["owner"] ?? "";
    $category =  $_GET["category"] ?? "";

    try {
        $bm = ["title"=>$title,"url"=>$url,"note"=>$note,"owner"=>$owner,"category"=>$category];
        $sql = "insert into bookmark (title, url, note, owner, category) values (:title, :url, :note, :owner, :category)";
        $stmt = $db->prepare($sql);
        $stmt->execute($bm) ;
        if ( $stmt->rowCount() > 0) {
            echo json_encode(["status" => "ok", "message" => "helal."]) ;
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