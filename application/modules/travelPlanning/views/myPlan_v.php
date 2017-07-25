
    <?php if(isset($flash)){
        echo $flash;
    }?>
    <?php if ($records != false) { ?>
        <div class="row">
            <?php foreach ($records->result() as $row){?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Departure date <?php echo $row->startDate; ?><a href="<?php echo site_url('travelPlanning/getAllSelectedItem/'.$row->travelId);?>">View Plan</a>
                        <button type='button' data-toggle='modal' class='btn btn-link' data-target='#myModal'
                                value='<?php echo $row->travelId; ?>'>Delete Plan</button>
                    </div>
                    <div class="panel-body"><a
                                href="<?php echo site_url('travelPlanning/showAttractionForPlanning/' . $row->travelId); ?>" ><?php echo $row->travelName; ?></a>
                    </div>
                </div>
            </div>
            <?php }?>
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
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
                    var travelId=$(this).val();
                    window.location.assign("<?php echo site_url('travelPlanning/deleteTravel/');?>"+travelId);
                });
            });
        </script>
    <?php } else { ?>
        <p>No content found</p>
    <?php } ?>