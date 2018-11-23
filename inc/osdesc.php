<?php 

/*********************************************

Online OSP Guide for the Lorien Trust LRP System

Development by Jonathan Kane on behalf of the Tarantula Faction
Enquiries to jon.kane@msdl.net

*********************************************/


class OSdb extends SQLite3{
	function __construct(){
		$this->open('osp.sqlite');
	}
}

$db = new OSdb();
if (!$db) {echo "Database Error";}


$osdesc = $db->query("SELECT * FROM osdesc WHERE rowid='" . $_GET['os'] . "'");
$oscost = $db->query("SELECT * FROM oslist WHERE osid='" . $_GET['os'] . "'");
$row=$osdesc->fetchArray(SQLITE3_ASSOC);
$row2=$oscost->fetchArray(SQLITE3_ASSOC);
$prelist = $db->query("SELECT * FROM oslist WHERE id='" .$row2['prereq']."'");
$prename = $prelist->fetchArray(SQLITE3_ASSOC);
?>

<head><title><?php echo $row['name'] ?> </title></head><body>
<div style="position:static; float:right; padding:15px; margin-left:15px; margin-bottom:15px; border:1px solid black; border-radius:10px; box-shadow: 5px 5px 15px 5px #888888;">
Tier <?php echo $row2['tier']; ?><br/>
<?php echo $row2['cost']; ?> OSPs<br/>
<?php if (isset ($prename['os'])){ echo "<span style=\"font-size:x-small;margin-top:-10px;color:red;\">Pre-Requisite<br/>" . $prename['os'] . "</span>"; }?>
</div>
<?php
if ($row2['restrict'] == true){ echo " <span style=\"color:red;font-size:x-small;\">RESTRICTED SKILL</span>";}
echo "<h3 style=\"margin-top:0px;\">" . $row2['os'] ."</h3>";
echo "<div style=\"text-align:justify;font-size:small;\">" .$row['desc'] . "</div>";
?></div>

