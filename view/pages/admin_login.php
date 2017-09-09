<div class="dark-books-bkg">
    <div class="admin-login">
        <div>
            <img class="logo-block" src="view/images/admin-logo.png" alt="My Books" />
            <form class="user-info-form" id="admin-login-form" action="?controller=users&action=login" method="post" data-parsley-validate>
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
                 <div class="input-group">
                     <span class="input-icon"><img src="view/images/user.png" alt=""></span>
                     <input type="text" name="userName" value="" placeholder="Username" required>
                 </div>
                 <div class="input-group">
                     <span class="input-icon"><img src="view/images/password.png" alt=""></span>
                     <input type="password" name="password" value="" placeholder="Password" required>
                 </div>

                 <div class=" row login-btn-row input-row">
                     <div class="col-6">
                         <input class="btn-round solid-btn btn user-btn log-btn" type="submit" value="Submit" name="submit">
                     </div>
                     <div class="col-6">
                         <a class="btn-round btn user-btn reg-btn" href="?controller=users&action=register"><span>Register</span></a>
                     </div>
                 </div>
            </form>
        </div>
    </div>
</div>
