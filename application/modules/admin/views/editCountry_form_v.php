<?php $row=$records->row();?>
<?php if(isset($flash)){
    echo $flash;
}?>
<?php echo form_open(base_url('index.php/admin/editCountry/'.$row->countryId),'class="form-signin"');?>
    <div class="form-group">
        <label for="name">Country Name:</label>
        <input type="text" class="form-control" id="countryName" name="editCountryName" value="<?php echo $row->countryName;?>">
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Submit</button>
<?php echo form_close();?>