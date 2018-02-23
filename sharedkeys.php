<?php include './theme/header.php';

$results_per_page = 15;

if (isset($_GET["page"])) { 
	$page  = $_GET["page"]; 
} 
else { 
	$page=1; 
}; 

$start_from = ($page-1) * $results_per_page;

echo "<h2> Shared Games </h2>";


//vars
$user_id = $_SESSION["user_id"];

$sql = "
SELECT K.key_id, G.gamename, P.platformname, CU.username AS claimeduser FROM `keys` AS K
JOIN games G
ON K.Game_ID = G.Game_ID
JOIN platforms P
ON K.platform_id = P.platform_id
LEFT OUTER JOIN users CU
ON K.owned_user = CU.user_id
where K.created_user_id = $user_id
LIMIT $start_from, $results_per_page
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo '<table class="table"><tr><th>Game Name</th><th>Platform</th><th>Claimed By</th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewkey.php?id='.$row["key_id"].'">'. $row["gamename"].'</a></td><td>'.$row["platformname"].'</td><td>'.$row["claimeduser"].'<td></tr>';
    }
    echo '</table>';
} else {
    echo "No Keys Shared";
}

$sql = "
SELECT count(K.key_id) AS total FROM `keys` AS K
JOIN games G
ON K.Game_ID = G.Game_ID
JOIN platforms P
ON K.platform_id = P.platform_id
LEFT OUTER JOIN users CU
ON K.owned_user = CU.user_id
WHERE K.created_user_id = $user_id";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
			echo '<br><nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">';
                        
			if ($page == 1) {
				echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='?page='".($page-1)."'>Previous</a></li>";
			}
			
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                        echo "<li class='page-item";
				if ($i==$page)  echo " active";
			echo "'><a class='page-link'href='?page=".$i."'";
                        echo ">".$i."</a></li>";
                        }

			if ($page == $total_pages) {
				echo "<li class='page-item disabled'><a class='page-link' href='#'>Next</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='?page=".($page+1)."'>Next</a></li>";
			}
			
			echo "<ul></nav>";
                        
                        
include './theme/footer.php';?>