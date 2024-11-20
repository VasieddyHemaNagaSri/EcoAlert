<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Search Results</title>
    <style>
        body {
            background-image: url("pic27.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            color: #333;
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            text-align: center;
        }

        h2 {
            color: #fff;
            margin-bottom: 20px;
        }

        .results {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .plant-card {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: left;
            background-color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .plant-card:hover {
            transform: scale(1.02);
        }

        .plant-image {
            flex: 1;
            padding-right: 20px;
        }

        .plant-image img {
            width: 120px;
            height: auto;
            border-radius: 10px;
            border: 2px solid #28a745;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .plant-details {
            flex: 2;
            padding-left: 20px;
        }

        .plant-details h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #28a745;
        }

        .plant-details p {
            margin: 5px 0;
        }

        @media (max-width: 600px) {
            .plant-card {
                flex-direction: column;
                align-items: center;
                width: 90%;
            }

            .plant-image {
                padding: 0;
                margin-bottom: 10px;
            }

            .plant-image img {
                width: 100px;
            }
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "plant_info";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $searchResults = [];
    $searchTerm = '';
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        echo "<h2>Search Results for: $searchTerm</h2>";

        // Execute query directly
        $query = "SELECT * FROM plants WHERE name LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $searchResults[] = $row;
            }
        } else {
            echo "<p style='color: #fff;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    mysqli_close($conn);
    ?>

    <div class="results">
        <?php if (!empty($searchResults)): ?>
            <?php foreach ($searchResults as $plant): ?>
                <div class="plant-card">
                    <div class="plant-image">
                        <img src="<?php echo $plant['image_url']; ?>" alt="<?php echo $plant['name']; ?>">
                    </div>
                    <div class="plant-details">
                        <h3><?php echo $plant['name']; ?></h3>
                        <p><strong>Required Temperature:</strong> <?php echo $plant['required_temperature']; ?> °C</p>
                        <p><strong>Diseases:</strong> <?php echo $plant['common_diseases']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #fff;">No results found in the database.</p>
        <?php endif; ?>
    </div>
</body>
</html>
