<?php $this->load->module('Template');
$this->template->drawBreadCrumbs($breadCrumbs_data);
?>
<?php if (isset($flash)) {
    echo $flash;
} ?>
    <a href="<?php echo base_url('index.php/admin/insertAttraction/' . $cityId); ?>" class="btn btn-info" role="button">Add
        Attraction</a>
<?php if ($records != false) { ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
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
            <?php foreach ($records->result() as $row) {
                $myJSON = array('taId' => $row->taId, 'cityId' => $row->city_id);
                ?>
                <tr>
                    <td> <?php echo $row->placeName; ?></td>
                    <td><?php echo $row->place_id; ?></td>
                    <td><?php echo $row->city_id; ?></td>
                    <td><?php echo $row->lat; ?></td>
                    <td><?php echo $row->lng; ?></td>
                    <td><?php echo $row->image; ?></td>
                    <td><a href="<?php echo site_url('manageVR/addVRResource/' . $row->taId); ?>" class="btn btn-info"
                           role="button">Add VR Resource</a> <a
                                href="<?php echo base_url('index.php/admin/editAttraction/'.$row->taId.'/'.$cityId); ?>"
                                class="btn btn-info"
                                role="button"><span class="glyphicon glyphicon-pencil"></span></a>
                        <button type='button' data-toggle='modal' class='btn btn-danger' data-target='#myModal'
                                value='<?php echo json_encode($myJSON); ?>'><span
                                    class="glyphicon glyphicon-remove"></span></button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete?</p>
                    </div>
                    <div class="modal-footer">


                        <button type="button" class="btn btn-danger" name='Delete' data-dismiss="modal">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="pagination">  <?php echo $link; ?></div>
    <script>
        $(document).ready(function () {
            $('#myModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);// Button that triggered the modal
                var dayData = button.val();
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-footer [name=Delete]').val(dayData);
            });
            $("[name=Delete]").click(function () {
                //alert($(this).val());
                var data=$(this).val();
                //alert(data);
                var JSON1=JSON.parse(data);
                var cityId=JSON1.cityId;
                var taId=JSON1.taId;
                window.location.assign("<?php echo site_url('admin/deleteAttraction/');?>"+taId+"/"+cityId);
            });
        });
    </script>
<?php } else { ?>
    <p>No content found</p>
<?php } ?>