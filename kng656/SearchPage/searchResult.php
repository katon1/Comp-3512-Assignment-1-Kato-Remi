<?php
    require_once '../config.inc.php';
    require_once '../song-db-classes.inc.php';
    include '../borders.php';
    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $songsGateway = new SongsDB($conn);
        $songs = $songsGateway->getAll();
        
        if (isset($_GET['Type'])){
            if ($_GET['Type']=="title" && isset($_GET['Title'])){
                $songs = $songsGateway->search($_GET['Type'], $_GET['Title']);
            } elseif ($_GET['Type']=="artist_name" && isset($_GET['Artist'])){
                $songs = $songsGateway->search($_GET['Type'], $_GET['Artist']);
            } elseif ($_GET['Type']=="genre_name" && isset($_GET['Genre'])) {
                $songs = $songsGateway->search($_GET['Type'], $_GET['Genre']);
            } elseif ($_GET['Type']=="year" && isset($_GET['YearLG']) && isset($_GET['Year'])){
                $songs = $songsGateway->searchLG($_GET['Type'], $_GET['YearLG'], $_GET['Year']);
            }
            elseif ($_GET['Type']=="popularity" && isset($_GET['PopularityLG']) && isset($_GET['Popularity'])) {
                $songs = $songsGateway->searchLG($_GET['Type'], $_GET['PopularityLG'], $_GET['Popularity']);
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
    <title><?php if(isset($_GET['Type'])){echo"Search Result";}else{echo"Browse";}?></title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans&display=swap" rel="stylesheet" type='text/css'>
    <link rel ="stylesheet" href="../style.css" type='text/css'>
    <!-- Specific styling sheet -->
    <link rel ="stylesheet" href="../SearchPage/css/searchResult.css" type='text/css'>
</head>
<body >
    <?php echo "<h1>" . heads() . "</h1>" ?>
    <main>
        <h1><?php if(isset($_GET['Type'])){echo"Search Result";}else{echo"Browse";}?></h1>
        <?php
    if (isset($_GET['Type'])){
            if ($_GET['Type']=="title" && isset($_GET['Title'])){
        echo "<h2>Title: ".$_GET['Title']."</h2>";
            } elseif ($_GET['Type']=="artist_name" && isset($_GET['Artist'])){
        echo "<h2>Artist:".$_GET['Artist']."</h2>";
            } elseif ($_GET['Type']=="genre_name" && isset($_GET['Genre'])) {
        echo "<h2>Genre:".$_GET['Genre']."</h2>";
            } elseif ($_GET['Type']=="year" && isset($_GET['YearLG']) && isset($_GET['Year'])){
        echo "<h2>Year".$_GET['side'].$_GET['Year']."</h2>";
            }
            elseif ($_GET['Type']=="popularity" && isset($_GET['PopularityLG']) && isset($_GET['Popularity'])) {
        echo "<h2>Popularity".$_GET['side'].$_GET['Popularity']."</h2>";
            }
        }
        ?>
        <form><input type="submit" value="Show all">
            <table>
                <?php
                echo "<tr>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Popularity</th>
                        <th>Favorite?</th>
                        <th>View</th>
                    </tr>";

                foreach($songs as $s){
                    echo "<tr><td>".
                    $s['title'].
                    "</td><td>".
                    $s['artist_name'].
                    "</td><td>".
                    $s['year'].
                    "</td><td>".
                    $s['genre_name'].
                    "</td><td>".
                    $s['popularity'].
                    "</td><td><input type='button' value='Favorite' onclick=\"location='../Favourites/Favourites.php?add=".
                    $s['song_id'].
                    "'\"></td><td><input type='button' value='View song' onclick=\"location='../Song/songStats.php?find=".
                    $s['song_id']."'\"></td></tr>";
                }
                ?>
            </table>
        </form>
    </main>
    <?php footer() ?>
</body>
</html>