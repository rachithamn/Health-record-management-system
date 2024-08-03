<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Frontend</title>
</head>
<body>
  <button id="getDataBtn">Get Data from Backend</button>
  <div id="result"></div>

  <script>
    document.getElementById('getDataBtn').addEventListener('click', function() {
      // Make AJAX request to backend
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'http://localhost/backend.php', true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var response = JSON.parse(xhr.responseText);
          document.getElementById('result').innerText = response.message;
        }
      };
      xhr.send();
    });
  </script>
</body>
</html>
