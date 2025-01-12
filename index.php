<?php include('header.php'); ?>
<style>
table, th, td {
  border:1px solid black;
}
</style>
    <h1>Ranking Board</h1>
    <?php 
    //Get the members name, score and rank from database

    $infos = mysqli_query($dbConnection, "SELECT *, ROW_NUMBER() OVER(ORDER BY score DESC) as rank FROM `player_table`");
   
    ?>
     <table>
  <thead>
    <tr>
      <th class="rank">Rank</th>
      <th class="name">Name</th>
      <th class="score">Score</th>
    </tr>
    <?php
    while ($info = mysqli_fetch_assoc($infos)){
        echo "<tr>";
        echo "<td class='rank'>".$info['rank']."</td>";
        echo "<td class='name'>".$info['name']."</td>";
        echo "<td class='score'>".$info['score']."</td>";
        echo "</tr>";
    }
    ?>
  </thead>
     </table>
  <?php if ($_SESSION): ?>
    <!-- Only show this button if staff is logged in -->
    <div class="staff-buttons">
    <button class="openPopupBtn">Win</button>
    <button class="openPopupBtn">Insert Player</button> 
    <button class="openPopupBtn">Delete player</button>
    <button class="openPopupBtn">Edit Score</button>
    </div>
<?php endif; ?>

<!-- Hidden pop-up wrapper -->

<div class="popupWrapper popup">
  
<div class="popupcontent">
    <h2>Winning!!!!</h2>
    <form action="function.php?op=scorechange" method="POST">
      <!-- Example: choose winner -->
      <label for="winner">Winner:</label><br>
      <select name="winner" id="winner" required>
      <option></option>
      <?php
        // Output all players in dropdown
        $allPlayers = mysqli_query($dbConnection, "SELECT * FROM `player_table`");
        while ($p = mysqli_fetch_assoc($allPlayers)) {
            echo '<option value="'.$p['player_id'].'">'.$p['name'].'</option>';
        }
        ?>
      </select><br><br>

      <!-- Number of Fan -->
      <label for="fanCount">Fan Count:</label><br>
      <input type="number" name="fanCount" id="fanCount" min="3" max="10" required><br><br>

      <!-- Win type -->
      <label for="winType">Type of Win:</label><br>
      <select name="winType" id="winType" required>
        <option>--</option>
        <option value="discard">Discard</option>
        <option value="selfdraw">Self Draw</option>
      </select><br><br>

       <!-- Single-loser (for "discard") -->
       <div id="singleLoserContainer" style="display:none;">
        <label for="loser_single">Loser:</label><br>
        <select name="loser_single" id="loser_single">
          <option value=""></option>
          <?php
            // We can re-run or store the players query in a variable
            $allPlayers2 = mysqli_query($dbConnection, "SELECT * FROM `player_table`");
            while ($p2 = mysqli_fetch_assoc($allPlayers2)) {
                echo '<option value="'.$p2['player_id'].'">'.$p2['name'].'</option>';
            }
          ?>
        </select>
      </div>

      <!-- Multi-loser (for "selfdraw") -->
      <div id="multipleLosersContainer" style="display:none;">
        <label>Loser 1:</label><br>
        <select name="loser_multiple[]" class="multiLoserSelect">
          <option value=""></option>
          <?php
            $allPlayers3 = mysqli_query($dbConnection, "SELECT * FROM `player_table`");
            while ($p3 = mysqli_fetch_assoc($allPlayers3)) {
                echo '<option value="'.$p3['player_id'].'">'.$p3['name'].'</option>';
            }
          ?>
        </select>
        <br><br>

        <label>Loser 2:</label><br>
        <select name="loser_multiple[]" class="multiLoserSelect">
          <option value=""></option>
          <?php
            // You could fetch again or reuse the same players
            $allPlayers4 = mysqli_query($dbConnection, "SELECT * FROM `player_table`");
            while ($p4 = mysqli_fetch_assoc($allPlayers4)) {
                echo '<option value="'.$p4['player_id'].'">'.$p4['name'].'</option>';
            }
          ?>
        </select>
        <br><br>

        <label>Loser 3:</label><br>
        <select name="loser_multiple[]" class="multiLoserSelect">
          <option value=""></option>
          <?php
            $allPlayers5 = mysqli_query($dbConnection, "SELECT * FROM `player_table`");
            while ($p5 = mysqli_fetch_assoc($allPlayers5)) {
                echo '<option value="'.$p5['player_id'].'">'.$p5['name'].'</option>';
            }
          ?>
        </select>
      </div>
      <!-- Possibly choose the discarder if it's "discard" type, or handle in your backend. -->

      <button type="submit">Update Score</button>
      <button type="button" class="closePopupBtn">Cancel</button>
    </form>
  </div>
</div>

<!--Insert New Player-->
<div class ="popupWrapper popup">
<div class= "popupcontent">
  <h2>Insert New Player</h2>
  <form action="function.php?op=newplayer" method = "POST">

  <label for="newplayer">New player:</label>
  <br>
  <input type="text" name="newplayer" id="newplayer" required>
  <br><br>

  <label for="score">Score(Not Required):</label>
  <br>
  <input type="number" name="score" id="score">
  <br><br>

  <button type="sumbit">Enter</button>
  <button type="button" class="closePopupBtn">Cancel</button>
  </form>

</div>
</div>

<!--delete Player-->
<div class="popup popupWrapper">
  <div class="popupcontent">
    <h2>Delete Player</h2>
    <form action="function.php?op=deleteplayer" method="POST">
      <label for="player">Player:</label><br>
      <select name="player" id="player" required>
        <option value=""></option> <!-- empty option -->
        <?php
        // Output all players in dropdown
        $allPlayers = mysqli_query($dbConnection, "SELECT * FROM `player_table`");
        while ($p = mysqli_fetch_assoc($allPlayers)) {
            echo '<option value="'.$p['player_id'].'">'.$p['name'].'</option>';
        }
        ?>
      </select>
      <br><br>
      <button type="submit">Submit</button>
      <button type="button" class="closePopupBtn">Cancel</button>
    </form>
  </div>
</div>

<!--Edit Score-->
<div class="popup popupWrapper">
  <div class="popupcontent">
    <h2>Edit Score</h2>
    <form action="function.php?op=editscore" method="POST">
      <label for="player">Player:</label><br>
      <select name="player" id="player" required>
        <option value=""></option> <!-- empty option -->
        <?php
        // Output all players in dropdown
        $allPlayers = mysqli_query($dbConnection, "SELECT * FROM `player_table`");
        while ($p = mysqli_fetch_assoc($allPlayers)) {
            echo '<option value="'.$p['player_id'].'">'.$p['name'].'</option>';
        }
        ?>
      </select>

      <br><br>

      <label for="newscore">New Score:</label><br>
      <input type="number" name="newscore" id="newscore" required>
      <br><br>

      <button type="submit">Submit</button>
      <button type="button" class="closePopupBtn">Cancel</button>
    </form>
  </div>
</div>



<script src="popup.js"></script>




<?php include('footer.php'); ?>
