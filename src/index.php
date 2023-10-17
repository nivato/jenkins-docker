<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apache 2 on the Alpine Linux 3.17</title>
</head>
<body style="color: #555555; background-color: #eeeeee; padding: 0;">
    <div style="width: 900px; margin: 0 auto 0 auto;">
        <div style="text-align: center; background-color: #304558; padding: 5px; margin-bottom: 5px;">
            <img width="800" src="https://httpd.apache.org/images/httpd_logo_wide_new.png" />
        </div>
        <div style="text-align: center; background-color: white; padding: 5px; margin-bottom: 30px;">
            <img width="300" src="https://www.alpinelinux.org/alpinelinux-logo.svg" />
        </div>

        <h2 style="color: #304558;">🌎 Hello World!</h2>
        <h3>This is <code style="color: #304558;">Apache 2</code> on the <code style="color: #e95420;">Alpine Linux 3.17</code> Docker image.</h2>
        <?php
            $server_ip = $_SERVER['SERVER_ADDR'];
            echo "<h3>Server IP Address is: <code> $server_ip </code></h3>"
            echo "<h3 style=\"color: limegreen;\">Application Version: <code> $_ENV['APP_VERSION'] </code></h3>"
        ?>
    </div>
</body>
</html>
