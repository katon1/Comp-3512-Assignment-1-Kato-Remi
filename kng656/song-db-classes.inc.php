<?php
class DatabaseHelper {
    
    public static function createConnection($values=array()){
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
    
    public static function runQuery($connection, $sql, $parameters) {
        $statement = null;
        if(isset($parameters)) {
            if(!is_array($parameters)){
                $parameters = array($parameters);
            }
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
            if(!$executedOk) throw new PDOException;
        }
        else {
            $statement = $connection->query($sql);
            if(!$statement) throw new PDOException;
        }
        return $statement;
    }
}

class SongsDB {
    private static $baseSQL = "SELECT * FROM Songs NATURAL JOIN
    Artists NATURAL JOIN Genres INNER JOIN Types ON Artists.artist_type_id = Types.type_id ";
    
    public function __construct($connection) {
        $this->pdo = $connection;
    }
    
    public function getAll(){
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
    
    public function getArtists(){
        $sql = "SELECT DISTINCT artist_name FROM Artists";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();

    }

    public function getGenres(){
        $sql = "SELECT DISTINCT genre_name FROM Genres";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();

    }

    public function search($type, $find){
        $sql = self::$baseSQL . " WHERE ".$type." =?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($find));
        return $statement->fetchAll();
    }
    
    public function searchLG($type, $side, $num){
        $sql = self::$baseSQL . " WHERE ".$type." ".$side."?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($num));
        return $statement->fetchAll();
    }
    
    public function getTopGenre(){
        $sql = "SELECT genre_name FROM genres NATURAL JOIN SONGS GROUP BY genre_name ORDER BY COUNT(genre_name) DESC LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getTopArtist(){
        $sql = "SELECT artist_name FROM artists NATURAL JOIN SONGS GROUP BY artist_name ORDER BY COUNT(artist_name) DESC LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getMostPopular(){
        $sql = "SELECT * FROM songs NATURAL JOIN artists ORDER BY popularity DESC LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getOneHitWonder(){
        $sql = "SELECT * FROM Songs NATURAL JOIN Artists NATURAL JOIN Genres INNER JOIN TYPES ON Artists.artist_type_id = Types.type_id GROUP BY songs.artist_id HAVING COUNT(songs.artist_id) = 1 ORDER BY popularity DESC
LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getLongestAccousticSong(){
        $sql = "SELECT * FROM Songs NATURAL JOIN Artists NATURAL JOIN Genres INNER JOIN TYPES ON Artists.artist_type_id = Types.type_id WHERE acousticness > 40 ORDER BY duration DESC LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAtTheClub(){
        $sql = "SELECT * FROM Songs NATURAL JOIN Artists NATURAL JOIN Genres INNER JOIN TYPES ON Artists.artist_type_id = Types.type_id WHERE danceability > 80 ORDER BY danceability*1.6 + energy*1.4 DESC LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getRunningSong(){
        $sql = "SELECT * FROM Songs NATURAL JOIN Artists NATURAL JOIN Genres INNER JOIN TYPES ON Artists.artist_type_id = Types.type_id WHERE bpm > 120 AND bpm < 125 ORDER BY energy*1.3 + valence*1.6 DESC LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getStudying(){
        $sql = "SELECT * FROM Songs NATURAL JOIN Artists NATURAL JOIN Genres INNER JOIN TYPES ON Artists.artist_type_id = Types.type_id WHERE bpm > 100 AND bpm < 115 AND speechiness > 1 AND speechiness < 20 ORDER BY (acousticness*0.8)+(100-speechiness)+(100-valence) DESC LIMIT 10";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

}
?>