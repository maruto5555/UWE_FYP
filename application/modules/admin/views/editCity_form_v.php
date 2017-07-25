<ul class="breadcrumb">
    <li><a href="<?php echo site_url('admin/countryList');?>">Country</a></li>
    <li class="active">City</li>
</ul>
<?php $row=$records->row();?>
<?php if(isset($flash)){
    echo $flash;
}?>
<?php echo form_open(base_url('index.php/admin/editCity/'.$cityId),'class="form-signin"');?>
    <div class="form-group">
        <label for="name">City Name:</label>
        <input type="text" class="form-control" id="cityName" name="cityName" value="<?php echo $row->cityName;?>">
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">Submit</button>
<?php echo form_close();?>