<div class="dark-books-bkg">
    <div class="admin-login">
        <div>
            <img class="logo-block" src="view/images/admin-logo.png" alt="My Books" />
            <form id="admin-login-form" action="?controller=users&action=login" method="post">
                <legend>Admin login</legend>
                <?php
                GLOBAL $errorMsg;
                if ($errorMsg) {
                 ?>
                    <div class="error-msg">
                        <p><?php echo $errorMsg;?></p>
                    </div>
                <?php
                }
                 ?>
                <input type="text" name="userName" value="" placeholder="Username">
                <input type="password" name="password" value="" placeholder="Password">
                <input class="btn-round solid-btn btn" type="submit" value="Submit" name="submit">
                <a class="btn-round btn" href="?controller=users&action=register"><span>Register</span></a>
            </form>
        </div>
    </div>
</div>
