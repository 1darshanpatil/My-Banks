<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Bank Management</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        iframe {
            border: none;
            flex: 1; /* Each iframe will take equal space */
            height: 100%;
        }
        iframe.left {
            border-right: 1px solid #ccc; /* Optional: Add a separator between frames */
        }
    </style>
</head>
<body>
    <iframe class="right" src="view_balances.php"></iframe>
    <iframe class="left" src="user_script.php"></iframe>
</body>
</html>