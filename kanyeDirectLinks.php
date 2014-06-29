<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<meta http-equiv="refresh">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<link href="http://fonts.googleapis.com/css?family=Righteous" rel="stylesheet" type="text/css">
<style>
body{
background-color:#ffdf00; margin:0px; margin-top:0px; padding:0px; border:0px; outline:0px;font-family:'righteous'; 
}
#container{margin:0px;margin-top:0px;padding:0px; border:0px; outline:0px;}
#header{
color:#f3f3f3; text-align:center; vertical-align:top; background-color:#34ab00; 
margin-top:-25px; margin-left:0px; margin-right:0px;padding:0px; border:0px; outline:0px;}
table{border-width:0px; text-align: left; width: 100%;}
th{color:#000045; border-color:#541111; border-width:4px; background-color:white; border-radius:4px; text-align:center; }
td{font-size: 18px; border-width:0px; background:#cfcfcf; color:black; text-align:center; }
#navigationElements tr td{font-size: 18px; border-width:0px; background:#252525;color:white; text-align:center;}
select{
color:#cccccc; background:#252525;border-width:0px;font-size:20px;
}
select option{
color:#cccccc; background:#252525;text-align:center;
}
input{
width:100%;height:100%;border-width:0px;background:#252525;color:white; text-align:center;font-size: 20px;font-weight:normal;
font-family:'righteous';
}
#submitButton{
	width:100%;position:absolute;text-align:center;background:#afafaf;color:black;padding-top:0.2em;padding-bottom:0.2em;
}
#submitButton:hover{
	background:#ff68dd;
}
#autoCompleteButton{
	width:100%;position:absolute;text-align:center;background:#afafaf;color:black;padding-top:0.2em;padding-bottom:0.2em;margin-top:-5px;
}
#autoCompleteButton:hover{
	background:orange;
}
#navigationElements tr td.delete{
background-color:#d62323;color:white;width:2.5%;
cursor:pointer;
}
#navigationElements tr td.delete:hover{
background:#e63131;
}
#navigationElements tr td.add{
background-color:#257725;color:white;width:2.5%;
}
#navigationElements tr td.add:hover{
background:#44cc44;
}
#titles2{font-size:24px;font-weight:bold;padding-top:0.5em;padding-bottom:0.5em;}
#leftTitle2{
	width:100%;position:absolute;text-align:center;background:#1b49be;color:#f3f3f3;
}
#leftTitle2:hover{
	background:#872187;
}

.ui-autocomplete{
font-family:'righteous';
background:#f3f3f3;
color:#252525;
text-align:center;
}

.ui-autocomplete .ui-menu-item .ui-state-focus{
background:#252525;
color:#f3f3f3;
border-radius:0px;
}

.ui-menu{
background:#f3f3f3;
}
</style>
<title>Add Kanye Proof</title>
<meta content="blendTrans(Duration=1.0)" http-equiv="Page-Enter">
</head>
<body>
<!--
<div id="logo" style="position:absolute;margin-top:25px;">
<img src="kanyeProofLogo.png" style="height:125px;width:125px;">
</div>
-->
<div id="container">
<div id="header">
<br>
<br>
<h1><?php echo $_GET["name"];?></h1>
<br>
</div>
<div id="titles2" style="margin-top:-1%;">
<a href="kanyeWeb.php" style="text-decoration:none;">
<div id="leftTitle2">
Back to Kanye Proof Search Engine
</div>
</a>
</div>
<br><br>
<form action="submitKanyeLinks.php" method="post">
<div id="navigation" style="width:100%;text-align:center;">
<table id="navigationElements" style="margin-top:1%;">
<tr><td style="width:95%"><input name="0" class="nodes"></input></td><td class="add" style="width:5%;" colspan="2" onclick="addNode(1);">+</td></tr>
<!--<tr><td><input></input></td><td class="delete">-</td><td class="add">+</td></tr>
<tr><td><input></input></td><td class="delete">-</td><td class="add">+</td></tr>-->
<tr><td colspan="3">Kanye</td></tr><input style="display:none;" name="1" value="Kanye"></input><input style="display:none;" name="numWords" value="2"></input>
</table>
</div>
<div class="ui-widget" style="height:100px;padding:0em;margin-bottom:-60px;text-align:center;">
<input id="tags" style="height:30px;width:99.75%;padding:0em;font-size:20px;border:0px;font-family:'righteous';text-transform:uppercase;" 
placeholder="Add Links">
</div>
<br>
<div id="submitButton">
<input type="submit" value="Submit Changes" style="background:transparent;width:100%;height:100%;color:black;"></input>
</div>
</form>
</div>
<script type="text/javascript">

var word = "";
var words = new Array();
var links = new Array();

<?php
echo "word = '" . $_GET["name"] . "';";
$handle = fopen("kanyeLinks.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) != false) {
		$tmpLine = explode(";^&#*", $line);
		echo "words.push(" . json_encode($tmpLine[0]) . ");";
		echo "var tmpArray = new Array();";
		array_shift($tmpLine);
		foreach ($tmpLine as $tl){
			echo "tmpArray.push(" . json_encode($tl) . ");";
		}		
		echo "links.push(tmpArray);";
    }
}
else {
		echo "alert('Error parsing database');";
} 
fclose($handle);
?>

var nodes=new Array();

function initNodes(){
	for(var i=0; i<words.length; i++){
		if(words[i] == word){
			for(var j=0; j<links[i].length; j++){
				nodes.push(links[i][j]);
			}
		}
	}
}
initNodes();

function saveNodeContents(){
	var tableOfLinks = document.getElementsByClassName("nodes");
	for(var i=0; i<tableOfLinks.length; i++){
		nodes[i] = tableOfLinks[i].value;
	}
}

function addNode(word){
	saveNodeContents();
	if($.inArray(word, nodes) == -1){
		nodes.push(word);
	}
	drawTableOfLinks();
}

function deleteNode(index){
	saveNodeContents();
	nodes.splice(index, 1);
	drawTableOfLinks();
}

var innerTable="";
function drawTableOfLinks(){
	
	innerTable=""; 
	
	for(var i=0; i<nodes.length-1; i++){
		innerTable = innerTable + "<tr><td><input name=\""+i+"\" class=\"nodes\" value=\""+nodes[i]+"\" onkeyup=\"checkAutocomplete(this);\"></input></td><td class=\"delete\" onclick=\"deleteNode("+(i)+");\" style=\"width:5%;\">-</td></tr>";
	}
	
	innerTable = innerTable + "<tr><td><input name=\""+(nodes.length-1)+"\" class=\"nodes\" value=\""+nodes[(nodes.length-1)]+"\" onkeyup=\"checkAutocomplete(this);\"></input></td><td class=\"delete\" onclick=\"deleteNode("+(nodes.length-1)+");\" style=\"width:5%;\">-</td></tr>";
	innerTable = innerTable + "<input style=\"display:none;\" name=\"numWords\" value=\""+(nodes.length)+"\"></input><input style=\"display:none;\" name=\"word\" value=\""+word+"\"></input>";
	
	document.getElementById("navigationElements").innerHTML = innerTable;
}
drawTableOfLinks();

</script>
 <script>
$(function() {
$( "#tags" ).autocomplete({
source: function(request, response) {
        var results = $.ui.autocomplete.filter(words, request.term);

        response(results.slice(0, 8));
    },
select: function(event, ui) {
	addNode(ui.item.label);
	document.getElementById("tags").value="";
	displayPage();
	return false;
}
});
});
</script>
</body>
</html>
