<link href="<?php echo base_url('vrview/examples/style.css');?>" rel="stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/example.css">
<?php if ($records != false) { ?>

<div id="vrview"></div>
<div id="controls">
    <div id="toggleplay" class="paused"></div>
    <div id="togglemute"></div>
</div>
    <div class="cmt-container">
        <?php $id_post = $this->uri->segment(3); //the post or the page id?>
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
            <input type="hidden" name="id_post" value="<?php echo $id_post; ?>"/>

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
                    url: "<?php echo base_url();?>index.php/Home/addComment",
                    data: {
                        act: 'add-com',
                        id_post:'<?php echo $id_post; ?>',
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

<script>
    var vrView;
    var playButton;
    var muteButton;
    function onLoad() {
        <?php $rows = $records->row(); ?>
        // Load VR View.
        vrView = new VRView.Player('#vrview', {
            width: '100%',
            height: 480,
            video: '<?php echo $rows->source;?>',
            is_stereo: true
            //is_debug: true,
            //default_heading: 90,
            //is_yaw_only: true,
            //is_vr_off: true,
        });
        vrView.on('ready', onVRViewReady);

        playButton = document.querySelector('#toggleplay');
        muteButton = document.querySelector('#togglemute');

        playButton.addEventListener('click', onTogglePlay);
        muteButton.addEventListener('click', onToggleMute);
    }
    window.addEventListener('load', onLoad);
</script>
<script src="<?php echo base_url('vrview/build/vrview.js');?>"></script>
<script src="<?php echo base_url('js/video.js');?>"></script>
<?php }?>

