<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Code Parser</title>
</head>
<body>
    <h2>HTML Code Parser</h2>
    <form method="post">
        <textarea name="html_code" rows="10" cols="50"></textarea><br>
        <input type="submit" value="Submit">
    </form>
    <br>
    <?php
    function extractDataFromHTML($html) {
        preg_match_all('/"messaging_actor":{"__typename":"User","__isMessagingActor":"User","id":"(.*?)","name":"(.*?)"/', $html, $matches, PREG_SET_ORDER);
        $data = [];
        foreach ($matches as $match) {
            $uid = $match[1];
            $name = json_decode('"' . $match[2] . '"');
            $data[] = ['uid' => $uid, 'name' => $name];
        }
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['html_code'])) {
            $html_code = $_POST['html_code'];
            $extracted_data = extractDataFromHTML($html_code);
            if (!empty($extracted_data)) {
                echo "<h3>Extracted Data</h3>";
                echo "<table border='1'>";
                echo "<tr><th>#</th><th>UID</th><th>Name</th></tr>";
                $count = 1;
                foreach ($extracted_data as $data) {
                    echo "<tr><td>" . $count++ . "</td><td>" . $data['uid'] . "</td><td>" . $data['name'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No data found in the provided HTML code.";
            }
        } else {
            echo "Please enter HTML code in the textarea.";
        }
    }
    ?>
</body>
Design by Tuong
</html>
