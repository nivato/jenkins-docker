<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apache 2 on the Ubuntu 20.04</title>
</head>
<body>
    <div style="width: 900px; margin: 0 auto 0 auto;">
        <div style="text-align: center; background-color: #304558; padding: 5px; margin-bottom: 30px;">
            <img width="800" src="https://httpd.apache.org/images/httpd_logo_wide_new.png" />
        </div>

        <h2 style="color: #304558;">🌎 Hello World!</h2>
        <h3>This is <code style="color: #304558;">Apache 2</code> on the <code style="color: #e95420;">Ubuntu 20.04</code> Docker image.</h2>
        <?php
            $server_ip = $_SERVER['SERVER_ADDR'];
            echo "<h3>Server IP Address is: <code> $server_ip </code></h3>"
        ?>
        <h3 style="color: brown;">Application Version: <code>1.0</code></h3>
    </div>
</body>
</html>
