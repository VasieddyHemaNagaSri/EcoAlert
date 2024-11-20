<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

$query = "SELECT * FROM plants WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
$plants = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updated_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $location = filter_var(trim($_POST['location']), FILTER_SANITIZE_STRING); // Get location input
    
    if ($updated_email !== $email) {
        $update_email_query = "UPDATE users SET email = '$updated_email' WHERE id = $user_id";
        if (mysqli_query($con, $update_email_query)) {
            $_SESSION['email'] = $updated_email;
        } else {
            echo "<script>alert('Failed to update email.');</script>";
        }
    }

    // Add new plants
    if (isset($_POST['plants'])) {
        $plantsToAdd = $_POST['plants'];
        foreach ($plantsToAdd as $plant) {
            $plant = filter_var(trim($plant), FILTER_SANITIZE_STRING); // Sanitize plant name
            if (!empty($plant)) {
                $insert_plant_query = "INSERT INTO plants (user_id, plant_name, location) VALUES ($user_id, '$plant', '$location')";
                if (!mysqli_query($con, $insert_plant_query)) {
                    echo "<script>alert('Failed to add plant: " . htmlspecialchars($plant) . ".');</script>";
                }
            } else {
                echo "<script>alert('Plant name cannot be empty. Please enter a valid plant name.');</script>";
            }
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle deletion of plants
if (isset($_GET['delete'])) {
    $plant_id = intval($_GET['delete']);
    $delete_query = "DELETE FROM plants WHERE id = $plant_id AND user_id = $user_id";
    if (mysqli_query($con, $delete_query)) {
        // Redirect to prevent resubmission of delete on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Failed to delete plant.');</script>";
    }
}

// Check the weather for each plant and send notifications
foreach ($plants as $plant) {
    if ($plant['plant_name']) {
        // Fetch required temperature for the plant from the database
        $plant_name = $plant['plant_name'];
        $sql = "SELECT required_temp FROM plants1 WHERE plant_name = '$plant_name'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $required_temperature = $row['required_temp'];

            // Get weather data from OpenWeatherMap API
            $apiKey = '6e6f9659fef62e5c5d1103979100d281'; 
            $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($plant['location']) . "&units=metric&appid=" . $apiKey;

            $weatherData = file_get_contents($apiUrl);
            $weatherArray = json_decode($weatherData, true);

            if ($weatherArray['cod'] == 200) {
                $currentTemp = $weatherArray['main']['temp'];
                $weatherConditions = $weatherArray['weather'][0]['main'];
                $isTemperatureExceeds = $currentTemp > $required_temperature;
                $rainingConditions = ['Rain', 'Drizzle', 'Thunderstorm'];
                $isRaining = in_array($weatherConditions, $rainingConditions);

                // Construct notification message
                $notificationMessage = "Hello,\n\n";
                if ($isTemperatureExceeds) {
                    $notificationMessage .= "The current temperature in " . $plant['location'] . " is $currentTemp °C, which exceeds the required temperature for $plant_name ($required_temperature °C).\n";
                }
                if ($isRaining) {
                    $notificationMessage .= "it is raining in " . $plant['location'] . ".\n";
                }
                if ($notificationMessage !== "Hello,\n\n") {
                    $subject = "Weather Alert for Your Plant";
                    $headers = "From: hemanagasri9999@gmail.com" . $email;
                    if (!mail($email, $subject, $notificationMessage, $headers)) {
                        echo "<script>alert('Failed to send email notification.');</script>";
                    }
                }
            } else {
                echo "<script>alert('Could not retrieve weather data for " . $plant['location'] . ".');</script>";
            }
        } else {
            echo "<script>alert('No temperature data found for $plant_name.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Set Notifications</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Additional CSS for better styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        .input-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }

        .input-group label {
            flex: 1;
            margin-right: 10px;
            text-align: right;
        }

        input[type="text"],
        input[type="email"] {
            flex: 2;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            background-color: #28a745; 
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; 
        }

        #add-plant-btn {
            margin-bottom: 10px; 
        }

        input[type="submit"] {
            margin-top: 10px; 
        }

        button:hover {
            background-color: #218838; 
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 10px;
            background: #e9ecef;
            margin: 5px 0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }

        a {
            color: #dc3545; /* Red color for delete link */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Set Notifications for Plants Protection</h1>
        <form method="POST">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="input-group">
                <label for="location">Location:</label>
                <input type="text" name="location" placeholder="Enter location" required>
            </div>
            <div id="plant-inputs">
                <div class="input-group">
                    <label for="plant">Plant Name:</label>
                    <input type="text" name="plants[]" placeholder="Plant Name" required>
                </div>
            </div>
            <button type="button" id="add-plant-btn">Add Another Plant</button>
            <input type="submit" value="Save Notifications">
        </form>

        <h2>Your Plants</h2>
        <?php if (count($plants) > 0): ?>
            <ul>
                <?php foreach ($plants as $plant): ?>
                    <li>
                        <?= htmlspecialchars($plant['plant_name']) ?> 
                        <a href="?delete=<?= $plant['id'] ?>">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No plants added.</p>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById("add-plant-btn").addEventListener("click", function() {
            var plantInputs = document.getElementById("plant-inputs");
            var newInputGroup = document.createElement("div");
            newInputGroup.className = "input-group";
            newInputGroup.innerHTML = `
                <label for="plant">Plant Name:</label>
                <input type="text" name="plants[]" placeholder="Plant Name" required>
            `;
            plantInputs.appendChild(newInputGroup);
        });
    </script>
</body>
</html>
