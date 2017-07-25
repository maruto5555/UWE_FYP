<ul class="breadcrumb">
    <?php foreach ($breadCrumbs_array as $row =>$value){?>
    <li><a href="<?php echo $row;?>"><?php echo $value;?></a></li>
    <?php }?>
    <li class="active"><?php echo $current_page_title;?></li>
</ul>