<?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true){?>

    <?php echo validation_errors('<div class="alert alert-danger">','</div>');?>
    <?php if(isset($flash)){
        echo $flash;
    }?>
    <?php echo form_open(site_url('Login/updatePassword'),'class="form-signup"');?>
    <h2 class="form-signup-heading">Update Password</h2>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <label for="inputCPassword" class="sr-only">Confirm Password</label>
    <input type="password" name="cpassword" id="inputCPassword" class="form-control" placeholder="Confirm Password"
           required>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Update</button>
    <a class="btn btn-lg btn-default btn-block" href="<?php echo site_url('Login/profile')?>" role="button">back</a>
    <?php echo form_close();?>
<?php }else{
    redirect(site_url('Login/loginForm'));
}?>

