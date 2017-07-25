

<?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true){?>
    <?php echo validation_errors('<div class="alert alert-danger">','</div>');?>
        <?php if(isset($flash)){
            echo $flash;
        }?>
    <?php echo form_open(base_url('index.php/TravelShare/createShare'));?>
<input type="text" class="form-control" id="usr" name="title" value="<?php echo set_value('text'); ?> " required autofocus>
<textarea class="form-control" rows="5" id="text_content" name="text_content" aria-label="editor"><?php echo set_value('text_content'); ?></textarea>
    <button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit" name="submit">Submit</button>
    <?php echo form_close();?>
    <script>tinymce.init({ selector:'textarea' });</script>
<?php }else {redirect(base_url('index.php/Login/loginForm'));}?>