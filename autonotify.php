<?php
require 'db.php'; // Database connection

// Fetch all users
$users_query = $con->query("SELECT id, email FROM users");
$users = $users_query->fetch_all(MYSQLI_ASSOC);

foreach ($users as $user) {
    $user_id = $user['id'];
    $email = $user['email'];

    // Fetch user's plants
    $plants_query = $con->prepare("SELECT * FROM plants WHERE user_id = ?");
    $plants_query->bind_param("i", $user_id);
    $plants_query->execute();
    $plants = $plants_query->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach ($plants as $plant) {
        if ($plant['plant_name']) {
            $plant_name = $plant['plant_name'];
            $location = $plant['location'];

            // Fetch required temperature for the plant
            $temp_query = $con->prepare("SELECT required_temp FROM plants1 WHERE plant_name = ?");
            $temp_query->bind_param("s", $plant_name);
            $temp_query->execute();
            $temp_result = $temp_query->get_result();

            if ($temp_result->num_rows > 0) {
                $row = $temp_result->fetch_assoc();
                $required_temperature = $row['required_temp'];

                // Get weather data from OpenWeatherMap API
                $apiKey = '6e6f9659fef62e5c5d1103979100d281';
                $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($location) . "&units=metric&appid=" . $apiKey;

                $weatherData = file_get_contents($apiUrl);
                $weatherArray = json_decode($weatherData, true);

                if ($weatherArray['cod'] == 200) {
                    $currentTemp = $weatherArray['main']['temp'];
                    $weatherConditions = $weatherArray['weather'][0]['main'];
                    $rainingConditions = ['Rain', 'Drizzle', 'Thunderstorm'];
                    $isTemperatureExceeds = $currentTemp > $required_temperature;
                    $isRaining = in_array($weatherConditions, $rainingConditions);

                    // Construct and send notification
                    $notificationMessage = "Hello,\n\n";
                    if ($isTemperatureExceeds) {
                        $notificationMessage .= "The temperature in $location is $currentTemp °C, exceeding the required temperature for $plant_name ($required_temperature °C).\n";
                    }
                    if ($isRaining) {
                        $notificationMessage .= "It is currently raining in $location.\n";
                    }
                    if ($notificationMessage !== "Hello,\n\n") {
                        $subject = "Weather Alert for Your Plant";
                        $headers = "From: hemanagasri9999@gmail.com\r\n";
                        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                        mail($email, $subject, $notificationMessage, $headers);
                    }
                }
            }
        }
    }
}
?>
