<div class="dark-books-bkg">
    <div class="register container">
        <div>
            <img class="logo-block" src="view/images/admin-logo.png" alt="My Books" />
            <form class="user-info-form" id="register-form" method="post" action="?controller=users&action=register" data-parsley-validate>
                <legend>Register</legend>
                <?php
                if ( isset($_SESSION['error']) ) { ?>
                    <div class="error">
                        <p><?php echo $_SESSION['error']; ?></p>
                    </div>
                <?php
                    unset($_SESSION['error']);
                }
                ?>
                <div class="row input-row">
                    <div class="input-group col-md-6">
                        <span class="input-icon"><img src="view/images/user.png" alt=""></span>
                        <input type="text" name="firstName" value="" placeholder="First name" required>
                    </div>
                    <div class="input-group col-md-6">
                        <span class="input-icon"><img src="view/images/user.png" alt=""></span>
                        <input type="text" name="lastName" value="" placeholder="Last name" required>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="input-group col-md-6">
                        <span class="input-icon"><img src="view/images/user.png" alt=""></span>
                        <input type="text" name="userName" value="" placeholder="Username" required>
                    </div>
                    <div class="input-group col-md-6">
                        <span class="input-icon"><img src="view/images/email.png" alt=""></span>
                        <input type="email" name="email" value="" placeholder="Email" required>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="input-group col-md-6">
                        <span class="input-icon"><img src="view/images/password.png" alt=""></span>
                        <input  type="password" name="password" value="" id="password" placeholder="Password" minlength="8" required >
                    </div>
                    <div class="input-group col-md-6">
                        <span class="input-icon"><img src="view/images/password.png" alt=""></span>
                        <input  type="password" name="confirmpassword" value="" placeholder="Confirm password" data-parsley-equalto="#password"	required>
                    </div>
                </div>

                <div class="row input-row">
                    <div class="col-6 reg-btn-col">
                        <input class="btn-round solid-btn btn user-btn" type="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-6 log-btn-col">
                        <a class="btn-round btn user-btn" href="?controller=users&action=login"><span>Login</span></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
