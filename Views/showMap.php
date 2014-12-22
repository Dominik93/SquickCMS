<script>
    var DBid;
    var markers = {};
    function addMarker(x, y, title, map){
        var myLatlng = new google.maps.LatLng(x, y);
        var marker = new google.maps.Marker({
            id: DBid,
            position: myLatlng,
            map: map,
            title: title
        });
        markers[DBid] = marker;
        google.maps.event.addListener(marker, "rightclick", function (point) { 
            var id = this.id; delMarker(id);
            $.post("./Links/delPin.php", {
                "id": this.id});
        });
    }

    var delMarker = function (id) {
        marker = markers[id]; 
        marker.setMap(null);
    }
</script>
<?php
    $map = $_POST['map'];
?>
<p>Aby dodać znacznik kliknij dwa razy na mapę</p>
<p>Aby usunąć znacznik kliknij na niego lewym przyciskiem myszy</p>
</table>
<script type="text/javascript">
    function initialize() {
        var mapOptions = {
            center: { lat: <?php echo $map['start_coords'][0]; ?>, lng: <?php echo $map['start_coords'][1]; ?>},
            zoom: 6,
            disableDoubleClickZoom: true
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        <?php
        foreach($map["coords_array"] as $coords){ ?>
                DBid=<?php echo $coords['ID']; ?>;
                addMarker(<?php echo $coords['x']; ?>, <?php echo $coords['y']; ?>,"<?php echo $coords['description']; ?>", map);
        <?php }?>
        google.maps.event.addListener(map, 'dblclick', function(event) {
            DBid=DBid+1;
            addMarker(event.latLng.lat(), event.latLng.lng(), "<?php echo date('m/d/Y h:i:s a', time())?>", map);
            $.post("./Links/addPin.php", {
                "id": DBid,
                "description": "<?php echo date('m/d/Y h:i:s a', time())?>", 
                "x": event.latLng.lat(), 
                "y": event.latLng.lng(),
                "map_id": "<?php echo $map['ID']?>"
            });
        });
    }
    function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&' +
                        'callback=initialize';
        document.body.appendChild(script);
    }
    window.onload = loadScript();
</script>
<div id="map-canvas" style="height: 600px; width: 600px;"></div>
