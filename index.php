<?php
    session_start();

    $page = $_GET["page"] ?? "home";
    if(isset($_SESSION["user"]) && $page != "loginForm" && $page != "delete" && $page != "deleteNotification" && $page != "getNotification" && $page != "share" && $page != "logout" && $page != "addBMSNotification")
        $page = "bookmark";
    $web_routes = ["login","logout","delete","share","getNotification","deleteNotification","addBMSNotification"];
    if (in_array($page, $web_routes)) {
        require "$page.php";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aytuğ Berk Şengül</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="style.css"> 

    <script src="jquery-3.5.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
    @media only screen and (max-width: 601px){
        li.user-picture{
            height:56px!important;
        }

        li.user-picture img{
            width:40px!important;
            height:40px!important;
        }
    }
    table.highlight>tbody>tr:hover {
        background-color: rgb(114, 140, 152);
        color:white;     
    }
    table.highlight>tbody>tr:hover .actions{
        color: rgb(54, 80, 92);    
    }
    table.highlight>tbody>tr{
        color: rgb(54, 80, 92); 
    }
    </style>
</head>
</head>
<body>
    <?php
        $routes = ["loginForm","bookmark"];

        if ($page !== "bookmark") {
            require "navbar.php";
        } else { 
            require "navbarBMS.php";
        }

        if ($page === "home") {
            require "projectdesc.php";
        } else if (in_array($page, $routes)) {
            require "$page.php";
        }else{
            require "not_found.php";
        }
    ?>
</body>
</html>