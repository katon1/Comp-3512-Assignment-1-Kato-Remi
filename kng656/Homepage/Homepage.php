<?php
    require_once '../config.inc.php';
    require_once '../song-db-classes.inc.php';
    include '../borders.php';
    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $songsGateway = new SongsDB($conn);
        if(isset($_GET['Home'])){
            if($_GET['Home']==1){
                $songs = $songsGateway->getTopGenre();
            }
            elseif($_GET['Home']==2){
                $songs = $songsGateway->getTopArtist();
            }
            elseif($_GET['Home']==3){
                $songs = $songsGateway->getMostPopular();
            }
            elseif($_GET['Home']==4){
                $songs = $songsGateway->getOneHitWonder();
            }
            elseif($_GET['Home']==5){
                $songs = $songsGateway->getLongestAccousticSong();
            }
            elseif($_GET['Home']==6){
                $songs = $songsGateway->getAtTheClub();
            }
            elseif($_GET['Home']==7){
                $songs = $songsGateway->getRunningSong();
            }
            elseif($_GET['Home']==8){
                $songs = $songsGateway->getStudying();
            }
        }
    }
    catch (Exception $e) {
        die($e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>HomePage</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans&display=swap" rel="stylesheet" type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css for header and footer -->
    <link rel ="stylesheet" href="../style.css" type='text/css'>
    <!-- Css for specific page -->
    <link rel ="stylesheet" href="../Homepage/css/Homepage.css" type='text/css'>
</head>
<body>
    <?php echo "<h1>" . heads() . "</h1>" ?>
    <main>
        <h1>COMP 3512</h1>
        <h3>Website for users to find specific hit songs from 2016 to 2019 with Spotify's data!</h3>
        <h3>By Kato Ng and Remi Gendron<h3>
        <h3><a href="https://github.com/katon1/Comp-3512-Assignment-1-Kato-Remi" target="_blank" >Github Repo</a></h3>
        <form class="container">
            <input class="but" id="genre" type="button" onclick="location='../Homepage/Homepage.php?Home=1'" value="Top Genre">
            <input class="but" id="artists" type="button" onclick="location='../Homepage/Homepage.php?Home=2'" value="Top Artists">
            <input class="but" id="popular" type="button" onclick="location='../Homepage/Homepage.php?Home=3'" value="Most Popular Songs">
            <input class="but" id="onehit" type="button" onclick="location='../Homepage/Homepage.php?Home=4'" value="One Hit wonders">
            <input class="but" id="acoustic" type="button" onclick="location='../Homepage/Homepage.php?Home=5'" value="Longest Acoustic Songs">
            <input class="but" id="club" type="button" onclick="location='../Homepage/Homepage.php?Home=6'" value="At the Club">
            <input class="but" id="running" type="button" onclick="location='../Homepage/Homepage.php?Home=7'" value="Running Songs">
            <input class="but" id="study" type="button" onclick="location='../Homepage/Homepage.php?Home=8'" value="Studying">
        </form>
    </main>
    
   
        <table>
            <?php
            if(isset($_GET['Home'])){
                echo "<tr>";
                if($_GET['Home']==1){echo '<th id="results">Genre</th>';}
                if($_GET['Home']>2){echo '<th id="results">Title</th>';}
                if($_GET['Home']>1){echo '<th id="results">Artist</th>';}
                echo "</tr>";

                foreach($songs as $s){
                    echo '<tr>';
                    if($_GET['Home']==1){echo "<td>".$s['genre_name']."</td>";}
                    if($_GET['Home']>2){echo '<td id="two">'."<a href='../Song/songStats.php?find=".$s['song_id']."'>".$s['title']."</a></td>";}
                    if($_GET['Home']>1){echo "<td>".$s['artist_name']."</td>";}
                    echo "</tr>";
                }
            }
            ?>  
            <a type="submit"></a>
        </table>    
    
    <?php footer() ?>
</body>
</html>