<?php 
include('dbConnect.php');

$op = 'none';
if(isset($_GET['op'])) {
    $op = $_GET['op'];
}

if($op == 'checklogin'){
    checklogin($_POST['username'], $_POST['password']);
}

if($op == 'logout'){
    logout();
}
if($op == 'newplayer'){
    insertnewplayer();
}
if($op =='deleteplayer'){
    deleteplayer();
}
if($op == 'editscore'){
    editscore();
}
if ($op === 'scorechange') {
    $winnerid = $_POST['winner'];
    $fanCount = $_POST['fanCount'];
    $winType = $_POST['winType'];

    if ($winType === 'discard') {
        $loserid = $_POST['loser_single']; 
        discardscore($winnerid, $fanCount, $loserid);
    } 
    elseif ($winType === 'selfdraw') {
        $loserids = $_POST['loser_multiple']; 
        selfdraw($winnerid, $fanCount, $loserids);

    }

}


function discardscore($winnerid, $fanCount, $loserid){
    global $dbConnection;

    // 1) Retrieve the discard score from fan_table
    $query  = "SELECT `score_discard` FROM `fan_table` WHERE `fan_count`={$fanCount}";
    $result = mysqli_query($dbConnection, $query);
    
    // Fetch the row
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
       
        header("Location: index.php");
        exit;
    }
    
    // The actual numeric value
    $discardscore = $row['score_discard'];

    // 2) Update the winner
    $sql1 = "UPDATE `player_table` 
             SET `score` = `score` + {$discardscore} 
             WHERE `player_id` = {$winnerid}";
    mysqli_query($dbConnection, $sql1);

    // 3) Update the loser
    $sql2 = "UPDATE `player_table` 
             SET `score` = `score` - {$discardscore} 
             WHERE `player_id` = {$loserid}";
    mysqli_query($dbConnection, $sql2);

    // 4) Redirect
    header("Location: index.php");
    exit;
}
function selfdraw($winnerid, $fanCount, $loserids){
    global $dbConnection;
    $query = "SELECT `score_self_drawn` FROM `fan_table` WHERE `fan_count`={$fanCount}";
    $result = mysqli_query($dbConnection, $query);

    $row = mysqli_fetch_assoc($result);

    $selfdrawnscore = $row["score_self_drawn"];

    $selfdrawnscore_loser = $selfdrawnscore/3;

    foreach ($loserids as $loserid) {
        $loserid = (int)$loserid; // cast to int for safety

        // Update DB: subtract the portion from each loser
        $sqlLoser = "UPDATE `player_table`
                     SET `score` = `score` - {$selfdrawnscore_loser }
                     WHERE `player_id` = {$loserid}";
        mysqli_query($dbConnection, $sqlLoser);
    }

    
    $sql1 = "UPDATE `player_table` 
    SET `score` = `score` + {$selfdrawnscore} 
    WHERE `player_id` = {$winnerid}";
    mysqli_query($dbConnection, $sql1);
    
// 4) Redirect
header("Location: index.php");
exit;
}

function checklogin($username, $password){
    global $dbConnection;
    $staffs = mysqli_query($dbConnection, "SELECT * FROM `admin`");

    $staff = mysqli_fetch_assoc($staffs);
    if($username == $staff['username'] && $password == $staff['password']){

        //Vertify if it's the admin
        session_start();
        $_SESSION['username'] = $username;
        header('Location: index.php');
    } else {
        echo "Invalid username or password";
        header('Location: login.php');
    }
}

function logout(){
    session_start();
    session_destroy();
    header('Location: login.php');
}

function insertnewplayer() {
    global $dbConnection;

    // 1) Build a proper SQL string
    if($_POST['score']){
        $sql = "INSERT INTO `player_table`(`name`, `score`) VALUES ('{$_POST['newplayer']}', {$_POST['score']})";
    }
    else{
    $sql = "INSERT INTO `player_table`(`name`, `score`) VALUES ('{$_POST['newplayer']}', 0)";
    }

    // 2) Execute
    if (mysqli_query($dbConnection, $sql)) {
        // Success: redirect somewhere (index.php, for example)
    
        header("Location: index.php");
        echo '<script>alert("Success!");</script>';
    } else {
        
        echo '<script>alert("Insertion not successful, please try again");</script>';
        header("Location: index.php");
        exit;
    }
}

function deleteplayer(){
    global $dbConnection;

    $sql = "DELETE FROM `player_table` WHERE `player_table`.`player_id`={$_POST['player']}";

    if (mysqli_query($dbConnection, $sql)) {
        // Success: redirect somewhere (index.php, for example)
    
        header("Location: index.php");
        echo '<script>alert("Success!");</script>';
    } else {
        
        echo '<script>alert("Insertion not successful, please try again");</script>';
        header("Location: index.php");
        exit;
    }
}

function editscore(){
    global $dbConnection;

    $sql ="UPDATE `player_table` SET `score` = {$_POST['newscore']} WHERE `player_table`.`player_id` = {$_POST['player']};";

    if (mysqli_query($dbConnection, $sql)) {
        // Success: redirect somewhere (index.php, for example)
    
        header("Location: index.php");
        echo '<script>alert("Success!");</script>';
    } else {
        
        echo '<script>alert("Insertion not successful, please try again");</script>';
        header("Location: index.php");
        exit;
    }
}