
    <div id="msg"></div>
    <form>
        <div class="form-group">
            <label for="travelTitle">Title</label>
            <input type="text" name="travelTitle" id="travelTitle" class="form-control" placeholder="title"
                   value="<?php echo set_value('travelTitle'); ?>" required>
        </div>
        <div class="form-group">
            <label for="travelDate">travel departure date</label>
            <input type="date" name="travelDate" id="travelDate" class="form-control" placeholder="Date"
                   value="<?php echo set_value('travelDate'); ?>" required>
        </div>
        <div class="form-group">
            <label for="dayNum">Travel Day Number</label>
            <input type="number" name="dayNum" id="dayNum" min="1" max="20" placeholder="Day Number"
                   value="1" class="form-control" required>
        </div>
            <p><b>select a destination</b></p>
            <div class="well">

                <div class="row">
                    <?php foreach ($records->result() as $row){?>
                    <div class="col-md-3">
                        <div class="radio">
                            <label>
                                <input type="radio" name="selectCity"
                                       value="<?php echo $row->cityId; ?>" required>
                                <?php echo $row->cityName; ?>
                            </label>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="button" id="submit">Submit</button>
        </div>
    </form>
    <script>
        $(function () {
//            $("#travelDate").datepicker();
            $("#submit").click(function () {
                $.post("<?php echo site_url('travelPlanning/insertTravel/')?>", {
                    title: $("#travelTitle").val(),
                    travelDate: $("#travelDate").val(),
                    dayNum: $("#dayNum").val(),
                    city_id: $(":checked").val()
                }, function (data, statusTxt) {
                    if (statusTxt == "success") {
                        $("#msg").html(data);
                        $("#travelTitle").val('');
                        $("#travelDate").val('');
                        $("#dayNum").val('');
                        $(":checked").prop('checked', false);
                    } else {
                        $("#msg").html(data);
                    }
                })
            });
        });
    </script>