<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Search</title>
    <style>
        body {
            height: 100%; 
            width: 100%; 
            background-image: url("pic27.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; 
        }
        form {
            margin: 20px;
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 16px;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; 
            width: 90%;
            max-width: 1200px; 
            gap: 30px; 
        }
        .part {
            flex: 1 1 calc(50% - 30px); 
            position: relative;
            height: 250px; 
            box-sizing: border-box;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .part img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .part:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .part:hover img {
            filter: brightness(1.2);
        }
        .container > div:nth-child(1),
        .container > div:nth-child(2) {
            margin-bottom: 30px; 
        } 
    </style>
</head>
<body>
    <form action="results.php" method="get">
        <input type="text" name="search" placeholder="Enter plant name" required>
        <button type="submit">Search</button>
    </form>

    <div class="container">
        <div class="part">
            <a href="medicalindex.html">
                <img src="pic2.jpg" alt="Image 1">
            </a>
        </div>   
        <div class="part">
            <a href="Aquatic.html">
                <img src="pic1.jpg" alt="Image 2">
            </a>
        </div>
        <div class="part">
            <a href="flowering.html">
                <img src="pic.jpg" alt="Image 3">
            </a>
        </div>
        <div class="part">
            <a href="edible.html">
                <img src="pic4.jpg" alt="Image 4">
            </a>
        </div>
    </div>
</body>
</html>