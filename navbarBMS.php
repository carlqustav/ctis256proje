    <nav class="blue-grey darken-1">
        <div class="nav-wrapper">
            <a href="?page=bookmark&category=All&sort=created" class="brand-logo left"><i class="material-icons">home</i>BMS</a>
            <ul id="nav-mobile" class="right blue-grey darken-3">
                <a href="?page=logout">
                    <li><i class="material-icons">keyboard_return</i></li>
                    <li>Logout</li>
                </a>
            </ul>
            <ul id="nav-mobile" class="right blue-grey darken-3">
                <a class='modal-trigger' href='#modalEditUser'>
                    <li class="user-picture" style="height:64px;"><img style="width:50px;height:50px;margin:7px 10px 0 0" src="upload/<?=$_SESSION["user"]["profile"]?>" alt="" class="circle center-align"></li>
                    <li><?= $_SESSION["user"]["name"] ?></li>
                </a>
            </ul>
            <ul id="nav-mobile" class="right blue-grey darken-3">
                <a id="notification-btn" class="dropdown-trigger" href="#" data-target="dropdown1">
                    <li><i class="material-icons">notifications</i></li>
                    <li id="notnumber"><span class="new badge"></span></li>
                </a>
            </ul>
            <ul id='dropdown1' class='dropdown-content' style="width: 300px !important">
            </ul>
        </div>
    </nav>