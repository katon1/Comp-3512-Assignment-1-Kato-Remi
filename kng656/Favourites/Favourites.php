<?php
    require_once '../config.inc.php';
    require_once '../song-db-classes.inc.php';
    include '../borders.php';

    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $songsGateway = new SongsDB($conn);
        session_start();
        
        if (!isset($_SESSION['favorite'])){
            $_SESSION['favorite'] = array();
        }
        if (isset($_GET['add'])){
            if($_GET['add'] == 0){
                $_SESSION['favorite'] = array();
            } else {
                if(!in_array($_GET['add'], $_SESSION['favorite'])) {
                    array_push($_SESSION['favorite'], $_GET['add']);
                }
            }
        }
        if (isset($_GET['remove']) && in_array($_GET['remove'], $_SESSION['favorite'])){
            $_SESSION['favorite'] = array_diff($_SESSION['favorite'], [$_GET['remove']]);
        }
    } 
    catch (Exception $e) {
        die($e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Favourites Page</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans&display=swap" rel="stylesheet" type='text/css'>
    <link rel ="stylesheet" href="../style.css" type='text/css'>
    <link rel ="stylesheet" href="../Favourites/css/favourite.css" type='text/css'>
</head>
<body>
    <?php echo "<h1>" . heads() . "</h1>" ?>
    <main>

        <h1>FAVORITES</h1>
        <input id="clear" type="button" value="Clear" onclick="location='../Favourites/Favourites.php?add=0'">
        <table>
           
        <?php
            
            echo "<tr>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>Popularity</th>
                    <th>Remove</th>
                    <th>View song</th>
                    </tr>
                    <br>";
            
            foreach($_SESSION['favorite'] as $f){
                
                $songs = $songsGateway->search("song_id", $f);
               
                foreach($songs as $s){
                    echo "<tr><td>".$s['title']."</td><td>".
                    $s['artist_name'].
                    "</td><td>".$s['year'].
                    "</td><td>".$s['genre_name'].
                    "</td><td>".$s['popularity'].
                    "</td><td>". 
                    "<a href='../Favourites/Favourites.php?remove=".$s['song_id']."'>" . 
                    '<img id="remove" src="../Images/remove.png"></a></td><td> 
                    <input type="button" value="View song" ' . 
                    "onclick=\"location='../Song/songStats.php?find=".$s['song_id']."'\"></td></tr>";
                }
                   
            }
        ?>
        </table>
    </main>
    <?php footer() ?>
</body>
</html>