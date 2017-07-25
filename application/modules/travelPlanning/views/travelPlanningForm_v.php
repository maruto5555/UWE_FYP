
<div id="msg"></div>
<?php if ($records != false) { ?>
    <div class="row">
        <?php $row1 = $records->row();
        ?>
        <div class="col-sm-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Travel Destination:<?php echo $row1->cityName; ?></h1></div>
                <div class="panel-body">
                    <ul class="list-group" id="dayNum">

                    </ul>
                </div>
            </div>

            <div class="modal fade" id="dayModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Delete</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to delete?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" name='dayDelete' data-dismiss="modal">Delete
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <button type="button" id="AddDay" class="btn btn-info">
                Add a day
            </button>
        </div>
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Selected tourism attractions</h1>  <a
                            href="<?php echo site_url('travelPlanning/getAllSelectedItem/' . $travelId); ?>"
                            class="btn btn-info"
                            role="button">view finished plan</a></div>
                <div class="panel-body">
                    <ul class="list-group" id="sortable">

                    </ul>
                    <div class="form-group">
                        <label for="note">Note:</label>

                        <textarea class="form-control" rows="5" id="note"></textarea>

                        <input type="button" class="btn btn-info" value="update note"
                               id="submitNote">
                    </div>
                </div>
            </div>

            <div class="modal fade" id="dayItemModal" tabindex="-1" role="dialog">
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
                            <button type="button" class="btn btn-danger" name='dayItemDelete' data-dismiss="modal">
                                Delete
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Attractions</h1></div>
                <div class="panel-body" style="overflow:scroll;height:700px;">
                    <div class="row">
                        <?php foreach ($records->result() as $row) { ?>
                            <div class="col-sm-4 ">
                                <div class="thumbnail">
                                    <img src="<?php echo $row->image; ?>" alt="" width="100%">
                                    <div class="caption">
                                        <h3>
                                            <a href="<?php echo site_url('travelAttraction/showAttraction/' . $row->taId); ?>"><?php echo $row->placeName; ?></a>
                                        </h3>
                                        <button name="add" class="btn btn-default" value="<?php echo $row->taId; ?>">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
//            $("#sortable").sortable();
//            $("#sortable").disableSelection();
            var dayId;
            var dayOrderArray = [];
            getDay();
            $("ul#dayNum").on("click", "[name=day]", function () {
                dayId = $(this).val();
                select(dayId);
            });
            $("[name=dayDelete]").on("click", function () {
//                var deleteDay=$("li#"+$(this).val()+" input[type=hidden]").val();
                var myObj = JSON.parse($(this).val());// get json from button value
                var IntDeleteDay = parseInt(myObj.dayOrder);
                var dayId = myObj.dayId;

                function checkDeleteDay(day) {
                    return day >= IntDeleteDay;
                }

                if (dayOrderArray.length === 1) { //check travel day whether less than one day
                    alert('cannot less than one day!');
                } else {
                    $.post("<?php echo site_url('travelPlanning/deleteDayNum');?>", {
                        dayId: myObj.dayId,
                        travelId: '<?php echo $travelId;?>',
                        deleteDayOrder: IntDeleteDay
                    }, function (data, status) {
                        if (status == "success") {
                            $("#msg").html(data);
                            $("#" + dayId).remove();
                            var deleteDayIndex = dayOrderArray.findIndex(checkDeleteDay); //find index of the delete day
                            var startChangeIndex = deleteDayIndex + 1;//index of data array for change
                            for (startChangeIndex; startChangeIndex < dayOrderArray.length; startChangeIndex++) { //update array, bigger than delete day number in array should -1
                                dayOrderArray[startChangeIndex] = dayOrderArray[startChangeIndex] - 1; //after deleted day should -1
                            }
                            dayOrderArray.splice(deleteDayIndex, 1); //delete the day order from array
                            getDay();//refrsh day number list
                        } else {
                            $("#msg").html(data);
                        }
                    });
                }
            });
            $("#AddDay").click(function () {
                $.post("<?php echo site_url('travelPlanning/insertDayNum');?>", {
                    dayOrder: dayOrderArray[dayOrderArray.length - 1] + 1,
                    travelId: '<?php echo $travelId;?>'
                }, function (data, status) {
                    var response = JSON.parse(data);
                    $("#dayNum").append(" <li class='list-group-item' id='" + response.dayId + "'>" +
                        "<button type='button' name='day' class='btn btn-link' value='" + response.dayId + "'>Day" + response.dayOrder + "</button>" +
                        "<button type='button' data-toggle='modal' class='btn btn-danger' data-target='#dayModal'  value='" + JSON.stringify(response) + "'>Delete</button>" +
                        "</li>"
                    ); //append echo
                    dayOrderArray.push(dayOrderArray[dayOrderArray.length - 1] + 1);
                });
            });
            $("ul#sortable").on("click", "button[name=updateTime]", function () {
                var itemId = $(this).val();
                //alert(itemId);
                $.post("<?php echo site_url('travelPlanning/updateDayItemTime/');?>" + itemId, {time: $("#time" + itemId).val()}, function (data, status) {
                    if (status == "success") {
                        $("#updateMsg" + itemId).html(data);
                    } else {
                        $("#updateMsg" + itemId).html(data);
                    }
                });
            });
            $("button[name=dayItemDelete]").on("click", function () {
                var myObj = JSON.parse($(this).val());
                //var id=$(this).val(); //button value
                $.post("<?php echo site_url('travelPlanning/deleteDayItem/');?>" + myObj.itemId, {
                    taId: myObj.taId
                }, function (data, status) {
                    $("#msg").html(data);
                    $("#li" + myObj.itemId).remove();
                });
            });
            $("[name=add]").click(function () {
                $.post("<?php echo site_url('travelPlanning/insertDayItem/');?>" + dayId, {
                    attraction_id: $(this).val(),
                    travel_id: '<?php echo $travelId;?>'
                }, function (data, status) {
                    var response = JSON.parse(data);
                    var link = "<?php echo site_url('travelAttraction/showAttraction/');?>";
                    $("ul#sortable").append(
                        "<li class='list-group-item' name='selected' id='li" + response.itemId + "'><img src='" + response.image + "' height='100' width='100'>" +
                        "<a href='" + link + response.taId + "'>" + response.placeName + "</a>" +
                        " <button type='button' data-toggle='modal' class='btn btn-danger' data-target='#dayItemModal' value='" + JSON.stringify(response) + "'>Delete</button>" +
                        "<br>" +
                        "<input type='time' id='time" + response.itemId + "' value='" + response.time + "'>" +
                        "<button type='button' name='updateTime' class='btn btn-info' value='" + response.itemId + "'>update time </button>" +
                        "</li>"
                    );
                    //alert(data);
                });
            });
            $("#submitNote").click(function () {
                $.post("<?php echo site_url('travelPlanning/updateNote/');?>" + dayId, {
                    note: $("#note").val()
                }, function (data, status) {
                    if (status == "success") {
                        $("#msg").html(data);
                    } else {
                        $("#msg").html(data);
                    }
                });
            });
            function getDay() {
                $("ul#dayNum").empty();
                $.getJSON("<?php echo site_url('travelPlanning/loadDayJSON');?>", {travelId: '<?php echo $travelId;?>'}, function (data, status) {
                    for (var i = 0; i < data.length; i++) {
                        $("ul#dayNum").append(" <li class='list-group-item' id='" + data[i].dayId + "'>" +
                            "<button type='button' name='day' class='btn btn-link' value='" + data[i].dayId + "'>Day" + data[i].dayOrder + "</button>" +
                            "<button type='button' data-toggle='modal' class='btn btn-danger' data-target='#dayModal' value='" + JSON.stringify(data[i]) + "'>Delete</button>" +
                            "</li>");
                        var arrint = parseInt(data[i].dayOrder);
                        dayOrderArray.push(arrint);
                    }
                    dayOrderArray.sort(function (a, b) {
                        return a - b
                    });
                    dayId = data[0].dayId;//set default day id
                    select(dayId);//default get day one attraction
                });
            }

            function select(dayId) {
                $.getJSON("<?php echo site_url('travelPlanning/loadSelectedAttractionJSON');?>", {dayId: dayId}, function (data, status) {
                    var link = "<?php echo site_url('travelAttraction/showAttraction/');?>";
                    $("ul#sortable").empty();
                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            $("ul#sortable").append("<li class='list-group-item' name='selected' id='li" + data[i].itemId + "'><img src='" + data[i].image + "' height='100' width='100'>" +
                                "<a href='" + link + data[i].taId + "'>" + data[i].placeName + "</a>" +
                                " <button type='button' data-toggle='modal' class='btn btn-danger' data-target='#dayItemModal' value='" + JSON.stringify(data[i]) + "'>Delete</button>" +
                                "<br>" +
                                "<input type='time' id='time" + data[i].itemId + "' value='" + data[i].time + "'>" +
                                "<button type='button' name='updateTime' class='btn btn-info' value='" + data[i].itemId + "'>update time </button>" +
                                " <div id='updateMsg" + data[i].itemId + "'></div>" +
                                "</li>"
                            );
                        }
                        $("#note").text(data[0].note);
                    }
                });
            }

            $('#dayModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);// Button that triggered the modal
                var dayData = button.val();
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-footer [name=dayDelete]').val(dayData);
            });
            $('#dayItemModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);// Button that triggered the modal
                var dayItemData = button.val();
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-footer [name=dayItemDelete]').val(dayItemData);
            });
        });
    </script>
<?php } else { ?>
    <p>No content found</p>
<?php } ?>
