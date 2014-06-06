<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<meta http-equiv="refresh">
<link href="http://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet" type="text/css">
<style>
*{
font-family: 'Permanent Marker';font-weight:bold;
}
body{
background-color:#858585; margin:0px; margin-top:0px; padding:0px; border:0px; outline:0px; 
background-image:url('wallTexture2.png');
}
#mainDiv{background:white;height:100%;
background: -webkit-linear-gradient(left, white 0%, #999999 150%);
background: -o-linear-gradient(left, white 0%, #999999 150%);
background: -moz-linear-gradient(left, white 0%, #cccccc 150%);
background: linear-gradient(left, white 0%, #999999 150%);
}
#container{margin:0px;margin-top:0px;padding:0px; border:0px; outline:0px;}
#header{
color:white; text-align:center; vertical-align:top; background:transparent;
margin-top:-25px; margin-left:0px; margin-right:0px;padding:0px; border:0px; outline:0px;}
table{border-width:0px; text-align: left; width: 100%;}
th{color:#000045; border-color:#541111; border-width:4px; background-color:white; border-radius:4px; text-align:center; }
td{font-size: 22px; border-width:0px; background:transparent; color:black; text-align:center; }
#navigationElements tr td{border-width:0px; text-align:center;}
select{
color:#cccccc; background:transparent;border-width:0px;font-size:20px;
}
select option{
color:#cccccc; background:transparent;text-align:center;
}
input{
width:100%;height:100%;border-width:0px;background:transparent;color:purple; text-align:center;font-size: 22px;font-weight:bold;
}
#submitButton{
	width:100%;position:absolute;text-align:center;background:transparent;color:black;padding-top:0.2em;padding-bottom:0.2em;
}
#submit{
color:black;
}
#submit:hover{
	color:red;
}
#autoCompleteButton{
	width:100%;position:absolute;text-align:center;background:#afafaf;color:black;padding-top:0.2em;padding-bottom:0.2em;margin-top:-5px;
}
#autoCompleteButton:hover{
	background:orange;
}
#navigationElements tr td.delete{
background-color:#772525;color:white;width:2.5%;
}
#navigationElements tr td.delete:hover{
background:#cc4444;
}
#navigationElements tr td.add{
background-color:#257725;color:white;width:2.5%;
}
#navigationElements tr td.add:hover{
background:#44cc44;
}
#titles2{font-size:24px;font-weight:bold;padding-top:0.5em;padding-bottom:0.5em;}
#leftTitle2{
	width:100%;position:absolute;text-align:center;background:transparent;color:blue;
}
#leftTitle2:hover{
	color:red;
}
h1{
background-image:url('kanyeHeaderNewProof.png');background-size:100% 100%;
text-align:center;
}
</style>
<title>Add Kanye Proof</title>
<meta content="blendTrans(Duration=1.0)" http-equiv="Page-Enter">
</head>
<body>
<div id="logo" style="position:absolute;margin-top:25px;">
<img src="kanyeProofLogoInvert.png" style="height:100px;width:100px;">
</div>
<div id="container">
<div id="header">
<br>
<br>
<img id="headerTitle" src="kanyeHeaderNewProof.png" style="height:75px;width:500px;">
<br>
<br>
</div>
<div id="mainDiv">
<img id="headerTitle" src="whiteboardBorder.png" style="width:100%;height:30px;">
<div id="titles2">
<a href="http://localhost/kanyeLinking/kanyeWeb.php" style="text-decoration:none;">
<div id="leftTitle2">
<- Back to Kanye Proof Search Engine
</div>
</a>
</div>
<br><br>
<form action="submitKanyeProof.php" method="post">
<div id="navigation" style="width:100%;text-align:center;">
<table id="navigationElements" style="margin-top:1%;">
<tr><td style="width:95%"><input name="0" class="nodes" onkeyup="checkAutocomplete(this);" placeholder="(word/phrase to link to Kanye)"></input></td><td class="add" style="width:5%;" colspan="2" onclick="addNode(1);">+</td></tr>
<!--<tr><td><input></input></td><td class="delete">-</td><td class="add">+</td></tr>
<tr><td><input></input></td><td class="delete">-</td><td class="add">+</td></tr>-->
<tr><td colspan="3">Kanye</td></tr><input style="display:none;" name="1" value="Kanye"></input><input style="display:none;" name="numWords" value="2"></input>
</table>
</div>
<br>
<div id="submitButton">
<input id="submit" type="submit" value="Submit Proof" style="background:transparent;width:100%;height:100%;"></input>
</div>
<br><br><br>
<div id="autoCompleteButton" style="display:none;" onclick="autocompleteProof();">
<input value="Autocomplete Proof" style="background:transparent;width:100%;height:100%;color:black;"></input>
</div>
</form>
</div>
</div>
<script type="text/javascript">

var words = new Array();
var links = new Array();

<?php
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
nodes[0]="";

var autocompleteNode = -1;
var autocompleteWord = -1;
var autocompleteValue = "";

function saveNodeContents(){
	var tableOfLinks = document.getElementsByClassName("nodes");
	for(var i=0; i<tableOfLinks.length; i++){
		nodes[i] = tableOfLinks[i].value;
	}
}

function checkAutocomplete(element){
	saveNodeContents();
	document.getElementById("autoCompleteButton").style.display="none";
	
	autocompleteNode = -1;autocompleteWord = -1;autocompleteValue = "";
	
	for(var i=0; i<nodes.length; i++){
		for(var j=0; j<words.length; j++){
			if(nodes[i].replace(/\s/g, '').toUpperCase() == words[j].replace(/\s/g, '').toUpperCase()){
				autocompleteValue = words[j];
				autocompleteNode = i;autocompleteWord = j;
				i+=nodes.length+1;j+=words.length+1;
			}
		}
	}
	
	if(autocompleteNode != -1){
		document.getElementById("autoCompleteButton").style.display="block";
	}
}

//When the autocomplete button is clicked
function autocompleteProof(){

	nodes.splice(autocompleteNode+1, nodes.length-(autocompleteNode+1));

	var currWord = links[autocompleteWord][0].replace(/\s/g, '');
	var fullCurrWord = links[autocompleteWord][0];
	while(currWord != "Kanye"){
		for(var i=0; i<words.length; i++){
			if(words[i].replace(/\s/g, '').toUpperCase() == currWord.toUpperCase()){ 
				nodes.splice(nodes.length, 0, fullCurrWord);
				currWord = links[i][0].replace(/\s/g, '');
				fullCurrWord = links[i][0];
				i += words.length+1;
			}
		}
	}

	drawTableOfLinks();
}

function addNode(index){
	saveNodeContents();
	nodes.splice(index, 0, "New Word");
	drawTableOfLinks();
}

function deleteNode(index){
	saveNodeContents();
	nodes.splice(index, 1);
	drawTableOfLinks();
}

var innerTable="";
function drawTableOfLinks(){
	
	innerTable="<tr><td style=\"width:95%\"><input name=\"0\" class=\"nodes\" value=\""+nodes[0]+"\" onkeyup=\"checkAutocomplete(this);\"></input></td><td class=\"add\" style=\"width:5%;\" colspan=\"2\" onclick=\"addNode(1);\">+</td></tr>"; 
	
	for(var i=1; i<nodes.length; i++){
		innerTable = innerTable + "<tr><td><input name=\""+i+"\" class=\"nodes\" value=\""+nodes[i]+"\" onkeyup=\"checkAutocomplete(this);\"></input></td><td class=\"delete\" onclick=\"deleteNode("+(i)+");\">-</td><td class=\"add\" onclick=\"addNode("+(i+1)+");\">+</td></tr>";
	}
	
	innerTable = innerTable + "<tr><td colspan=\"3\">Kanye</td></tr><input style=\"display:none;\" name=\""+nodes.length+"\" value=\"Kanye\"></input><input style=\"display:none;\" name=\"numWords\" value=\""+(nodes.length+1)+"\"></input>";
	
	document.getElementById("navigationElements").innerHTML = innerTable;
}

</script>
</body>
</html>

<!-- 
make autocomplete button disappear after autocompleting 
make checks case-insensitive
-->
