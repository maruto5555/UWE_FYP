<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true) {
    redirect(site_url('Login/profile'));
    ?>
<?php } else { ?>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?php
    if (isset($flash)) {
        echo $flash;
    }
    ?>
    <?php echo form_open(site_url('Login/signUpForm'), 'class="form-signup"'); ?>
    <h2 class="form-signup-heading">Please sign up</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address"
           value="<?php echo set_value('email'); ?>" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <label for="inputCPassword" class="sr-only">Confirm Password</label>
    <input type="password" name="cpassword" id="inputCPassword" class="form-control" placeholder="Confirm Password"
           required>
    <label for="inputUsername" class="sr-only">Username</label>
    <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username"
           value="<?php echo set_value('username'); ?>" required>
    <label for="inputFirstname" class="sr-only">First name</label>
    <input type="text" name="firstname" id="inputFirstname" class="form-control" placeholder="First name"
           value="<?php echo set_value('firstname'); ?>" required>
    <label for="inputLastname" class="sr-only">Last name</label>
    <input type="text" name="lastname" id="inputLastname" class="form-control" placeholder="Last name"
           value="<?php echo set_value('lastname'); ?>" required>
    <label for="inputGender" class="sr-only">Gender</label>
    <label class="radio-inline">
        <input type="radio" name="gender" id="inlineRadio1"
               value="Male" <?php echo set_radio('gender', 'Male', TRUE); ?>> Male
    </label>
    <label class="radio-inline">
        <input type="radio" name="gender" id="inlineRadio2"
               value="Female" <?php echo set_radio('myradio', 'Female'); ?>> Female
    </label>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Sign up</button>
    <?php echo form_close(); ?>

<?php } ?>
