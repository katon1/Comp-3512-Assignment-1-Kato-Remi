<?php
    require_once '../config.inc.php';
    require_once '../song-db-classes.inc.php';
    include '../borders.php';
   
    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $songsGateway = new SongsDB($conn);
        $songs = $songsGateway->getAll();
        $ua = $songsGateway->getArtists();
        $ug = $songsGateway->getGenres();
        
        
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
    <title>Search Page</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans&display=swap" rel="stylesheet" type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <!-- Generic Styling Sheet for header and footer -->
    <link rel ="stylesheet" href="../style.css" type='text/css'>
    <!-- Maybe add a specific styling sheet -->
    <link rel ="stylesheet" href="../SearchPage/css/searchPages.css" type='text/css'>

</head>
<body >
    
    <?php echo "<h1>" . heads() . "</h1>" ?>
    
    <main>
        <h1 id="title">SEARCH</h1>
        
        <div id="box">
        <form id="search" action="../SearchPage/searchResult.php">
            <label>Title</label><br><input type="radio" name="Type" value="title"> 
            <input type="search" name="Title"><br>
            
            <div id="one">
            <div id="Art">
            <label>Artist</label><br><input type="radio" name="Type" value="artist_name"> 
            <select name="Artist">
                <option></option>
                <?php
                    foreach ($ua AS $al){
                        echo "<option value='".$al['artist_name']."'>".$al['artist_name']."</option>";
                    }
                ?>
            </select> <br>
                </div>
                
            <div id="Genres">
            <label>Genre</label><br><input type="radio" name="Type" value="genre_name">
            <select name="Genre">
                <option></option>
                <?php
                    foreach ($ug AS $gl){
                        echo "<option value='".$gl['genre_name']."'>".$gl['genre_name']."</option>";
                    }
                ?>
            </select><br>
            </div>
            </div>
            <br>
            <div id="Years">
                <input type="radio" name="Type" value="year"><label> Year</label><br>
                <input type="radio" name="YearLG" value="<"><label> Less</label>
                <input type="radio" name="YearLG" value=">"><label> Greater</label>
                <input type="number" name="Year">
            </div>
            <div id="Popularity">
                <input type="radio" name="Type" value="popularity"><label> Popularity</label><br>
                <input type="radio" name="PopularityLG" value="<"><label> Less</label>
                <input type="radio" name="PopularityLG" value=">"><label> Greater</label>
                <input type="number" name="Popularity">
            </div>
            <div id="button">
            <input type="submit" value="Search">
            </div>
        </form>
        </div>
    </main>
        <?php footer() ?>
        
</body>
</html>