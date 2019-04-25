<?php
/*
results page

Session vars to get user inputs and results from query.php, different results array indicies represent
unoccupied, part occupied, and full occupied gRNAs.

Split values from gRNA string arrays strings in subarrays for printing each individual element
*/
$pageTitle = "Query Results";
include("inc/header.php");
include("classes/query.php");

$results = $_SESSION['results'];
$userInput = $_SESSION['userInput'];
$siteSelection = $_SESSION['siteSelection'];
$filterMethod = $_SESSION['filterMethod'];

$resUnOc = $results[0];
$resPrtOc = $results[1];
$resFullOc = $results[2];

$resUn = preg_split("/\\\\t/", $resUnOc, NULL, PREG_SPLIT_NO_EMPTY);
$resPrt = preg_split("/\\\\t/", $resPrtOc, NULL, PREG_SPLIT_NO_EMPTY);
$resFull = preg_split("/\\\\t/", $resFullOc, NULL, PREG_SPLIT_NO_EMPTY);

$noUnOcc = count($resUn);
$noPrtOcc = count($resPrt);
$noFullOcc = count($resFull);

$Un = array();
$Prt = array();
$Full = array();

for ($a = 0; $a < count($resUn); $a++) {
    $thing = $resUn[$a];
    $thing2 = preg_split('/\t/', $thing, -1, PREG_SPLIT_NO_EMPTY);
    array_push($Un, $thing2);
}

for ($b = 0; $b < count($resPrt); $b++) {
    $thing = $resPrt[$b];
    $thing2 = preg_split('/\t/', $thing, -1, PREG_SPLIT_NO_EMPTY);
    array_push($Prt, $thing2);
}

for ($c = 0; $c < count($resFull); $c++) {
    $thing = $resFull[$c];
    $thing2 = preg_split('/\t/', $thing, -1, PREG_SPLIT_NO_EMPTY);
    array_push($Full, $thing2);
}

?>

<section>
    <meta http-equiv="Content-Language" content="en"> <!-- google really wanted this page to be in Somali -->
    <?php if ($results == null) {
        echo "<div align='middle'><h1> Oops! Looks like there's an issue with your input. Please check formating and resubmit search. </h1></div>";
    }
    ?>


<?php if ($siteSelection == 'chopchop') { ?>
  <div align="middle" id="extra" <?php if ($noUnOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Highly Accessible Targets:
    <th rowspan="2"><?php echo "Original Rank"; ?></th>
    <th rowspan="2"><?php echo "New Rank"; ?></th>
    <th rowspan="2"><?php echo "Sequence"; ?></th>
    <th rowspan="2"><?php echo "Chromosome"; ?></th>
    <th rowspan="2"><?php echo "Location"; ?></th>
    <th rowspan="2"><?php echo "Exon"; ?></th>
    <th rowspan="2"><?php echo "Strand"; ?></th>
    <th rowspan="2"><?php echo "GC %"; ?></th>
    <th rowspan="2"><?php echo "Self Complementary"; ?></th>
    <th colspan="4"><?php echo "Off-targets"; ?></th>
    <th rowspan="2"><?php echo "Efficiency"; ?></th>
  </tr>
  <tr>
  <th>1</th>
  <th>2</th>
  <th>3</th>
  <th>4</th>
 </tr>
  <?php for ($i = 0; $i < $noUnOcc; $i++) { ?>
  <tr>
    <td>&emsp;<?php echo $Un[$i][0]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][1]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][2]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][3]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][4]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][5]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][6]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][7]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][8]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][9]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][10]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][11]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][12]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][13]; ?>&nbsp;</td>
  </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noPrtOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Partially Accessible Targets:
      <th rowspan="2"><?php echo "Original Rank"; ?></th>
      <th rowspan="2"><?php echo "New Rank"; ?></th>
      <th rowspan="2"><?php echo "Sequence"; ?></th>
      <th rowspan="2"><?php echo "Chromosome"; ?></th>
      <th rowspan="2"><?php echo "Location"; ?></th>
      <th rowspan="2"><?php echo "Exon"; ?></th>
      <th rowspan="2"><?php echo "Strand"; ?></th>
      <th rowspan="2"><?php echo "GC %"; ?></th>
      <th rowspan="2"><?php echo "Self Complementary"; ?></th>
      <th colspan="4"><?php echo "Off-targets"; ?></th>
      <th rowspan="2"><?php echo "Efficiency"; ?></th>
  </tr>
  <tr>
  <th>1</th>
  <th>2</th>
  <th>3</th>
  <th>4</th>
 </tr>
  <?php for ($j = 0; $j < $noPrtOcc; $j++) { ?>
    <tr>
        <td>&emsp;<?php echo $Prt[$j][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][4]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][5]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][6]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][7]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][8]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][9]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][10]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][11]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][12]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][13]; ?>&nbsp;</td>
    </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noFullOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Lowly Accessible Targets:
      <th rowspan="2"><?php echo "Original Rank"; ?></th>
      <th rowspan="2"><?php echo "New Rank"; ?></th>
      <th rowspan="2"><?php echo "Sequence"; ?></th>
      <th rowspan="2"><?php echo "Chromosome"; ?></th>
      <th rowspan="2"><?php echo "Location"; ?></th>
      <th rowspan="2"><?php echo "Exon"; ?></th>
      <th rowspan="2"><?php echo "Strand"; ?></th>
      <th rowspan="2"><?php echo "GC %"; ?></th>
      <th rowspan="2"><?php echo "Self Complementary"; ?></th>
      <th colspan="4"><?php echo "Off-targets"; ?></th>
      <th rowspan="2"><?php echo "Efficiency"; ?></th>
  </tr>
  <tr>
  <th>1</th>
  <th>2</th>
  <th>3</th>
  <th>4</th>
 </tr>
  <?php for ($k = 0; $k < $noFullOcc; $k++) { ?>
    <tr>
        <td>&emsp;<?php echo $Full[$k][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][4]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][5]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][6]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][7]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][8]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][9]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][10]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][11]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][12]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][13]; ?>&nbsp;</td>
    </tr>
    <?php } ?>
</table>
</div>
<?php } elseif ($siteSelection == 'crispr-era') { ?>
  <div align="middle" id="extra" <?php if ($noUnOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Highly Accessible Targets:
      <th rowspan="1"><?php echo "Original Rank"; ?></th>
      <th rowspan="1"><?php echo "New Rank"; ?></th>
      <th rowspan="1"><?php echo "Sequence"; ?></th>
      <th rowspan="1"><?php echo "Chromosome"; ?></th>
      <th rowspan="1"><?php echo "Location"; ?></th>
      <th rowspan="1"><?php echo "Strand"; ?></th>
      <th rowspan="1"><?php echo "E Score"; ?></th>
      <th rowspan="1"><?php echo "S Score"; ?></th>
      <th rowspan="1"><?php echo "E + S Score"; ?></th>
  </tr>
  <?php for ($i = 0; $i < $noUnOcc; $i++) { ?>
  <tr>
    <td>&emsp;<?php echo $Un[$i][0]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][1]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][2]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][3]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][4]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][5]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][6]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][7]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][8]; ?>&nbsp;</td>
  </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noPrtOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Partially Accessible Targets:
      <th rowspan="1"><?php echo "Original Rank"; ?></th>
      <th rowspan="1"><?php echo "New Rank"; ?></th>
      <th rowspan="1"><?php echo "Sequence"; ?></th>
      <th rowspan="1"><?php echo "Chromosome"; ?></th>
      <th rowspan="1"><?php echo "Location"; ?></th>
      <th rowspan="1"><?php echo "Strand"; ?></th>
      <th rowspan="1"><?php echo "E Score"; ?></th>
      <th rowspan="1"><?php echo "S Score"; ?></th>
      <th rowspan="1"><?php echo "E + S Score"; ?></th>
  </tr>
  <?php for ($j = 0; $j < $noPrtOcc; $j++) { ?>
    <tr>
        <td>&emsp;<?php echo $Prt[$j][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][4]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][5]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][6]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][7]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][8]; ?>&nbsp;</td>
    </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noFullOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Lowly Accessible Targets:
      <th rowspan="1"><?php echo "Original Rank"; ?></th>
      <th rowspan="1"><?php echo "New Rank"; ?></th>
      <th rowspan="1"><?php echo "Sequence"; ?></th>
      <th rowspan="1"><?php echo "Chromosome"; ?></th>
      <th rowspan="1"><?php echo "Location"; ?></th>
      <th rowspan="1"><?php echo "Strand"; ?></th>
      <th rowspan="1"><?php echo "E Score"; ?></th>
      <th rowspan="1"><?php echo "S Score"; ?></th>
      <th rowspan="1"><?php echo "E + S Score"; ?></th>
  </tr>
  <?php for ($k = 0; $k < $noFullOcc; $k++) { ?>
    <tr>
        <td>&emsp;<?php echo $Full[$k][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][4]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][5]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][6]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][7]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][8]; ?>&nbsp;</td>
    </tr>
    <?php } ?>
</table>
</div>
<?php } elseif ($siteSelection == 'e-crisp') { ?>
  <div align="middle" id="extra" <?php if ($noUnOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Highly Accessible Targets:
    <th rowspan="1"><?php echo "Original Rank"; ?></th>
    <th rowspan="1"><?php echo "New Rank"; ?></th>
    <th rowspan="1"><?php echo "Sequence"; ?></th>
    <th rowspan="1"><?php echo "Chromosome"; ?></th>
    <th rowspan="1"><?php echo "Location"; ?></th>
    <th rowspan="1"><?php echo "Strand"; ?></th>
  </tr>

  <?php for ($i = 0; $i < $noUnOcc; $i++) { ?>
  <tr>
    <td>&emsp;<?php echo $Un[$i][0]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][1]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][2]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][3]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][4]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][5]; ?>&nbsp;</td>
  </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noPrtOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Partially Accessible Targets:
      <th rowspan="1"><?php echo "Original Rank"; ?></th>
      <th rowspan="1"><?php echo "New Rank"; ?></th>
      <th rowspan="1"><?php echo "Sequence"; ?></th>
      <th rowspan="1"><?php echo "Chromosome"; ?></th>
      <th rowspan="1"><?php echo "Location"; ?></th>
      <th rowspan="1"><?php echo "Strand"; ?></th>
  </tr>
  <?php for ($j = 0; $j < $noPrtOcc; $j++) { ?>
    <tr>
        <td>&emsp;<?php echo $Prt[$j][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][4]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][5]; ?>&nbsp;</td>
    </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noFullOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Lowly Accessible Targets:
      <th rowspan="1"><?php echo "Original Rank"; ?></th>
      <th rowspan="1"><?php echo "New Rank"; ?></th>
      <th rowspan="1"><?php echo "Sequence"; ?></th>
      <th rowspan="1"><?php echo "Chromosome"; ?></th>
      <th rowspan="1"><?php echo "Location"; ?></th>
      <th rowspan="1"><?php echo "Strand"; ?></th>
  </tr>
  <?php for ($k = 0; $k < $noFullOcc; $k++) { ?>
    <tr>
        <td>&emsp;<?php echo $Full[$k][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][4]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][5]; ?>&nbsp;</td>
    </tr>
    <?php } ?>
</table>
</div>
<?php } elseif ($siteSelection == 'use_my_own') { ?>
  <div align="middle" id="extra" <?php if ($noUnOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Highly Accessible Targets:
    <th rowspan="1"><?php echo "Original Rank"; ?></th>
    <th rowspan="1"><?php echo "New Rank"; ?></th>
    <th rowspan="1"><?php echo "Sequence"; ?></th>
    <th rowspan="1"><?php echo "Chromosome"; ?></th>
    <th rowspan="1"><?php echo "Location"; ?></th>
  </tr>
  <?php for ($i = 0; $i < $noUnOcc; $i++) { ?>
  <tr>
    <td>&emsp;<?php echo $Un[$i][0]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][1]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][2]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][3]; ?>&nbsp;</td>
    <td>&emsp;<?php echo $Un[$i][4]; ?>&nbsp;</td>
  </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noPrtOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Partially Accessible Targets:
      <th rowspan="1"><?php echo "Original Rank"; ?></th>
      <th rowspan="1"><?php echo "New Rank"; ?></th>
      <th rowspan="1"><?php echo "Sequence"; ?></th>
      <th rowspan="1"><?php echo "Chromosome"; ?></th>
      <th rowspan="1"><?php echo "Location"; ?></th>
  </tr>
  <?php for ($j = 0; $j < $noPrtOcc; $j++) { ?>
    <tr>
        <td>&emsp;<?php echo $Prt[$j][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Prt[$j][4]; ?>&nbsp;</td>
    </tr>
<?php } ?>
</table>
</div>
  <div align="middle" id="extra" <?php if ($noFullOcc == 0){ echo 'style="display:none;"'; } ?>>
  <table style="width:80%" id="extratiny">
  <tr>Lowly Accessible Targets:
      <th rowspan="1"><?php echo "Original Rank"; ?></th>
      <th rowspan="1"><?php echo "New Rank"; ?></th>
      <th rowspan="1"><?php echo "Sequence"; ?></th>
      <th rowspan="1"><?php echo "Chromosome"; ?></th>
      <th rowspan="1"><?php echo "Location"; ?></th>
  </tr>
  <?php for ($k = 0; $k < $noFullOcc; $k++) { ?>
    <tr>
        <td>&emsp;<?php echo $Full[$k][0]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][1]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][2]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][3]; ?>&nbsp;</td>
        <td>&emsp;<?php echo $Full[$k][4]; ?>&nbsp;</td>
    </tr>
    <?php } ?>
</table>
</div>
<?php } else {
    echo "Bad site selection, how'd you do that?";
}?>
<div id="padder">
</div>
  </section>

  <?php
  include("inc/footer.php");
  ?>
