<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heatmap Example</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .heatmap {
            position: relative;
            width: 100%;
            height: 500px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="heatmap" id="heatmapContainer"></div>
</body>
</html>
