<?php
$host = getenv('IP');
$username = 'lab7_user';
$password = 'password';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

function handleRequest($conn) {
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cquery = filter_input(INPUT_GET, 'country');
    $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$cquery%'");

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo responseBuilder($results);
  }
}

function responseBuilder($results) {
  $listString = "";
  foreach( $results as $row ) {
    $listString .= "<li>{$row['name']} is ruled by {$row['head_of_state']}</li>";
  }
  $response = 
<<<EOF
<ul>
  {$listString}
</ul>
EOF;

  // var_dump($response);
  return $response;
  
}

handleRequest($conn);

?>
