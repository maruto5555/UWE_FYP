
    <style>
        #map {
            width:1400px;height:400px;
        }
        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 300px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        .pac-container {
            font-family: Roboto;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

        #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

    </style>
    <?php  $this->load->module('Template');
    $this->template->drawBreadCrumbs($breadCrumbs_data);
    ?>
    <?php if(isset($flash)){
        echo $flash;
    }?>
<input id="pac-input" class="controls" type="text"
       placeholder="Enter a location">
<div id="type-selector" class="controls">
    <input type="radio" name="type" id="changetype-all" checked="checked">
    <label for="changetype-all">All</label>

    <input type="radio" name="type" id="changetype-establishment">
    <label for="changetype-establishment">Establishments</label>

    <input type="radio" name="type" id="changetype-address">
    <label for="changetype-address">Addresses</label>

    <input type="radio" name="type" id="changetype-geocode">
    <label for="changetype-geocode">Geocodes</label>
</div>
<div id="map"></div>
<?php echo form_open(base_url('index.php/admin/insertAttraction/'.$cityId),'class="form-signin"');?>
<div class="form-group">
    <label for="name">Attraction Name:</label>
    <input type="text" class="form-control" id="placeName" name="placeName">
</div>
<div class="form-group">
    <label for="place_id">Place Id:</label>
    <input type="text" class="form-control" id="place_id" name="place_id">
</div>
<div class="form-group">
        <label for="city">City ID:</label>
        <input type="text" class="form-control" id="cityId" name="cityId" value="<?php echo $cityId;?>">
    </div>
    <div class="form-group">
        <label for="lat">Lat:</label>
        <input type="text" class="form-control" id="lat" name="lat">
    </div>
    <div class="form-group">
        <label for="lng">Lng:</label>
        <input type="text" class="form-control" id="lng" name="lng">
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <input type="text" class="form-control" id="image" name="image">
    </div>
<button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit" name="submit">Submit</button>
<?php echo form_close();?>
<script>
    var autocomplete; var place;
    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13
        });
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('pac-input'));

        var types = document.getElementById('type-selector');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

        autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setIcon(/** @type {google.maps.Icon} */({
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);
            document.getElementById("placeName").value=place.name;
            document.getElementById("place_id").value=place.place_id;
            document.getElementById("lat").value=place.geometry.location.lat();
            document.getElementById("lng").value=place.geometry.location.lng();
            var maxWidth=place.photos[0].width;
            var maxHeight=place.photos[0].height;
            document.getElementById("image").value=place.photos[0].getUrl({'maxWidth':maxWidth, 'maxHeight':maxHeight});
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
            var radioButton = document.getElementById(id);
            radioButton.addEventListener('click', function() {
                autocomplete.setTypes(types);
            });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaENsWqQ39dgLsyl7NuzVv4NHOaUzID8k&signed_in=true&libraries=places&callback=initMap"
        async defer></script>