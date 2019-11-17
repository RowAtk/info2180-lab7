<?php
$host = getenv('IP');
$username = 'lab7_user';
$password = 'password';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries WHERE name LIKE :country");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

function handleRequest() {
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cquery = $_GET['country'];
    $results->execute([':country' => $cquery]);
    file_put_contents("log", $results); // debugging
    echo $results;
  }
}

function makeList($type = "ul", $data) {
  $list_content = "";
  foreach( $item as $data ) {
    $list_content .= "<li>{$item}";
  }
  return <<< EOF
  <{$type}>
EOF;   
}

handleRequest();


?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>