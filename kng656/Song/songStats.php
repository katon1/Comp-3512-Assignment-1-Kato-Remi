<?php
    require_once '../config.inc.php';
    require_once '../song-db-classes.inc.php';
    include '../borders.php';
    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $songsGateway = new SongsDB($conn);
        
        if (isset($_GET['find'])){
            $songs = $songsGateway->search("song_id", $_GET['find']);
        }
    } 
    catch (Exception $e) {
        die($e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Song Information</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans&display=swap" rel="stylesheet" type='text/css'>
    <link rel ="stylesheet" href="../style.css" type='text/css'>
    <link rel ="stylesheet" href="../Song/css/SongInfo.css" type='text/css'>
</head>
<body >
    <?php echo "<h1>" . heads() . "</h1>" ?>
    <main>
        <?php 
        if(isset($songs)){
            foreach($songs as $s) {
                
                $minutes = $s['duration'] / 60;
                $float = number_format((float)$minutes, 2, '.', '');
                echo '<h2>' . $s['artist_name'] . '</h2>';
                echo '<h1>' . $s['title'] . '</h1>';
                echo '<div id="box1">';
                echo '<h3>' . $s['genre_name']. ' </h3>';
                echo '</div>';
                echo '<div id="box2">';
                echo '<h3> ' . $float . ' minutes</h3>';
                echo '</div>';




                // echo  $s['song_id']. " " . $s['title'] . " By " . $s['artist_name'] . ", " . $s['type_name'] . " Artist, " . $s['genre_name'] . " " . $s['year'] . " " . $float . " minutes";
                // echo "<br> <h1>Analysis Data:</h1>" ; 
                echo '<ul class="container">';
                echo '<li class="categories">' . $s['bpm'] . " <br><br> BPM</li>";
                echo '<li class="categories">' . $s['energy'] . " <br><br> Energy</li>";
                echo '<li class="categories">' . $s['danceability'] . " <br><br> Danceability</li>";
                echo '<li class="categories">' . $s['liveness'] . " <br><br> Liveness</li>";
                echo '<li class="categories">' . $s['valence'] . " <br><br> Valence</li>";
                echo '<li class="categories">' . $s['acousticness'] . " <br><br> Acousticness</li>";
                echo '<li class="categories">' . $s['speechiness'] . " <br><br> Speechiness</li>";
                echo '<li class="categories">' . $s['popularity'] . " <br><br> Popularity</li>";
                echo "</ul>";

            }
       }
        else {
            echo '<p id="nosel">No Selected Song, Please Go Back And Select A Song <a href="../Searchpage/searchPage.php">"Here"</a></p>';
            }
        ?>
    </main>
    <?php footer() ?>
</body>
</html>