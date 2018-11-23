<!doctype html>
<html lang="en">
<?php

/*********************************************

Online OSP Guide for the Lorien Trust LRP System

Development by Jonathan Kane on behalf of the Tarantula Faction
Enquiries to jon.kane@msdl.net

*********************************************/

?>
<head>
	<meta charset="utf-8">
	<title>Occupational Skills</title>
	<link rel="stylesheet" href="themes/black-tie/jquery.ui.all.css">
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.ui.tabs.js"></script>
	<script src="js/jquery.ui.mouse.js"></script>
	<script src="js/jquery.ui.draggable.js"></script>
	<script src="js/jquery.ui.position.js"></script>
	<script src="js/jquery.ui.resizable.js"></script>
	<script src="js/jquery.ui.button.js"></script>
	<script src="js/jquery.ui.dialog.js"></script>
	<script>
	$(function() {
		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		});
	$(function (){
        $('a.ajax').click(function() {
            var url = this.href;
            // show a spinner or something via css
            var dialog = $('<div style="display:none" class="loading"></div>').appendTo('body');
            // open the dialog
			
			dialog.dialog({
				
                // add a close listener to prevent adding multiple divs to the document
                close: function(event, ui) {
                    // remove div with all data and events
                    dialog.remove();
				
                },
                modal: true,
				width: '600',
				title: 'Occupational Skill Description ',
				
				});
            // load remote content
			
            dialog.load(
				url, 
                {}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
                function (responseText, textStatus, XMLHttpRequest) {
                    // remove the loading class
                    dialog.removeClass('loading');
                }
            );
			//prevent the browser to follow the link
            return false;
			
        });
		
    });
	$(document).ready(function()
{
  $("tr:odd").css("background-color", "#e3e3e3");
});
	</script>
	  <style>
  .ui-tabs-vertical { width: auto; }
  .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: left; width: auto;}
  </style>
</head>
<body>
<?php 
class OSdb extends SQLite3{
	function __construct(){
		$this->open('inc/osp.sqlite');
	}
}
$db = new OSdb();
if (!$db) {echo "Database Error";}

function os_table($list){
		global $db;
		$oslist = $db->query("SELECT * FROM oslist WHERE list LIKE '%" . $list ."%' ORDER BY pri");
		echo "<table width=\"100%\">";
		echo "<th class=\"th-left\">Skill Name</th><th>Tier</th><th>Cost</th><th class=\"th-right\" style=\"text-align:left;padding-left:30px;\">Pre-requisite</th>";
		while($row=$oslist->fetchArray(SQLITE3_ASSOC)){
			echo "<tr><td><a title=\"". $row['os'] ."\" href=\"inc/osdesc.php?os=" . $row['osid'] ."\" class=\"ajax\">" . $row['os'] . "</a>";
			if ($row['restrict'] == true){ echo " <span style=\"color:red;font-size:x-small;\">RESTRICTED SKILL</span>";}
			echo "</td><td class=\"tier\">" . $row['tier'] . "</td>";
			echo "<td class=\"cost\">" . $row['cost'] . "</td>";
			$prelist = $db->query("SELECT * FROM oslist WHERE id='" .$row['prereq']."'");
			$prename = $prelist->fetchArray(SQLITE3_ASSOC);
			echo "<td class=\"pre\">" . $prename['os'] . "</td></tr>";
		}
		echo "</table>";
}

?>


<div id="tabs">
	<ul>
		<li><a href="#generic">Generic</a></li>
		<li><a href="#alchemists">Alchemists</a></li>
		<li><a href="#archers">Archers</a></li>
		<li><a href="#armourers">Armourers</a></li>
		<li><a href="#bards">Bards</a></li>
		<li><a href="#healers">Healers</a></li>
		<li><a href="#incantors">Incantors</a></li>
		<li><a href="#mages">Mages</a></li>
		<li><a href="#militia">Militia</a></li>
		<li><a href="#scouts">Scouts</a></li>
		<li><a href="#knowledge">Knowledge Guilds</a></li>
		<li><a href="#magic">Magic Guilds</a></li>
		<li><a href="#martial">Martial Guilds</a></li>
	</ul>
	<div id="generic">
		<?php os_table("generic");		?>
	</div>

	<div id="alchemists">
		<?php os_table("alchemists");	?>
	</div>
	<div id="archers">
		<?php os_table("archers");	?>
	</div>
	<div id="armourers">
		<?php os_table("armourers");	?>
	</div>
		<div id="bards">
		<?php os_table("bards");	?>
	</div>
	<div id="healers">
		<?php os_table("healers");	?>
	</div>
	<div id="incantors">
		<?php os_table("incantors");	?>
	</div>
	<div id="mages">
		<?php os_table("mages");	?>
	</div>
	<div id="militia">
		<?php os_table("militia");	?>
	</div>
	<div id="scouts">
		<?php os_table("scouts");	?>
	</div>
	<div id="knowledge">
		<?php os_table("knowledge");	?>
	</div>
	<div id="magic">
		<?php os_table("magic");	?>
	</div>
	<div id="martial">
		<?php os_table("martial");	?>
	</div>
</div>

<div>
<p><small>This guide contains the current Occupational Skills available in the Lorien Trust LRP system. The copyright to the text used in this guide belongs to Lorien Trust.<br/> Many restricted skills can not be listed here. This guide should only be used as a reference, and for the sake of rules clarity you should always refer to the official guide published by the <a href="http://www.lorientrust.com">Lorien Trust</a>.</small></p>
</div>
</body>
</html>
