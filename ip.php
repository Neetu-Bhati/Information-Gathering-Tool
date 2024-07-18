<!DOCTYPE html>
<html>
<head>
    <title>IP Geolocation Lookup</title>
</head>
<body>
    <h1>IP Geolocation Lookup</h1>
    <form method="post">
        <label for="ip">Enter IP address:</label>
        <input type="text" id="ip" name="ip" required>
        <input type="submit" value="Lookup">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ip = htmlspecialchars($_POST["ip"]);
        $url = "http://ip-api.com/json/" . $ip;
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        if ($data["status"] == "success") {
            echo "<h2>Geolocation Information for IP: " . $data["query"] . "</h2>";
            echo "<ul>";
            echo "<li>Country: " . $data["country"] . " (" . $data["countryCode"] . ")</li>";
            echo "<li>Region: " . $data["region"] . " (" . $data["regionName"] . ")</li>";
            echo "<li>City: " . $data["city"] . "</li>";
            echo "<li>ZIP: " . $data["zip"] . "</li>";
            echo "<li>Latitude: " . $data["lat"] . "</li>";
            echo "<li>Longitude: " . $data["lon"] . "</li>";
            echo "<li>Timezone: " . $data["timezone"] . "</li>";
            echo "<li>ISP: " . $data["isp"] . "</li>";
            echo "<li>Organization: " . $data["org"] . "</li>";
            echo "<li>AS: " . $data["as"] . "</li>";
            echo "</ul>";
        } else {
            echo "<p>Unable to retrieve geolocation information for IP: " . $ip . "</p>";
        }
    }
    ?>
</body>
</html>
