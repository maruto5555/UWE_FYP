<?php if(isset($flash)){
    echo $flash;
}?>
<table id="datatable" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th>VR source</th>
        <th>VR thumbnail</th>
        <th>Category</th>
        <th>Control</th>
    </tr>
    </thead>


    <tbody>
    <?php if ($records != false) { ?>
        <?php foreach ($records->result() as $row) { ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->source; ?></td>
                <td><?php echo $row->thumbnail; ?></td>
                <td><?php if ($row->category == 0) {
                        echo 'image';
                    } else {
                        echo 'video';
                    } ?></td>
                <td>
                    <button type='button' data-toggle='modal' class='btn btn-danger' data-target='#myModal'
                            value='<?php echo $row->iid; ?>'><span
                                class="glyphicon glyphicon-remove"></span></button>

                </td>
            </tr>
        <?php } ?>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" name='Delete' data-dismiss="modal">Delete</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?php } ?>
    </tbody>
</table>
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
            var iid=$(this).val();
            window.location.assign("<?php echo site_url('viewVR/deleteVR/');?>"+iid);
        });
    });
</script>