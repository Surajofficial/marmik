<!DOCTYPE html>
<html>

<head>
    <title>Marmik || Current Location on Google Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC28irS-FrqBuxwyjqrSiG9F9OiFIxWkLw"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <h3>My Google Map</h3>
    <button onclick="initMap()">Show My Location</button>
    <div id="map"></div>

    <script>
        function initMap() {
            // Check if geolocation is supported/enabled on current browser
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Create a map object and specify the DOM element for display.
                        var map = new google.maps.Map(document.getElementById('map'), {
                            center: {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            },
                            zoom: 15
                        });

                        // Create a marker and set its position.
                        var marker = new google.maps.Marker({
                            map: map,
                            position: {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            },
                            title: 'You are here!'
                        });
                    },
                    function(error) {
                        // Handle the error case
                        console.error("Error Code = " + error.code + " - " + error.message);
                        alert("Geolocation failed: " + error.message);
                    }
                );
            } else {
                // Browser doesn't support Geolocation
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>
</body>

</html>
