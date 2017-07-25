<?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true){?>

    <?php echo validation_errors('<div class="alert alert-danger">','</div>');?>
    <?php if(isset($flash)){
        echo $flash;
    }?>
    <?php $rows = $profile->row();?>
    <?php echo form_open_multipart(site_url('Login/updateProfile'),'class="form-signup"');?>
    <h2 class="form-signup-heading">Update Profile</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email"id="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $rows->email; ?>"required autofocus>
    <label for="inputUsername" class="sr-only">Username</label>
    <input type="text" name="username"id="inputUsername" class="form-control" placeholder="Username" value="<?php echo $rows->username; ?>"required>
    <label for="inputFirstname" class="sr-only">First name</label>
    <input type="text" name="firstname"id="inputFirstname" class="form-control" placeholder="First name" value="<?php echo $rows->firstname; ?>"required>
    <label for="inputLastname" class="sr-only">Last name</label>
    <input type="text" name="lastname"id="inputLastname" class="form-control" placeholder="Last name" value="<?php echo $rows->lastname; ?>"required>
    <label for="inputGender" class="sr-only">Gender</label>
    <label class="radio-inline">
        <input type="radio" name="gender" id="inlineRadio1" value="Male" <?php if($rows->gender=="Male"){echo 'checked';}?>> Male
    </label>
    <label class="radio-inline">
        <input type="radio" name="gender" id="inlineRadio2" value="Female"<?php if($rows->gender=="Female"){echo 'checked';}?>> Female
    </label>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Update</button>
    <a class="btn btn-lg btn-default btn-block" href="<?php echo site_url('Login/profile')?>" role="button">back</a>
    <?php echo form_close();?>

<?php }else{
    redirect(site_url('Login/loginForm'));
}?>
