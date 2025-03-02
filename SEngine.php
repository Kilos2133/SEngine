<?php
// TODO 1: Обробка GET-запиту та виконання пошуку через Google API

$apiKey = "AIzaSyCNlVIqPyEAR3Cd-bkBpn9Vl9jYRp6Qklg";
$cx = "420454d01d23f404b";

$searchQuery = isset($_GET['search']) ? urlencode($_GET['search']) : '';
$results = [];

if (!empty($searchQuery)) {
    $url = "https://www.googleapis.com/customsearch/v1?key=$apiKey&cx=$cx&q=$searchQuery";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['items'])) {
        $results = $data['items'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Search Engine</title>
</head>
<body>
<h2>My Browser</h2>
<form method="GET" action="SEngine.php">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value="<?= htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : '') ?>">
    <br><br>
    <input type="submit" value="Submit">
</form>

<?php
// TODO 2: Відображення результатів пошуку
if (!empty($results)) {
    echo "<h3>Search Results:</h3><ul>";
    foreach ($results as $item) {
        echo "<li><a href='" . htmlspecialchars($item['link']) . "' target='_blank'>" . htmlspecialchars($item['title']) . "</a><p>" . htmlspecialchars($item['snippet']) . "</p></li>";
    }
    echo "</ul>";
} elseif (!empty($searchQuery)) {
    echo "<p>No results found.</p>";
}
?>
</body>
</html>