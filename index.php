	<?php
	
	//StartTime
	$startTime = date("c");//date('c', strtotime('+2 hour',strtotime(date("c"))));
	echo $startTime;
	$x = date('c', strtotime('-25 hour',strtotime($startTime)));
	$find =  strpos($x, "+");
	$a1 = substr($x, 0, $find);
	
	//EndTime
	$x = date('c', strtotime('+2 hour',strtotime(date("c"))));//date('c');	
	$find =  strpos($x, "+");
	$a2 = substr($x, 0, $find);
	
	//echo $a1." e ".$a2;
	
	//$conn = new mysqli('192.168.0.111', 'root', '125478', 'massimaluce');
	$conn = new mysqli('localhost', 'root', '', 'massimaluce');
	if($conn->connect_error) die('Errore di connessione');	
	
	$sql = "select data,14a from solare order by data DESC limit 1";
	
	$result = $conn->query($sql);
	
	$bat01 = 0;
	
	while($row = $result->fetch_assoc()){
		
		$bat01 = floatval($row["14a"])/10.0;
		
	}
		
	$conn->close();
	
	//echo $bat01;
	
	$grA = "";
	$grB = "";
	
	if ($bat01 != 0){
		$grA = "checked";
		$grB = "";
	} else{
		$grA = "";
		$grB = "checked";
	} 
 
	
		
	?>
	<!DOCTYPE HTML>
    <html>
    <head> 
	
	<link rel="stylesheet" href="css/styleIndex.css" media="screen">
	
	
    </head>
    <body>
	
	<h1> Solare / Eolico / Batterie 01-02</br>I dati iniziano dal 06/02/2024 </h1>
	
	<form class="data" method="get" action="/chart/action_page.php">
		<label for="from">Dal: </label>
		<input type="datetime-local" value="<?php echo $a1; ?>" name="dateFrom">
		
		<label for="to">Al: </label>
		<input type="datetime-local" value="<?php echo $a2; ?>" name="dateTo">
	<div class="radioBut">	
		<p>Seleziona il grafico da visualizzare:</p>
		<input type="radio" class="gr2" name="gr2" value="block" checked>
		<label class="onOff">On - Off</label>
		<input type="radio" class="gr2" name="gr2" value="none" >
		<label class="labgr2">PV Voltage / PV Current</label><br> 
		
		<input type="radio" class="gr1" name="gr1" value="block" <?php echo $grA; ?> >
		<label class="onOff">On - Off</label>
		<input type="radio" class="gr1" name="gr1" value="none" <?php echo $grB; ?> >
		<label class="labgr1">Batteria 01 In Carica / Batteria 02 Energizza</label><br>
		
		<input type="radio" class="gr3" name="gr3" value="block" <?php echo $grB; ?> >
		<label class="onOff">On - Off</label>		
		<input type="radio" class="gr3" name="gr3" value="none" <?php echo $grA; ?> >
		<label class="labgr3">Batteria 02 In Carica / Batteria 01 Energizza</label><br>
		
		<input type="radio" class="gr4" name="gr4" value="block" <?php echo $grB; ?> >
		<label class="onOff">On - Off</label>
		<input type="radio" class="gr4" name="gr4" value="none" <?php echo $grA; ?> >
		<label class="labgr4">Batteria 01 Energizza</label><br>
		
		<input type="radio" class="gr5" name="gr5" value="block" <?php echo $grA; ?> >
		<label class="onOff">On - Off</label>
		<input type="radio" class="gr5" name="gr5" value="none" <?php echo $grB; ?> >
		<label class="labgr5">Batteria 02 Energizza</label><br>
		
		<input type="radio" class="gr6" name="gr6" value="block" checked >
		<label class="onOff">On - Off</label>
		<input type="radio" class="gr6" name="gr6" value="none" >
		<label class="labgr6">PLC Solare (Utenze)</label><br> 
		
		<input type="radio" class="gr7" name="gr7" value="block" checked >
		<label class="onOff">On - Off</label>
		<input type="radio" class="gr7" name="gr7" value="none" >
		<label class="labgr7">PLC Casa (Utenze)</label><br> 
		
		<input type="radio" class="gr8" name="gr8" value="block" >
		<label class="onOff">On - Off</label>
		<input type="radio" class="gr8" name="gr8" value="none" checked >
		<label class="labgr8">Fan Voltage / Fan Current</label><br> 
		
		
		
	</div>
		
		<input class="butReq" value="Visualizza&#10;Grafico" type="submit">
		
	</form>
	
	<p class="maxlight">Creato da <a href="https://www.massimaluce.it" target="_blank">massimaluce</a> di Cesare Pasqualetti</p>
	
	



	
    </body>
    </html>                              