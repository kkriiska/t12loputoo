<?php
	//edit.php
	require("../functions.php");
	
    require("../class/Helper.class.php");
	$Helper = new Helper();
	require("../class/Note.class.php");
	$Note = new Note($mysqli);
	
	
	if(isset($_GET["delete"])){
		
		$Note->deleteNote($_GET["id"]);
		header("Location: data.php");
		exit();
		
	}
	
	
	if(isset($_POST["update"])){
		
		$Note->updateNote($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["note"]), $Helper->cleanInput($_POST["color"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	
	$c = $Note->getSingleNoteData($_GET["id"]);

	
?>
<?php require("../header.php"); ?>



<h2 style="text-align:center;">Muuda kirjet</h2>
<br><br>

<form method = "POST" style="text-align:center;">
	<a href="data.php"> tagasi </a>
</form> 

  <form  style="text-align:center;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
	<textarea  id="note" name="note"><?php echo $c->note;?></textarea><br>
  	<label for="color" >värv</label><br>
	<input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>
  
<br>
<br>
<form method = "POST" style="text-align:center;">
	<a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>
</form> 
  
  
  
  
<?php require("../footer.php"); ?>