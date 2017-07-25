<?php $rows = $records->row(); ?>
<style>
    #map, #pano {
        float: left;
        width: 100%;
        height: 400px;
    }
    #listView {
        padding: 10px 5px;
        margin-bottom: -1px;
        min-height: 310px;
    }
    .product {
        float: left;
        position: relative;
        width: 111px;
        height: 170px;
        margin: 0 5px;
        padding: 0;
    }
    .product img {
        width: 110px;
        height: 110px;
    }
    .product h3 {
        margin: 0;
        padding: 3px 5px 0 0;
        max-width: 96px;
        overflow: hidden;
        line-height: 1.1em;
        font-size: .9em;
        font-weight: normal;
        text-transform: uppercase;
        color: #999;
    }
    .product p {
        visibility: hidden;
    }
    .product:hover p {
        visibility: visible;
        position: absolute;
        width: 110px;
        height: 110px;
        top: 0;
        margin: 0;
        padding: 0;
        line-height: 110px;
        vertical-align: middle;
        text-align: center;
        color: #fff;
        background-color: rgba(0,0,0,0.75);
        transition: background .2s linear, color .2s linear;
        -moz-transition: background .2s linear, color .2s linear;
        -webkit-transition: background .2s linear, color .2s linear;
        -o-transition: background .2s linear, color .2s linear;
    }
    .k-listview:after {
        content: ".";
        display: block;
        height: 0;
        clear: both;
        visibility: hidden;
    }
</style>
<script>

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: <?php echo $rows->lat;?>, lng: <?php echo $rows->lng;?>},
            zoom: 15
        });
        var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('pano'), {
                position: {lat: <?php echo $rows->lat;?>, lng: <?php echo $rows->lng;?>},
            });
        map.setStreetView(panorama);
        var infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);

        service.getDetails({
            placeId: '<?php echo $rows->place_id;?>'
        }, function (place, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                var marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location
                });
                google.maps.event.addListener(marker, 'click', function () {
                    infowindow.setContent(place.name);
                    infowindow.open(map, this);
                });
                document.getElementById("address").innerHTML = 'address : ' + place.formatted_address;
                document.getElementById("rating").innerHTML = 'rating : ' + place.rating;
                for (var i = 0; i < place.photos.length; i++) {
                    if (i == 0) {
                        $("ol").append(" <li data-target='#myCarousel' data-slide-to='" + i + "' class='active'></li>");
                        $("#listbox").append(" <div class='item active'> <img id='image" + i + "' height='50%' width='50%'> </div>");
                    } else {
                        $("ol").append(" <li data-target='#myCarousel' data-slide-to='" + i + "'></li>");
                        $("#listbox").append(" <div class='item'> <img id='image" + i + "' height='50%' width='50%'> </div>");
                    }
                    var maxWidth = place.photos[i].width;
                    var maxHeight = place.photos[i].height;
                    document.getElementById("image" + i).src = place.photos[i].getUrl({
                        'maxWidth': maxWidth,
                        'maxHeight': maxHeight
                    });
                }
                var userReview = "";
                for (var i = 0; i < place.reviews.length; i++) {
                    userReview += "<div class='panel panel-default'>" + "<div class='panel-heading'>" + place.reviews[i].author_name + "</div>"
                        + "<div class='panel-body'>" + place.reviews[i].text + "</div>" + "<div class='panel-footer'>" + "User Rating :" + place.reviews[i].rating + "</div>" + "</div>";
                }
                document.getElementById("userReview").innerHTML = userReview;
            }
        });
    }

</script>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Information</h3>
        </div>
        <div class="panel-body">
            <p>Name : <?php echo $rows->placeName; ?></p>
            <p id="address"></p>
            <p id="rating"></p>
        </div>
    </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Map</h3>
            </div>
            <div class="panel-body">
                <div id="map"></div>
                <div id="pano"></div>
            </div>
        </div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Place picture</h3>
    </div>
    <div class="panel-body">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators" id="carousel">

            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox" id="listbox">

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>


<?php if($vrImage!=false){?>
    <div id="example">

        <div class="demo-section k-content wide">
            <h3>VR picture</h3>
            <div id="listView"></div>
            <div id="pager" class="k-pager-wrap"></div>
        </div>

        <script type="text/x-kendo-template" id="template">
            <div class="product">
                <a href="<?php echo site_url('Home/image/#: iid #');?>" target="_blank"> <img src="#: thumbnail #" alt="#: name # image" /></a>
                <h3>#:name#</h3>
            </div>
        </script>

        <script>
            $(function() {
                var dataSource = new kendo.data.DataSource({
                    transport: {
                        read: {
                            url: "<?php echo site_url('travelAttraction/getAttractionVRJSON');?>",
                            dataType: "json",
                            type: "get",
                            data: {
                                taId: '<?php echo $taId;?>'
                            }
                        }
                    },
                    pageSize: 21
                });
                $("#pager").kendoPager({
                    dataSource: dataSource
                });

                $("#listView").kendoListView({
                    dataSource: dataSource,
                    template: kendo.template($("#template").html())
                });
            });
        </script>
    </div>
<?php }?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">User review</h3>
        </div>
        <div class="panel-body">
            <div id="userReview"></div>
        </div>
    </div>
</div>
<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaENsWqQ39dgLsyl7NuzVv4NHOaUzID8k&signed_in=true&libraries=places&callback=initMap"
        async defer></script>
