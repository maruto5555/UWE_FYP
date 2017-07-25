<?php if(isset($flash)){
    echo $flash;
}?>
<?php echo form_open_multipart(site_url('manageVR/addVRResource/'.$taId),'class="form-signin"');?>
<div class="form-group">
    <label for="name">File:</label>
    <input type="file" name="VRfile" size="20" />
    <label for="sel1">category:</label>
    <select class="form-control" id="sel1" name="category">
        <option value="0">Image</option>
        <option value="1">Video</option>
    </select>
</div>
<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Submit</button>
<?php echo form_close();?>

