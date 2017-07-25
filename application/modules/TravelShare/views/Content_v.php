
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/example.css">
    <?php if(isset($flash)){
        echo $flash;
    }?>
    <div class="table-responsive">
        <?php $rows = $records->row(); ?>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td rowspan="2">
                    <div class="icon">
                        <img height="36" width="50" class="img-rounded"
                             src="<?php echo $rows->uicon; ?>">
                    </div>
                    <div class="username">
                        <?php echo $rows->username; ?>
                    </div>
                </td>
                <td>
                    <b><?php echo $rows->title; ?></b></td>

            </tr>
            <tr>
                <td>
                    <div class="datetime">
                        <p><i>issued at <?php echo $rows->datetime; ?></i></p>
                    </div>
                    <div class="content">
                        <?php echo $rows->content; ?>
                    </div>
                    <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true && $rows->uid == $_SESSION['uid']) { ?>
                        <div class="edit">
                            <a href="<?php echo base_url('index.php/TravelShare/editShare/' . $rows->tid) ?>">Edit</a>
                            <a href="#" data-toggle="modal" data-target="#myModal">Delete</a>
                        </div>
                    <?php } ?>
                    <?php if ($rows->editedTime != NULL) { ?>
                        <div class="editdTime">
                            <p><i>Edited at <?php echo $rows->editedTime; ?></i></p>
                        </div>
                    <?php } ?>

                </td>
            </tr>
            </tbody>
        </table>
    </div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Do you sure to delete?</p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url('index.php/TravelShare/deleteShareProcess/' . $rows->tid); ?>"
                   class="btn btn-danger" role="button">Delete</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
    <div class="cmt-container">
        <?php if ($comments != false) { ?>
            <?php foreach ($comments->result() as $row) {
                $name = $row->name;
                $email = $row->email;
                $comment = $row->comment;
                $date = $row->date;

                // Get gravatar Image
                // https://fr.gravatar.com/site/implement/images/php/

                $default = "mm";
                $size = 35;
                $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . $default . "&s=" . $size;
                ?>
                <div class="cmt-cnt">
                    <img src="<?php echo $grav_url; ?>"/>
                    <div class="thecom">
                        <h5><?php echo $name; ?></h5><span data-utime="1371248446"
                                                           class="com-dt"><?php echo $date; ?></span>
                        <br/>
                        <p>
                            <?php echo $comment; ?>
                        </p>
                    </div>
                </div><!-- end "cmt-cnt" -->
            <?php } ?>
        <?php } ?>
        <div class="new-com-bt">
            <span>Write a comment ...</span>
        </div>
        <div class="new-com-cnt">

            <input type="text" id="name-com" name="name-com" value="" placeholder="Your name"/>
            <input type="text" id="mail-com" name="mail-com" value="" placeholder="Your e-mail adress"/>
            <textarea class="the-new-com" name="new-com"></textarea>
            <input type="hidden" name="id_post" value="<?php echo $tid; ?>"/>

            <div class="bt-add-com">Post comment</div>
            <div class="bt-cancel-com">Cancel</div>

        </div>
        <div class="clear"></div>
    </div>


    <script type="text/javascript">
        $(function () {
            //alert(event.timeStamp);
            $('.new-com-bt').click(function (event) {
                $(this).hide();
                $('.new-com-cnt').show();
                $('#name-com').focus();
            });

            /* when start writing the comment activate the "add" button */
            $('.the-new-com').bind('input propertychange', function () {
                $(".bt-add-com").css({opacity: 0.6});
                var checklength = $(this).val().length;
                if (checklength) {
                    $(".bt-add-com").css({opacity: 1});
                }
            });

            /* on clic  on the cancel button */
            $('.bt-cancel-com').click(function () {
                $('.the-new-com').val('');
                $('.new-com-cnt').fadeOut('fast', function () {
                    $('.new-com-bt').fadeIn('fast');
                });
            });

            // on post comment click
            $('.bt-add-com').click(function () {
                var theCom = $('.the-new-com');
                var theName = $('#name-com');
                var theMail = $('#mail-com');

                if (!theCom.val()) {
                    alert('You need to write a comment!');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Home/addComment');?>",
                        data: {
                            act: 'add-com',
                            id_post:'<?php echo $tid; ?>',
                            name: theName.val(),
                            email: theMail.val(),
                            comment: theCom.val()
                        },
                        success: function (html) {
                            theCom.val('');
                            theMail.val('');
                            theName.val('');
                            $('.new-com-cnt').hide('fast', function () {
                                $('.new-com-bt').show('fast');
                                $('.new-com-bt').before(html);
                            })
                        }
                    });
                }
            });

        });
    </script>