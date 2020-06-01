<?php
if(isset($_SESSION["user"])){
    header("Location: ?page=bookmark");
    exit;
}
?>
<div class="container center">
        <div class="row">
            <div class="input-field col s12 m6 offset-m3">
                <div class="divider"></div>
            </div>       
        </div>
        <form action="?page=login" method="post">
            <div class="row">
                <div class="input-field col s12 m6 offset-m3">
                    <i class="material-icons prefix">account_circle</i>
                    <input value="john@one.com" id="email" type="text" class="validate" name="emailLogin">
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="Email is empty or invalid"></span>
                </div>       
            </div>
            <div class="row">
                <div class="input-field col s12 m6 offset-m3">
                    <i class="material-icons prefix">vpn_key</i>
                    <input value="john" id="password" type="password" class="validate" name="passwordLogin">
                    <label for="password">Password</label>
                    <span class="helper-text" data-error="Wrong password"></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 offset-m3">
                    <button class="btn blue-grey darken-1" type="submit" name="btnLogin">Sign in</button>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 offset-m3">
                    <div class="divider"></div>
                </div>       
            </div>
        </form>
    </div>