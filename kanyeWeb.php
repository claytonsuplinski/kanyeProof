<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<meta http-equiv="refresh">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<style>
body{
background-color:#858585; margin:0px; margin-top:0px; padding:0px; border:0px; outline:0px;font-family:calibri; 
}
#container{margin:0px;margin-top:0px;padding:0px; border:0px; outline:0px;}
#header{
color:white; text-align:center; vertical-align:top; background-color:#545454; background-image:url('kanyeHeaderBackground.png');background-size:100% 100%;background-repeat:no-repeat;
margin-top:-25px; margin-left:0px; margin-right:0px;padding:0px; border:0px; outline:0px;}
#titles, #titles2{font-size:24px;font-weight:bold;padding-top:0.5em;padding-bottom:0.5em;}
table{border-width:0px; text-align: left; width: 100%;}
th{color:#000045; border-color:#541111; border-width:4px; background-color:white; border-radius:4px; text-align:center; }
td{font-size: 18px; border-width:0px; background:#cfcfcf; color:black; text-align:center; }
td:hover{cursor:pointer;}
#navigationElements tr td{font-size: 18px; border-width:0px; background:#333333;color:white; text-align:center;}
select{
color:#cccccc; background:#333333;border-width:0px;font-size:20px;
}
select option{
color:#cccccc; background:#333333;text-align:center;
}
#leftTitle2{
	width:100%;position:absolute;text-align:center;background:#afafaf;color:black;
}
#leftTitle2:hover{
	background:orange;
}
#addDirectLinks:hover{
	background:orange;color:black;
}
#word{
border-radius:15px;margin-left:-15%;margin-right:-15%;padding-left:1em;padding-right:1em;
background: linear-gradient(top, #404040 0%, black 40%);
background: -moz-linear-gradient(top, #404040  0%, black 40%);
background: -webkit-linear-gradient(top, #404040 0%, black  40%);
}
</style>
<title>Kanye Proof Search Engine</title>
<meta content="blendTrans(Duration=1.0)" http-equiv="Page-Enter">
</head>
<body>
<div id="logo" style="position:absolute;margin-top:25px;">
<img src="kanyeProofLogo.png" style="height:125px;width:125px;">
</div>
<div id="container">
<div id="header">
<br>
<br>
<h1><span id="word">[current node in Kanye web]</span><br><br>
<div class="ui-widget" style="height:100px;padding:0em;margin-bottom:-60px;">
<input id="tags" style="height:25px;width:50%;padding:0em;font-size:16px;" placeholder="Search for Kanye Proofs">
</div></h1>
</div>
<div id="titles2">
<a href="http://localhost/kanyeLinking/kanyeProof.php" style="text-decoration:none;">
<div id="leftTitle2">
Add new proof
</div>
</a>
</div>
<br><br>
<div id="titles">
<div id="leftTitle" style="width:50%;position:absolute;text-align:center;background:#333333;color:white;">
Direct Links
</div>
<div id="rightTitle" style="width:50%;margin-left:50%;position:absolute;text-align:center;background:#cfcfcf;color:black;">
Link to Kanye
</div>
</div>
<div id="navigation" style="float:left;width:50%;text-align:center;">
<table id="navigationElements" style="margin-top:10%;">
<tr><td>Node 1</td></tr>
<tr><td>Node 2</td></tr>
<tr><td>Node 3</td></tr>
</table>
</div>
<div id="linkToKanye" style="width:50%;text-align:center;margin-left:50%;">
<table id="linkToKanyeTable" style="margin-top:10%;">
<tr><td>Word 1</td></tr>
<tr><td>Word 2</td></tr>
<tr><td>Kanye</td></tr>
</table>
</div>
</div>

<script type="text/javascript">

var words = new Array();
var links = new Array();

<?php
/*
class Node{
	public $word;
	public $links=array();
}
*/
//$nodes=array();

$handle = fopen("kanyeLinks.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) != false) {
		//echo "alert('here');";
		$tmpLine = explode(";^&#*", $line);
		//$tmpNode = new Node();
		//$tmpNode->word = $tmpLine[0];
		echo "words.push(" . json_encode($tmpLine[0]) . ");";
		echo "var tmpArray = new Array();";
		array_shift($tmpLine);
		foreach ($tmpLine as $tl){
			echo "tmpArray.push(" . json_encode($tl) . ");";
			//array_push($tmpNode->links, $tl);
		}		
		echo "links.push(tmpArray);";
		
		//array_push($nodes, $tmpNode);
       // echo $line . "<br>";
    }
}
else {
		echo "alert('Error parsing database');";
} 
fclose($handle);
/*
foreach ($nodes as $node){
	$allLinks = "";
	$nodeLinks = $node->links;
	foreach ($nodeLinks as $link){
		$allLinks = $allLinks . ", " . $link;
	}
	echo $node->word . ': ' . $allLinks . "<br>";
}*/
?>

var currNode = Math.floor((Math.random() * (words.length-1)) + 0); ;

/*for(var i=0; i<words.length; i++){
	alert(words[i]);
}
for(var i=0; i<links.length; i++){
	var tmpStr = "";
	for(var j=0; j<links[i].length; j++){
		tmpStr = tmpStr + " " + links[i][j];
	}
	alert(tmpStr);
}*/

function updateNodeIndex(word){
	for(var i=0; i<words.length; i++){
		if(words[i].replace(/\s/g, '') == word.replace(/\s/g, '')){
			currNode = i;
		}
	}
}

function getKanyeProof(wordIndex){

	var infLoopCheck = 0;
	
	document.getElementById("word").innerHTML = words[wordIndex];

	var innerTable="<tr><td onclick=\"displayAfterElementLink(this);\">" + words[wordIndex] + "</td></tr>";
	innerTable= innerTable + "<tr><td onclick=\"displayAfterElementLink(this);\">" + links[wordIndex][0] + "</td></tr>";
	var currWord = links[wordIndex][0].replace(/\s/g, '');
	while(currWord != "Kanye".toUpperCase() && infLoopCheck < 100){
		for(var i=0; i<words.length; i++){
			if(words[i].replace(/\s/g, '') == currWord){ //We found the index for list of links to be i
				innerTable = innerTable + "<tr><td onclick=\"displayAfterElementLink(this);\">" + links[i][0] + "</td></tr>";
				currWord = links[i][0].replace(/\s/g, '');
				i += words.length+1;
			}
		}
		infLoopCheck++;
	}
	if(infLoopCheck == 100){alert("Infinite loop");}
	document.getElementById("linkToKanyeTable").innerHTML=innerTable;
}

function getLinks(wordIndex){
	var innerTable="";
	for(var i=0; i<links[wordIndex].length; i++){
		innerTable = innerTable + "<tr><td onclick=\"displayAfterElementLink(this);\">" + links[wordIndex][i] + "</td></tr>";
	}
	
	innerTable = innerTable + "<tr><td id=\"addDirectLinks\" onclick=\"window.location.href = 'kanyeDirectLinks.php?name="+words[wordIndex]+"';\">Add Direct Links</td></tr>";
	
	document.getElementById("navigationElements").innerHTML=innerTable;
}

function displayAfterElementLink(element){
	if(element.innerHTML.replace(/\s/g, '') != "Kanye".replace(/\s/g, '')){
		updateNodeIndex(element.innerHTML);
		//alert(currNode);
		getKanyeProof(currNode);
		getLinks(currNode);
	}	
}

function displayPage(){
	//Update page for current node
	getKanyeProof(currNode);
	getLinks(currNode);
}

displayPage();

</script>

 <script>
$(function() {
$( "#tags" ).autocomplete({
source: function(request, response) {
        var results = $.ui.autocomplete.filter(words, request.term);

        response(results.slice(0, 8));
    },
select: function(event, ui) {
	updateNodeIndex(ui.item.label);
	displayPage();
	return false;
}
});
});
</script>
</body>
</html>

<!-- 
allow the addition of direct links (from the list of existing proven words)
change pointer over clickable elements
 -->
