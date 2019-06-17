<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'mom_db';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from skills table
$query = $db->query("SELECT * FROM login_plugin_db.login_table WHERE user_name LIKE '%".$searchTerm."%' ORDER BY user_id ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['user_name'];
}
//return json data
echo json_encode($data);
?>