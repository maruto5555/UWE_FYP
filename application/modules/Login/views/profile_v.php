<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true) { ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <?php $rows = $profile->row(); ?>
            <tbody>
            <tr>
                <td>Email</td>
                <td><?php echo $rows->email; ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><?php echo $rows->username; ?></td>
            </tr>
            <tr>
                <td>First name</td>
                <td><?php echo $rows->firstname; ?></td>
            </tr>
            <tr>
                <td>Last name</td>
                <td><?php echo $rows->lastname; ?></td>
            </tr>
            <tr>
                <td>gender</td>
                <td><?php echo $rows->gender; ?></td>
            </tr>
            <tr>
                <td>Icon</td>
                <td> <?php echo '<img height="300" width="300" src="' . $rows->uicon . '">'; ?></td>
            </tr>
            </tbody>
        </table>

        <a class="btn btn-default" href="<?php echo site_url('Login/updateProfile') ?>" role="button">Update
            profile</a>
        <a class="btn btn-default" href="<?php echo site_url('Login/updatePassword');?>" role="button">Update password</a>
        <a class="btn btn-default" href="<?php echo site_url('Login/updateIcon');?>" role="button">Update user icon</a>
    </div>

<?php } else {
    redirect(site_url('Login/loginForm'));
} ?>