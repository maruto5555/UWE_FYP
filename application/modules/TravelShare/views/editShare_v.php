
<?php $rows = $records->row(); ?>
<?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true&&$rows->uid==$_SESSION['uid']){?>

        <?php echo validation_errors('<div class="alert alert-danger">','</div>');?>
        <?php if(isset($flash)){
            echo $flash;
        }?>
        <?php echo form_open(base_url('index.php/TravelShare/editShare/'.$rows->tid));?>
        <input type="text" class="form-control" id="usr" name="title" value="<?php echo $rows->title; ?> " required autofocus>
        <textarea class="form-control" rows="5" id="text_content" name="text_content"><?php echo $rows->content; ?></textarea>
        <input type="hidden" value="<?php echo $rows->tid; ?>" name="tid">
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Update</button>
        <?php echo form_close();?>
    <script>tinymce.init({ selector:'textarea' });</script>
<?php }else {redirect(base_url('index.php/Home'));}?>