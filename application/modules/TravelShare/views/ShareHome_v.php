
    <?php if(isset($flash)){
        echo $flash;
    }?>
    <div class="row">
    <div class="col-lg-6">
    <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true) { ?>
        <a href="<?php echo base_url('index.php/TravelShare/createShare'); ?>" class="btn btn-info" role="button">new
            share</a>
    <?php } ?>
    <form method="post" id="searchForm">
        <div class="input-group">
            <input type="text" class="form-control" id="search" name="inputSearch" placeholder="search travel share" required>
            <span class="input-group-btn">
    <button type="submit" id="submit" class="btn btn-default">Search</button>
          </span>
        </div>
    </form>
    </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#submit").click(function () {
                var keyword = $("#search").val();
                document.getElementById("submit").formAction = '<?php echo site_url('TravelShare/shareSearch/');?>' + keyword;
            });
        });
    </script>
    <?php if ($records != false) { ?>
        <div class="row">
            <?php foreach ($records->result() as $row){?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><img height="36" width="50" class="img-circle"
                                                    src="<?php echo $row->uicon; ?>"><?php echo $row->username; ?>
                    </div>
                    <div class="panel-body"><a
                                href="<?php echo base_url('index.php/TravelShare/travelShareContent/' . $row->tid); ?>"
                                target="_blank"><?php echo $row->title; ?></a></div>
                </div>
            </div>
            <?php }?>
        </div>


        <div id="pagination">  <?php echo $link; ?></div>

    <?php } else { ?>
        <p>No content found</p>
    <?php } ?>
