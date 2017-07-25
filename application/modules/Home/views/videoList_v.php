<?php if ($records != false) { ?>
    <?php
    $total = $records->num_rows();
    $countRecord = 0; //use to loop item record
    $stopNum = 4;//one row have four items
    $rowNum = ceil($total / 4); //row number
    ?>
    <?php if (isset($flash)) {
        echo $flash;
    } ?>
    <?php for ($j = 0; $j < $rowNum; $j++) { ?>

        <div class="row">
            <?php if ($total - $countRecord >= 4) {
                $stopNum = 4;
            } else {
                $stopNum = $total - $countRecord;
            } ?>
            <?php for ($i = 0; $i < $stopNum; $i++) { ?>
                <?php $rows = $records->row($countRecord); ?>
                <div class="col-sm-3">
                    <p><?php echo $rows->name; ?></p>
                    <a href="<?php echo base_url(); ?>index.php/Home/video/<?php echo $rows->iid; ?>"
                       target="_blank"> <img
                                src="<?php echo $rows->thumbnail; ?>" class="img-thumbnail"
                                style="width:100%" alt="Image"></a>
                </div>
                <?php $countRecord++; ?>
            <?php } ?>
        </div><br>


    <?php } ?>

<?php } ?>