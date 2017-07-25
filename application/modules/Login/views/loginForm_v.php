<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true) {
    redirect(site_url('Login/profile'));
    ?>
<?php } else { ?>

    <?php if (isset($flash)) {
        echo $flash;
    } ?>
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?php echo form_open(site_url('Login/loginForm'), 'class="form-signin"'); ?>
    <h2 class="form-signin-heading">Please sign in</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address"
           value="<?php echo set_value('email'); ?>" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Sign in</button>
    <?php echo form_close(); ?>

<?php } ?>
