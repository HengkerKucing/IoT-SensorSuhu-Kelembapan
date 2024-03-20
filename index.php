<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Suhu dan Kelembapan Tembcy</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  $(document).ready(function() {
    setInterval(function() {
      $.ajax({
        url: "data-sensor.php",
        success: function(data) {
          $("#data-sensor").html(data);
        }
      });
    }, 1000);
  });
  </script>
</head>
<body>
  <h1>Data Sensor Tembcy (Basecamp 25)</h1>
  <div id="data-sensor">
    <div class="suhu">
      <p class="label">Suhu</p>
      <p class="value">-- °C</p>
    </div>
    <div class="kelembapan">
      <p class="label">Kelembapan</p>
      <p class="value">-- %</p>
    </div>
  </div>
</body>
</html>
