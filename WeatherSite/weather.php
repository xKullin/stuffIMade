<?php
session_start();
$city = strip_tags(ucfirst($_GET['city']));
if (!isset($_SESSION['cities'])) {
      $_SESSION['cities'] = array();
      $_SESSION['cities'][] = $city;
  }else if(!in_array($city, $_SESSION['cities']) && count($_SESSION['cities']) < 3){
      $_SESSION['cities'][] = $city;
  }else if(!in_array($city, $_SESSION['cities']) && count($_SESSION['cities']) == 3){
      array_shift($_SESSION['cities']);
      $_SESSION['cities'][] = $city;
}
// TODO: shuffle latest to the top even if there's less than 3 searches
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Weather Site</title>
  <meta name="description" content="Gesälprov">
  <meta name="author" content="Kullin">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://kit.fontawesome.com/a0eea558e3.js" crossorigin="anonymous"></script>
</head>


<body>
  <div id = "weatherData">
    <p class = "hide"><a href = "index.php">That is not a city, click me to go back and try again!</a></p>
      <div class = "show">

      <p><a href = "index.php">Search again</a></p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="scripts/scriptWeather.js"></script>
  <script src="scripts/script.js"></script>
</body>
</html>
