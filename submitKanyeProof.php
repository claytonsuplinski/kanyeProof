<?php
//$k=1; echo $_POST["$k"] . "<br>";
$numWords = $_POST["numWords"];
for($i=0; $i<$numWords; $i++){
	echo $_POST["$i"] . "<br>";
}
echo "<br><hr><br>";

class Node{
	public $word;
	public $links=array();
}

$nodes=array();

$handle = fopen("kanyeLinks.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) != false) {
		$line = preg_replace('/\n$/','',$line);
		$tmpLine = explode(";^&#*", $line);
		$tmpNode = new Node();
		$tmpNode->word = $tmpLine[0];
		array_shift($tmpLine);
		foreach ($tmpLine as $tl){
			array_push($tmpNode->links, $tl);
		}		
		
		array_push($nodes, $tmpNode);
    }
}
else {
		echo "alert('Error parsing database');";
} 
fclose($handle);

for($i=0; $i<($numWords-1); $i++){
	$currWord = $_POST["$i"];
	$j=$i+1;
	$found = false;
	foreach ($nodes as $node){
		if($node->word == $currWord){ //If the current word in the kanye proof is already in the db
			array_push($node->links, $_POST["$j"]); 
			$found = true;
		}
	}
	if($found == false){ //If the current word in the kanye proof is not already in the db
		$tmpNode = new Node();
		$tmpNode->word = $currWord;
		array_push($tmpNode->links, $_POST["$j"]);
		array_push($nodes, $tmpNode);
	}
}

foreach ($nodes as $node){
	$allLinks = "";
	$nodeLinks = $node->links;
	foreach ($nodeLinks as $link){
		$allLinks = $allLinks . ", " . $link;
	}
	echo $node->word . ': ' . $allLinks . "<br>";
}

$f = fopen("kanyeLinks.txt", "w");
file_put_contents("kanyeLinks.txt", "");
$delim = ";^&#*";
echo "<hr>";
foreach ($nodes as $node){
	$lineToWrite = strtoupper($node->word);
	$nodeLinks = array_unique($node->links);
	foreach ($nodeLinks as $link){
		$lineToWrite = $lineToWrite . $delim . strtoupper($link);
	}
	echo $lineToWrite . "<br>";
	fwrite($f, $lineToWrite."\n"); 
}
fclose($f);

header("Location: kanyeProof.php");
?>