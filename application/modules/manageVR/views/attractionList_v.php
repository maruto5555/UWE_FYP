
<?php if(isset($flash)){
    echo $flash;
}?>

<?php if ($records != false) { ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>tourism attraction id</th>
                <th>place name</th>
                <th>place id</th>
                <th>city id</th>
                <th>lat</th>
                <th>lng</th>
                <th>image link</th>
                <th>control option</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($records->result() as $row) { ?>
                <tr>
                    <td> <?php echo $row->taId; ?></td>
                    <td> <?php echo $row->placeName; ?></td>
                    <td><?php echo $row->place_id; ?></td>
                    <td><?php echo $row->city_id; ?></td>
                    <td><?php echo $row->lat; ?></td>
                    <td><?php echo $row->lng; ?></td>
                    <td><?php echo $row->image; ?></td>
                    <td><a href="<?php echo site_url('manageVR/addVRResource/'.$row->taId);?>" class="btn btn-info"  role="button">Add VR Resource</a>
                        <a href="<?php echo base_url('index.php/admin/editAttraction/' . $row->taId); ?>" class="btn btn-info"
                           role="button"><span class="glyphicon glyphicon-pencil"></span></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="pagination">  <?php echo $link; ?></div>
<?php } else { ?>
    <p>No content found</p>
<?php } ?>