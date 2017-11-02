<?php 
	// et saada ligi sessioonile
	require("../functions.php");
	
    require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/Note.class.php");
	$Note = new Note($mysqli);
	
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	

	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	if (	isset($_POST["note"]) && 
			isset($_POST["color"]) && 
			!empty($_POST["note"]) && 
			!empty($_POST["color"]) 
	) {
		
		$note = $Helper->cleanInput($_POST["note"]);
		$color = $Helper->cleanInput($_POST["color"]);
		
		$Note->saveNote($note, $color);
		
	}
	
	
	$q = "";

	if(isset($_GET["q"])){
		$q = $Helper->cleanInput($_GET["q"]);
	}
	
	$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && isset($_GET["order"])){
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	
	$notes = $Note->getAllNotes($q, $sort, $order);
?>
<?php require("../header.php"); ?>

<h1 style="text-align:center;">Data</h1>
<p style="text-align:center;">
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">Logi välja</a>
</p>

<h2 style="text-align:center;">Märkmed</h2>

<form method = "POST" style="text-align:center;">
			
	<input name="note" type="text">
	
	<br><br>
	
	<label>Värv</label><br>
	<input name="color" type="color">
				
	<br><br>
	
	<input type="submit">

</form>

<?php 

	foreach ($notes as $n) {
		
		$style ="text-align:center; width:100px; float:left;min-height:50px; border:  1px solid black; background-color: ".$n->noteColor.";";
		
		echo "<p style='  ".$style."  '>".$n->note."</p>";
	}
?>


<h2 style="clear:both;">Tabel</h2>
<?php 
	$html = "<table class='table'>";
		
		$html .= "<tr>";
		
			$orderId = "ASC";
			
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" && 
				$_GET["sort"] == "id" ){
				
				$orderId = "DESC";
			}
			
			$orderNote = "ASC";
			
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" && 
				$_GET["sort"] == "note" ){
				
				$orderNote = "DESC";
			}

			$orderColor = "ASC";
			
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" && 
				$_GET["sort"] == "color" ){
				
				$orderColor = "DESC";
			}
		
		$html .= "</tr>";
	foreach ($notes as $note) {
		$html .= "<tr>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td><a href='edit.php?id=".$note->id."'> <span class='glyphicon glyphicon-pencil'><span>muuda</a></td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
?>
<?php require("../footer.php"); ?>