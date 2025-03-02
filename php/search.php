<?php
include_once "config.php";
session_start();
$searchTerm = pg_escape_string($conn, $_POST['searchTerm']);

// Improved query: Uses ILIKE for case-insensitive and partial matching
$query = "SELECT * FROM users WHERE first_name ILIKE $1 OR last_name ILIKE $1"; // to show whether there is a similarty and immediately show the suggestions.
$stmt = pg_prepare($conn, "search_term", $query);
$result = pg_execute($conn, "search_term", ["%$searchTerm%"]);

$output = "";
if (pg_num_rows($result) > 0) {
    while ($user = pg_fetch_assoc($result)) {
        if($user['id'] != $_SESSION['unique_id']){
        // Display each matching user (Customize this part)
        $output .= '
        <a href="chat.php?id=' . $user['id'] . '">
            <div class="content">
                <img src="../uploads/' . htmlspecialchars($user["user_image"]) . '" alt="">
                <div class="details">
                    <span>' . htmlspecialchars($user["first_name"]) . " " . htmlspecialchars($user["last_name"]) . '</span>
                </div>
            </div>
        </a>';
        }else{
            $output .= "No user found";        
        }
    }
} else {
    $output .= "No user found";
}

echo $output;
?>
