<?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true){?>

    <?php echo validation_errors('<div class="alert alert-danger">','</div>');?>
    <?php
    if (isset($error)) {
        echo $error;
    }
    if(isset($flash)){
        echo $flash;
    }?>
    <?php echo form_open_multipart(site_url('Login/updateIcon'), 'class="form-signup"'); ?>
    <h2 class="form-signup-heading">Update User Icon</h2>
    <h1>User Icon</h1>
    <input type="file" name="userfile" size="20" required/>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Update</button>
    <a class="btn btn-lg btn-default btn-block" href="<?php echo base_url('index.php/Login/profile')?>" role="button">back</a>
    <?php echo form_close();?>
<?php }else{
    redirect(site_url('Login/loginForm'));
}?>
