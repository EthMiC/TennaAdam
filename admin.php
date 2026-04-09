<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="admin.js"></script>
</head>
<body>
    <section>
        <button onclick="show_bookings()">Bookings</button>
    </section>
    <section id="content">
        <h1>WIP</h1>
        <p>Webpage should be up and running in a bit</p>
    </section>
</body>
</html>

<?php
    function get_bookings(): String|Null {
        $_ENV = parse_ini_file(".env");
        $servername = $_ENV["servername"];
        $username = $_ENV["adminusername"];
        $password = $_ENV["adminpassword"];
        $dbname = $_ENV["dbname"];
        $PORT = $_ENV["PORT"];

        $conn = mysqli_connect($servername, $username, $password, $dbname, $PORT);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM bookings";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);

        if ($result) {
            return implode("", array_map('print_entry', mysqli_fetch_all($result)));
        }
        else {
            return Null;
        }

    }

    function print_entry(Array $a): String {
        $title = $a[1];
        $full_name = $a[2];
        $phone_number = $a[3];
        $email = $a[4];
        $recipient = $a[5];
        $self_reason = $a[6];
        $other_recipient_name = $a[7];
        $other_recipient_reason = $a[8];

        return "
        <div>
            <div id='information'>
                <div id='identification'>
                    <h3> " . return_if_not_null("$title. ", $title) . "$full_name <h3>
                </div>
                <div id='contacts'>
                    <p> $phone_number <p>
                    <p> $email </p>
                </div>
            </div>
            <div id='reason'>" .
            choose_reason(
                $recipient,
                $self_reason,
                $other_recipient_name,
                $other_recipient_reason
            ) .
        "
            </div>
        </div>
        ";
    }

    function return_if_not_null(String $out, String|Null $in):String {
        if ($in != null) {
            return $out;
        } else {return "";}
    }

    function choose_reason(bool $b, String|Null $s_r, String|Null $o_n, String|Null $o_r):String {
        if ($b) {
            return "
                <p>$s_r</p>
            ";
        }
        else {
            return "
                <h4>$o_n</h4>
                <p>$o_r</p>
            ";
        }
    }
?>