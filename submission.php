<?php
    $_ENV = parse_ini_file(".env");
    $servername = $_ENV["servername"];
    $username = $_ENV["username"];
    $password = $_ENV["password"];
    $dbname = $_ENV["dbname"];
    $PORT = $_ENV["PORT"];

    $conn = mysqli_connect($servername, $username, $password, $dbname, $PORT);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected Successfully"
?>

<?php    
    $data = array_map('escape', $_POST);
    $title = $data["title"] ?? NULL;
    $full_name = $data["full_name"];
    $phone_number = $data["phone_number"];
    $email = $data["email"] ?? NULL;
    $recipient = match ($data["recipient"]) {
        "self" => 1,
        "other" => 0,
    };
    $self_reason = $data["self_reason"] ?? Null;
    $other_recipient_name = $data["other_recipient_name"] ?? Null;
    $other_recipient_reason = $data["other_recipient_reason"] ?? Null;

    $sql = "INSERT INTO bookings (" . 
        include_if("title, ", $title != NULL) . 
        "full_name, phone_number" .
        include_if(", email", $email != NULL) .
        ", recipient" .
        include_if(", self_reason", $self_reason != NULL) .
        include_if(", other_recipient_name", $other_recipient_name != NULL) .
        include_if(", other_recipient_reason", $other_recipient_reason != NULL) .
        ") Value (" . 
        include_if("'$title', ", $title != NULL) . 
        "'$full_name', '$phone_number'" .
        include_if(", '$email'", $email != NULL) .
        ", '$recipient'" .
        include_if(", '$self_reason'", $self_reason != NULL) .
        include_if(", '$other_recipient_name'", $other_recipient_name != NULL) .
        include_if(", '$other_recipient_reason'", $other_recipient_reason != NULL) .
        ")";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    }
    else {
        echo "Error" . $sql . "<br/>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    function include_if(String $c, bool $b): String|NUll {
        if ($b) {
            return $c;
        }
        else {
            return NULL;
        }
    }

    function escape(String $s): String {
        return htmlentities($s, ENT_QUOTES, 'UTF-8');
    }
?>