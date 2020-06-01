<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once "db.php";
        //au
        $userEmail = $_POST["emailLogin"];
        $userPassword = $_POST["passwordLogin"];

        $stmt = $db->prepare("select * from user where user.email = ?");
        $stmt->execute([$userEmail]); 

        if($stmt->rowCount() == 1){
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($userPassword,$user["password"])){
                
                $_SESSION["user"]= $user;
                header("Location: ?page=bookmark");
                exit;
            }
        }
        header("Location: ?page=loginForm");
        exit;
    }
?>