<?php

function heads(){
echo "<header>"; 
echo '<ul class="navbar">';
echo '<li id="names">Kato + Remi</li>';
echo '<li id="Homepage"><a href="../Homepage/Homepage.php" >Assignment 1</a></li>';
echo '<li class="nav"><a href="../Song/songStats.php" id="songstat"><img src="../Images/stats.png"></a></li>';
echo '<li class="nav"><a href="../Favourites/Favourites.php" id="favourites"><img src="../Images/favourites.png"></a></li>';
echo '<li class="nav"><a href="../SearchPage/searchPage.php" id="search"><img src="../Images/search.png"></a></li>';
echo '<li class="nav"><a href="../SearchPage/searchResult.php" id="browse"><img src="../Images/list.png" width="35px"></a></li>';
echo '<li class="nav"><a href="../Homepage/Homepage.php" id="home"><img src="../Images/home.png"></a></li>';

echo '</ul>';
echo '</header>';

}


function footer(){
echo "<footer>"; 

echo '<ul class="footerbar">';
echo "<hr>";
echo '<li id="footerline">COMP 3512 WEB II</li>';
echo '<li id="Assignment">Assignment 1</li>';
echo '<li id="copyright">© 2022 Kato Ng & Remi Gendron</li>';

// Bottom Right for Github
// Logo by Github.com
echo '<li class="GithubLink"><a href="https://github.com/rgend797" target="_blank" ><img src="../Images/Github.png"><p> Remi Gendron</p></a></li>';
echo '<li class="GithubLink"><a href="https://github.com/katon1" target="_blank" ><img src="../Images/Github.png"><p> Kato Ng</p></a></li>';
echo '<li class="GithubLink"><a href="https://github.com/katon1/Comp-3512-Assignment-1-Kato-Remi" target="_blank" ><img src="../Images/Github.png"><p> Github Repo</p></a></li>';
echo '</ul>';
echo '</footer>';

}


?>
