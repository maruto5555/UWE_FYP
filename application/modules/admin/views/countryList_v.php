<ul class="breadcrumb">
    <li class="active">Country</li>

</ul>
<?php if (isset($flash)) {
    echo $flash;
} ?>
<a href="<?php echo base_url('index.php/admin/insertCountry/'); ?>" class="btn btn-info" role="button">Add
    country</a>
<?php if ($records != false) { ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Country Name</th>
                <th>control option</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($records->result() as $row) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url('index.php/admin/cityList/' . $row->countryId); ?>"><span style="color:red"><u><?php echo $row->countryName; ?></u></span></a>
                    </td>
                    <td><a href="<?php echo base_url('index.php/admin/insertCity/' . $row->countryId); ?>"
                           class="btn btn-info" role="button"><span class="glyphicon glyphicon-plus"></span> Add
                            City</a>
                        <a href="<?php echo base_url('index.php/admin/editCountry/' . $row->countryId . '/'); ?>"
                           class="btn btn-info" role="button"><span class="glyphicon glyphicon-pencil"></span></a>

                        <button type='button' data-toggle='modal' class='btn btn-danger' data-target='#myModal'
                                value='<?php echo $row->countryId; ?>'><span
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
                var countryId=data;
                window.location.assign("<?php echo site_url('admin/deleteCountry/');?>"+countryId);
            });
        });
    </script>
<?php } else { ?>
    <p>No content found</p>
<?php } ?>