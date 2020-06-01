<?php
//check if user logged in
if(!isset($_SESSION["user"])){
    header("Location: ?page=loginForm");
    exit;
}

if(!isset($_GET["pnumber"])){
    $pnumber = $_SESSION["pnumber"] ?? 1;
}
else{
    $pnumber = $_GET["pnumber"];
    if(!isset($_POST["search"])){
        $_SESSION["pnumber"] = $pnumber;
    }
}

if(!isset($_GET["category"])){
    $category = $_SESSION["category"] ?? "All";
}
else{
    $category = $_GET["category"];
    $pnumber = 1;
    $_SESSION["category"] = $category;
}

require_once "db.php";

define("BMSIZE",7);
$listSize = 0;

$newBM = false;

//edit user
if(isset($_POST["btnEditUser"])){
    extract($_POST);

    $sql = "update user set name='$name', email='$email' ";

    if($password != ""){
        $password = password_hash($password ,PASSWORD_DEFAULT);
        $sql .= ", password='$password' ";
    }
    if($date != ""){
        $sql .= ", bday='$date' ";
    }
    if(isset($_FILES)){
        $filename = $_FILES["picture"]["name"];
        $image = $_FILES['picture']['tmp_name'];

        $extesion = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
        $whitelist = ["gif","jpg","png","jpeg","bmp"];
        $uniq = uniqid();
        $filename = sha1($filename.$uniq)."_".$filename;
        if(move_uploaded_file($image,"upload/".$filename) && in_array($extesion,$whitelist)){
            $_SESSION["user"]["profile"] = $filename;
            $sql .= ", profile='$filename' ";
        }
    }
    $sql .= " where id=$btnEditUser";
    try{
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }
}

//edit
if(isset($_POST["btnEditBM"])){
    extract($_POST);
    $bm = ["title"=>$title,"url"=>$url,"note"=>$note,"owner"=>$owner,"categoryName"=>$categoryName];

    $sql = "update bookmark set title=:title, url=:url, note=:note, owner=:owner, category=:categoryName where id=$btnEditBM";
    try{
        $stmt = $db->prepare($sql);
        $stmt->execute($bm);
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }
}

//insert
if(isset($_POST["btnAdd"])){
    $newBM = true;
    extract($_POST);
    $bm = ["title"=>$title,"url"=>$url,"note"=>$note,"id"=>$btnAdd,"categoryName"=>$categoryName];
    $sql = "insert into bookmark (title, url, note, owner, category) values (:title, :url, :note, :id, :categoryName)";
    try{
        $stmt = $db->prepare($sql);
        $stmt->execute($bm);
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
        echo ">ZA";
    }
}
else if(isset($_POST["btnAddCategory"])){
    $cName = $_POST["name"];
    $newCategory = ["name"=>$cName];
    $sql = "insert into category (name) values (:name)";
    try{
        $stmt = $db->prepare($sql);
        $stmt->execute($newCategory);
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }
}

//delete category
if(isset($_POST["btnDeleteCategory"]) && $category !== "All"){
    $deleteCategoryName = $_POST["btnDeleteCategory"];
    $sql = "delete from category where name = :name";
    $stmt = $db->prepare($sql);
    $stmt->execute(["name" => $deleteCategoryName]);

    $category = "All";
}

//list
if($category === "All"){
    $sql = "select * from user,bookmark where bookmark.owner = {$_SESSION["user"]["id"]} and user.id = bookmark.owner ";
}
else{
    $sql = "select * from user,bookmark where bookmark.owner = {$_SESSION["user"]["id"]} and user.id = bookmark.owner and bookmark.category = '$category' ";
}
if(isset($_POST["search"])){
    $search = $_POST["search"];  
    $sql .= "and (title like '%$search%' or note like '%$search%') ";
}
if(isset($_GET["sort"])){
    $sort = $_GET["sort"];
    $_SESSION["sort"] = $sort;
}
else{
    $sort = $_SESSION["sort"] ?? "created";
}
if($sort == "name")
    $sql .= "order by user.$sort";
else
    $sql .= "order by bookmark.$sort";
try{
    $stmt = $db->query($sql);
    $listSize = $stmt->rowCount();
    $bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $ex){
    var_dump($ex);
}

//retrieving user names separately
$sqlUser = "select * from user";

try{
$stmt = $db->query($sqlUser);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $ex){}


//retrieving categories separately
$sqlCategory = "select * from category order by name asc";

try{
    $stmt = $db->query($sqlCategory);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $ex){}

?>
    <div class="container center">
    
    <!-- Search -->
    <div class="row center">
        <div class="col s8 offset-s2">
            <form action="?page=bookmark&pnumber=1&sort=created&category=All" method="post">
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <input type="text" name="search" id="search" placeholder="Search"/>
                </div>       
            </form> 
        </div>
    </div>
    
    <div class="container">
    <?php
    //category
    $categoryList = "<div class='row collection'>";

    if($category === "All"){
        $categoryList .= "<a href='?category=All' class='col s4 collection-item active'>All</a>";
    }
    else{
        $categoryList .= "<a href='?category=All' class='col s4 collection-item'>All</a>";
    }
    foreach($categories as $c){
        if($c["name"] === $category){
            $categoryList .= "<a href='?category={$c["name"]}' class='col s4 collection-item active'>{$c["name"]}</a>";
        }
        else{
            $categoryList .= "<a href='?category={$c["name"]}' class='col s4 collection-item'>{$c["name"]}</a>";
        }
    }   
    $categoryList .= "</div>";
    echo $categoryList;
    ?>
    </div>
        <!-- Category Buttons -->
        <div class="row">
            <div class="col s4 offset-s2">
                <form action='' method='post' style='display:inline;'>
                    <button class='btn blue-grey darken-1' type='submit' name='btnDeleteCategory' value='<?=$category?>'>
                        <i class='material-icons'>delete</i>Delete Current Category
                    </button>
                </form>
            </div>
            <div class="col s4">
            <a class='btn modal-trigger blue-grey darken-1' href='#modalAddCategory'>
                <i class='material-icons'>add</i>Add New Category
            </a>
            </div>
        </div>
        <div id="modalAddCategory" class="modal">
            <form method="post" action="">
                <div class="modal-content">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="categoryName" name="name" type="text" class="validate">
                            <label for="categoryName">Category Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="btnAddCategory">Add</button>
                </div>
            </form>
        </div>

    <?php
    $paginator = "";

    if($listSize > BMSIZE){
        $paginator = "<ul class='pagination'><li class=".(($pnumber != 1)? '' : 'disabled')."><a class='page-number' href=?pnumber=".(($pnumber ==1)?"".((int)$pnumber):"".((int)$pnumber -1))."><i class='material-icons'>chevron_left</i></a></li>";  
        for($i = 1; $i < $listSize/BMSIZE+1;$i++){
            $paginator.="<li class=" . (($pnumber == $i)? 'active' : 'waves-effect')."><a class='page-number' href=?pnumber=$i>$i</a></li>";
        }        
        $paginator .= "<li class=".(($pnumber  != (int)($listSize/BMSIZE)+1)? '' : 'disabled')."><a class='page-number' href=?pnumber=".(($pnumber==(int)($listSize/BMSIZE)+1)?"".((int)$pnumber):"".((int)$pnumber +1))."><i class='material-icons'>chevron_right</i></a></li></ul>";
    }
    echo $paginator;
    ?>
        <table class="highlight">
            <thead>
                <tr>
                    <th><a href="?sort=title" class="sort_table" data-sort="title">Title<?= ($sort == "title")?"&#x2c5;":""?></a></th>
                    <th><a href="?sort=note" class="sort_table" data-sort="note">Note<?= ($sort == "note")?"&#x2c5;":""?></a></th>
                    <th><a href="?sort=created" class="sort_table" data-sort="created">Date<?= ($sort == "created")?"&#x2c5;":""?></a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //toast messages
                    if($newBM){                 
                        echo "<script>$(document).ready(function(){
                            var t = '<span>Bookmark has been succesfully added!</span>'
                            M.toast({html: t, classes: 'orange rounded'})
                        });</script>";
                    }else if(isset($_POST["btnEditBM"])){
                        echo "<script>$(document).ready(function(){
                            var t = '<span>Bookmark has been succesfully edited!</span>'
                            M.toast({html: t, classes: 'orange rounded'})
                        });</script>";
                    }else if(isset($_POST["btnDeleteCategory"])){
                        echo "<script>$(document).ready(function(){
                            var t = '<span>Category has been succesfully deleted!</span>'
                            M.toast({html: t, classes: 'orange rounded'})
                        });</script>";
                    }else if(isset($_POST["btnAddCategory"])){
                        echo "<script>$(document).ready(function(){
                            var t = '<span>Category has been succesfully added!</span>'
                            M.toast({html: t, classes: 'orange rounded'})
                        });</script>";
                    }
                    $index = 0; //modal id index
                    $minI = ($pnumber-1)*BMSIZE; //pagination index
                    $maxI = $minI + BMSIZE;//pagination limit
                    foreach($bookmarks as $bm){
                        if($index >= $minI && $index < $maxI){
                            $date = date_format(new DateTime($bm["created"]),'d M y');
                            $row = "<tr id='row{$bm["id"]}'>
                                    <td>{$bm["title"]}</td>
                                    <td class='truncate'>{$bm["note"]}</td>
                                    <td>{$date}</td>
                                    <td class='actions'>
                                        <a href='{$bm["id"]}' class='bms-delete waves-effect waves-light btn pull-right blue-grey darken-1'><i class='material-icons'>delete</i></a>
                                        <a class='waves-effect waves-light btn modal-trigger pull-right blue-grey darken-1' href='#modal$index'><i class='material-icons'>
                                        visibility
                                        </i></a>
                                        <a class='waves-effect waves-light btn modal-trigger pull-right blue-grey darken-1 btnModalEditBM' href='#modalEditBM$index'><i class='material-icons'>
                                        create
                                        </i></a>
                                        <a href='{$bm["id"]}' data-o='{$bm["owner"]}' class='bms-share waves-effect waves-light btn pull-right blue-grey darken-1'><i class='material-icons'>
                                        share
                                        </i></a>
                                        <div id='modalEditBM$index' class='modal'>
                                            <div class='modal-content'>
                                            <form method='post' action=''>
                                                <h4>Edit Bookmark</h4>
                                                <div class='row'>
                                                    <div class='row'>
                                                        <div class='input-field col s12'>
                                                            <select class='browser-default' name='owner'>";           
                                                                foreach($users as $us){
                                                                    if($us["id"] === $bm["owner"]){
                                                                        $row .= "<option selected value='{$us["id"]}'>{$us["name"]}</option>";
                                                                    }
                                                                    else{
                                                                        $row .= "<option value='{$us["id"]}'>{$us["name"]}</option>";
                                                                    }   
                                                                }                         
                                                                $row .= "
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='input-field col s12'>
                                                            <select class='browser-default' name='categoryName'>";
                        
                                                                foreach($categories as $c){
                                                                    if($c["name"] === $bm["category"]){
                                                                        $row.= "<option selected value='{$c["name"]}'>{$c["name"]}</option>";
                                                                    }
                                                                    else{
                                                                        $row.= "<option value='{$c["name"]}'>{$c["name"]}</option>";
                                                                    }    
                                                                }                         
                                                                $row.="
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='input-field col s12'>
                                                            <input value='{$bm['title']}'' id='title' name='title' type='text' class='validate'>
                                                            <label for='title'>Title</label>
                                                        </div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='input-field col s12'>
                                                            <input value='{$bm['url']}' id='url' name='url' type='text' class='validate'>
                                                            <label for='url'>URL</label>
                                                        </div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='input-field col s12'>
                                                            <input value='{$bm['note']}' id='note' name='note' type='text' class='validate'>
                                                            <label for='note'>Notes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <button class='btn waves-effect waves-light blue-grey darken-1' type='submit' name='btnEditBM' value='{$bm["id"]}'>Edit</button>
                                            </div>
                                            </form>
                                        </div>
                                        <div id='modal$index' class='modal'>
                                        <div class='modal-content'>
                                            <p>Owner : {$bm["name"]}</p>
                                            <p class='divider'></p>";
                                            if($category === "All")
                                                $row .= "<p>Category : {$bm["category"]}</p>
                                                <p class='divider'></p>";
                                            $row .= "
                                            <p>Title : {$bm["title"]}</p>
                                            <p class='divider'></p>
                                            <p>Note : {$bm["note"]}</p>
                                            <p class='divider'></p>
                                            <p>URL : {$bm["url"]}</p>
                                            <p class='divider'></p>
                                            <p>Date : {$bm["created"]}</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <a href='#!' class='modal-close waves-effect waves-green btn-flat'>Close</a>
                                        </div>
                                        </div>
                                    </td>
                                </tr>";
                        echo $row;
                        }    
                        $index++;
                    }
                ?>   
            </tbody>
        </table>
        <?php
        echo $paginator;
    ?>
    
    </div>
    
    <button data-target="modal" class="btn-floating modal-trigger" id="modalBtn"><i class="material-icons">add</i></button>
    <!-- Notification Modal-->
    <div id="modalNot" class="modal">
        <div class="modal-content modalNot-content">
        </div>
    </div>
    <!-- New Bookmark Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
        <form method="post" action="">
            <h4>New Bookmark</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12">
                        <select class="browser-default" name="categoryName">
                            <option value="" disabled selected>Choose Category</option>
                            <?php                           
                            foreach($categories as $c){
                                echo "<option value='{$c["name"]}'>{$c["name"]}</option>";
                            }                         
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="title" name="title" type="text" class="validate">
                        <label for="title">Title</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="url" name="url" type="text" class="validate">
                        <label for="url">URL</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="note" name="note" type="text" class="validate">
                        <label for="note">Notes</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="btnAdd" value="<?=$_SESSION["user"]["id"]?>">Add</button>
        </div>
        </form>
    </div>

    <!-- Edit User Modal -->
    <?php
    $userInfo = $_SESSION["user"];
    ?>
    <div id="modalEditUser" class="modal">
        <div class="modal-content">
        <form method="post" action="" enctype="multipart/form-data">
            <h4>Edit User Information</h4>
            <div class="row">
                <div class="row">
                    <div class="input-field col s12">
                        <input value='<?=$userInfo["name"]?>' id="name" name="name" type="text" class="validate">
                        <label for="name">Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value='<?=$userInfo["email"]?>' id="email" name="email" type="text" class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" name="password" type="password" class="validate">
                        <label for="password">New Password</label>
                        <span class="helper-text">Password is changed only if you enter something here</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value='<?=$userInfo["bday"]?>' type="text" class="datepicker" name="date" id="date">
                        <label for="date">Birthday</label>
                    </div>
                </div>
                <div class="row">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" name='picture'>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="picturepath">
                    </div>
                    <span class="helper-text">Your changes will be applied when you re-login</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="btnEditUser" value="<?=$userInfo["id"]?>">Update</button>
        </div>
        </form>
        </div>
        <a data-id="<?=$_SESSION["user"]["id"]?>" id="user-id" style="display:none;"></a>
    <script>

        let nots;
        $(document).ready(function(){
            $('.modal').modal();
            $('.datepicker').datepicker();
            $('.dropdown-trigger').dropdown({constrainWidth: false , closeOnClick: false,coverTrigger:false});
            
            let id = $("#user-id").attr("data-id");

            $(".bms-delete").on("click",function(e){
                e.preventDefault();              
                let did = $(this).attr("href");
                console.log($(`#row${did}`));
                $.get("index.php",
                    {"page":"delete","did":did},
                    function(data){
                        console.log(data);
                    },
                    "json"
                );
                $(`#row${did}`).remove();
                var t = '<span>Bookmark has been succesfully deleted!</span>'
                M.toast({html: t, classes: 'orange rounded'})

            });

            $(".bms-share").on("click",function(e){      
                e.preventDefault();              
                let did = $(this).attr("href");
                let oid = $(this).attr("data-o");
                $.get("index.php",
                    {"page":"share","did":did,"oid":oid},
                    function(data){
                        console.log(data);
                    },
                    "json"
                );
                var t = '<span>Bookmark has been succesfully shared!</span>'
                M.toast({html: t, classes: 'orange rounded'})
            });

            //delete notification when clicked on
            $("#notification-btn").on("click",function(e){
                $.get("index.php",
                    {"page":"deleteNotification"},
                    function(data){
                        $("#notnumber").hide();
                    },
                    "json"
                );
            });

            //get notification
            $.get("index.php",
                    {"page":"getNotification","id":id},
                    function(data){
                        nots = data;
                        if(nots["status"] === "nothing"){
                            $("#notification-btn").hide();
                            $("#notnumber").hide();
                        }
                        else{
                            $("#notnumber").show();    
                            $("#notification-btn").show();                       
                            $("#notnumber span").html(nots.length);
                            for(i = 0; i < nots.length; i++){
                                console.log(nots[i]);
                                var dropdownItem = $(`<li data-title='${nots[i]["title"]}' data-url='${nots[i]["url"]}'
                                 data-note='${nots[i]["note"]}' data-owner='${nots[i]["owner"]}' data-category='${nots[i]["category"]}'><a href='#' class='osman'>${nots[i]["title"]}</a></li><br>`)
                                    .appendTo($(".dropdown-content"))
                                    .on("click",function(e){//add bm to user from notification event
                                        e.preventDefault();
                                        let title = $(this).attr("data-title");
                                        let url = $(this).attr("data-url");
                                        let note = $(this).attr("data-note");
                                        let category = $(this).attr("data-category");
                                        console.log(title + " ");
                                        $.get("index.php",
                                            {"page":"addBMSNotification",
                                                "title":title,
                                                "url":url,
                                                "note":note,
                                                "owner":id,
                                                "category":category},
                                            function(data){
                                                $("#notnumber").hide();
                                            },
                                            "json"
                                        );
                                    });
                            }
                        }
                    },
                    "json"
                );
            setInterval(() => {
                $.get("index.php",
                    {"page":"getNotification","id":id},
                    function(data){
                        nots = data;
                        if(nots["status"] === "nothing"){
                            $("#notification-btn").hide();
                            $("#notnumber").hide();
                        }
                        else{
                            $("#notnumber").show();    
                            $("#notification-btn").show();                       
                            $("#notnumber span").html(nots.length);
                            for(i = 0; i < nots.length; i++){
                                console.log(nots[i]);
                                var dropdownItem = $(`<li data-title='${nots[i]["title"]}' data-url='${nots[i]["url"]}'
                                 data-note='${nots[i]["note"]}' data-owner='${nots[i]["owner"]}' data-category='${nots[i]["category"]}'><a href='#' class='osman'>${nots[i]["title"]}</a></li><br>`)
                                    .appendTo($(".dropdown-content"))
                                    .on("click",function(e){//add bm to user from notification event
                                        e.preventDefault();
                                        let title = $(this).attr("data-title");
                                        let url = $(this).attr("data-url");
                                        let note = $(this).attr("data-note");
                                        let category = $(this).attr("data-category");
                                        console.log(title + " ");
                                        $.get("index.php",
                                            {"page":"addBMSNotification",
                                                "title":title,
                                                "url":url,
                                                "note":note,
                                                "owner":id,
                                                "category":category},
                                            function(data){
                                                $("#notnumber").hide();
                                            },
                                            "json"
                                        );
                                    });
                            }
                        }
                    },
                    "json"
                );
            }, 5000);            
        });
    </script>