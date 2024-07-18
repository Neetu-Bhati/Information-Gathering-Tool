<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Geolocation Lookup</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">IP Geolocation Lookup</h1>
        <form method="post" class="my-4">
            <button type="submit" class="btn btn-primary">Get My IP Info</button>
        </form>

        <?php
        function getPublicIP() {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api64.ipify.org?format=json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            $ipData = json_decode($result, true);
            return $ipData['ip'];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ip = getPublicIP();
            $url = "http://ip-api.com/json/" . $ip;
            $json = file_get_contents($url);
            $data = json_decode($json, true);

            if ($data["status"] == "success") {
                echo "<h2 class='my-4'>Geolocation Information for IP: " . $data["query"] . "</h2>";
                echo "<table class='table table-bordered'>";
                echo "<tr><th>Country</th><td>" . $data["country"] . " (" . $data["countryCode"] . ")</td></tr>";
                echo "<tr><th>Region</th><td>" . $data["region"] . " (" . $data["regionName"] . ")</td></tr>";
                echo "<tr><th>City</th><td>" . $data["city"] . "</td></tr>";
                echo "<tr><th>ZIP</th><td>" . $data["zip"] . "</td></tr>";
                echo "<tr><th>Latitude</th><td>" . $data["lat"] . "</td></tr>";
                echo "<tr><th>Longitude</th><td>" . $data["lon"] . "</td></tr>";
                echo "<tr><th>Timezone</th><td>" . $data["timezone"] . "</td></tr>";
                echo "<tr><th>ISP</th><td>" . $data["isp"] . "</td></tr>";
                echo "<tr><th>Organization</th><td>" . $data["org"] . "</td></tr>";
                echo "<tr><th>AS</th><td>" . $data["as"] . "</td></tr>";
                echo "</table>";
                echo "<div id='map'></div>";
                echo "<script>
                        var lat = " . $data['lat'] . ";
                        var lon = " . $data['lon'] . ";
                      </script>";
            } else {
                echo "<div class='alert alert-danger'>Unable to retrieve geolocation information for IP: " . $ip . "</div>";
            }
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        if (typeof lat !== 'undefined' && typeof lon !== 'undefined') {
            var map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            L.marker([lat, lon]).addTo(map)
                .bindPopup('IP Location')
                .openPopup();
        }
    </script>
</body>
</html>
