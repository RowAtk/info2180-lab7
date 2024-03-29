<?php
$host = getenv('IP');
$username = 'lab7_user';
$password = 'password';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

function handleRequest($conn) {
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $queries = array_filter($_GET);
    if ( isset($queries['context']) ) {
      // City search
      $sqlquery = "SELECT cities.name, cities.district, cities.population FROM cities JOIN countries ON cities.country_code=countries.code WHERE countries.name LIKE '%{$queries['country']}%'";
      $headings = ['City Name', 'District', 'Population'];
      $dbfields = ['name', 'district', 'population'];
    } else {
      // Normal country search
      $sqlquery = "SELECT * FROM countries WHERE name LIKE '%{$queries['country']}%'";
      $headings = ['Country Name', 'Continent', 'Independence Year', 'Head of State'];
      $dbfields = ['name', 'continent', 'independence_year', 'head_of_state'];
    }

    $stmt = $conn->query($sqlquery);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response = table_response($results, $headings, $dbfields);
    file_put_contents("log", $response);  //debugging
    echo $response;
  }
}

function list_response($results) {
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

  return $response;
  
}

function table_response($results, $headings, $dbfields) {
  /* Country Name, Continent, Independence Year, Head of State */
  $table_headings = table_headings($headings);
  
  $table_data = "";
  
  foreach( $results as $row ) {
    $row_data = "";
    foreach( $dbfields as $field ) {
      $row_data .= td($row[$field]);
    }
    $table_data .= tr($row_data);
  }

  return table("{$table_headings}{$table_data}");
}

function table_headings($headings) {
  $table_headings = "";
  foreach( $headings as $heading ) {
    $table_headings .= th($heading);
  }

  return tr($table_headings);
}

/* HTML generator functions - return html as string*/
function table($table_data) {
  return "<table>{$table_data}</table>";
}

function tr($row_data) {
  return "<tr>{$row_data}</tr>";
}

function td($row_cell) {
  return "<td>{$row_cell}</td>";
}

function th($heading) {
  return "<th>{$heading}</th>";
}


// MAIN DRIVER
handleRequest($conn);

?>
