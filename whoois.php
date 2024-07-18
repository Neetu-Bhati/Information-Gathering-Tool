<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WHOIS Information</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">WHOIS Information</h1>
    <form method="post" class="mt-3">
        <div class="form-group">
            <label for="domain">Domain Name:</label>
            <input type="text" class="form-control" id="domain" name="domain" required>
        </div>
        <button type="submit" class="btn btn-primary">Get WHOIS Info</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $domain = htmlspecialchars($_POST["domain"]);
        $apikey = "GfDjvBR2EaAGXNHiqWG1Jq6J7PYYIuFn"; // Replace with your actual API key

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.apilayer.com/whois/query?domain=".$domain);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("apikey: $apikey"));
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['result'])) {
            $result = $data['result'];
            echo '<div class="mt-5">';
            echo '<h2>Result for ' . htmlspecialchars($domain) . ':</h2>';
            echo '<ul class="list-group">';
            echo '<li class="list-group-item"><strong>Creation Date:</strong> ' . htmlspecialchars($result['creation_date']) . '</li>';
            echo '<li class="list-group-item"><strong>DNSSEC:</strong> ' . htmlspecialchars($result['dnssec']) . '</li>';
            echo '<li class="list-group-item"><strong>Domain Name:</strong> ' . htmlspecialchars($result['domain_name']) . '</li>';
            echo '<li class="list-group-item"><strong>Email:</strong> ' . htmlspecialchars($result['emails']) . '</li>';
            echo '<li class="list-group-item"><strong>Expiration Date:</strong> ' . htmlspecialchars($result['expiration_date']) . '</li>';
            echo '<li class="list-group-item"><strong>Name Servers:</strong> ' . implode(', ', array_map('htmlspecialchars', $result['name_servers'])) . '</li>';
            echo '<li class="list-group-item"><strong>Registrar:</strong> ' . htmlspecialchars($result['registrar']) . '</li>';
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-danger mt-5">Failed to retrieve WHOIS information. Please try again.</div>';
        }
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
