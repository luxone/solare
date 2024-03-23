<?php

//Verifico stato BIT nella word a 16 bit
function CountOneBits($word,$nBit) {
  $mask = 1;
  $count = 0;
  $b = 0;
  
  //performing bitwise AND operation
  //at every bit of the number
  for($i = 0; $i < 16; ++$i) { 
    if((($mask & $word) == $mask) & $count == $nBit)
	{ 
		$b = 1;
	}
	$count ++;
    $mask <<= 1;
  }
  return $b;
}
	
	//da INDEX prendo dati necessari per creare la query, manipolo data
	$x = $_GET["dateFrom"];
	$find = array("T");
	$replace = array(" ");
	$a1 =  str_replace($find,$replace,$x);
	
	$x = $_GET["dateTo"];
	$find = array("T");
	$replace = array(" ");
	$a2 =  str_replace($find,$replace,$x);
	
	//echo $a1." e ".$a2."<br>";
	
	//pulsanti radio selezione hide dei graph
	$gr1 = $_GET["gr1"];
	$gr2 = $_GET["gr2"];
	$gr3 = $_GET["gr3"];
	$gr4 = $_GET["gr4"];
	$gr5 = $_GET["gr5"];
	$gr6 = $_GET["gr6"];
	$gr7 = $_GET["gr7"];
	$gr8 = $_GET["gr8"];
	
	//echo "Value= ".$_GET["gr1"]." Value= ".$_GET["gr2"]." Value= ".$_GET["gr3"]." Value= ".$_GET["gr4"]." Value= ".$_GET["gr5"]." Value= ".$_GET["gr6"]."<br>";
	
	$host = "62.149.150.214";
	$user = "Sql756180";
	$pass = "6jt26v42qj";
	$db = "Sql756180_2";
	//$conn = new mysqli($host, $user, $pass, $db);  //Connessione a DB Aruba
	//$conn = new mysqli('192.168.0.111', 'root', '125478', 'massimaluce');
	$conn = new mysqli('localhost', 'root', '', 'massimaluce');
	if($conn->connect_error) die('Errore di connessione');	

// prendo i dati dal DB
	//$sql = "SELECT `idx`,`data`,`14a`,`77a`,`77b`,`76a`,`76b` FROM `solare` WHERE data <= CURRENT_TIMESTAMP() and data >= SUBTIME(CURRENT_TIMESTAMP(), '1:0:0')";
	//$sql = "SELECT `idx`,`data`,`14b`,`76a` FROM `solare`";
	//$sql = "SELECT `idx`,`data`,`14a`,`14b`,`15`,`17`,`77a`,`77b`,`76a`,`76b` FROM `solare` WHERE data >= NOW() - INTERVAL 1 DAY"; 
	//$sql = "SELECT `idx`,`data`,`14a`,`14b`,`15`,`17`,`77a`,`77b`,`76a`,`76b` FROM `solare` WHERE data >= '2024-02-10 04:59:59' AND data <= '2024-02-10 21:59:59'"; 
	if ($a1<>""){
		$sql = "SELECT `idx`,`data`,`14a`,`o0s`,`o0c`,`14b`,`15`,`17`,`77a`,`77b`,`76a`,`76b` FROM `solare` WHERE data >= '".$a1."' AND data <= '".$a2."'";
	}else{
		//$sql = "SELECT `idx`,`data`,`14a`,`14b`,`15`,`17`,`77a`,`77b`,`76a`,`76b` FROM `solare` WHERE data >= '2024-02-10 04:59:59' AND data <= '2024-02-10 21:59:59'";
		$sql = "SELECT `idx`,`data`,`o0s`,`14a`,`14b`,`15`,`17`,`77a`,`77b`,`76a`,`76b` FROM `solare` WHERE data >= '2024-02-09 04:59:59' AND data <= '". date("Y/m/d H:m:s") ."'";
	}
	
	//echo "query= ".$sql;
	
	$result = $conn->query($sql);

	$count = 0;
	
    while($row = $result->fetch_assoc()){
		
		$find = array("-",":");
		$replace = array(" ");
		$a =  str_replace($find,$replace,$row["data"]);
 
 //Batteria01 Volt Carica / Batteria02 Energizza    	
		$dataPoints1[$count]["label"] = $row["data"];
		$dataPoints1[$count]["x"] = $row["idx"];
		$dataPoints1[$count]["y"] = floatval($row["14a"])/10.0;
		$dataPoints1[$count]["z"] = 20;
		
		$dataPoints2[$count]["label"] = $row["data"];
		$dataPoints2[$count]["x"] = $row["idx"];
		$dataPoints2[$count]["y"] = floatval($row["77b"])/10.0;
//Batteria02 Volt Carica / Batteria01 Energizza 		
		$dataPoints3[$count]["label"] = $row["data"];
		$dataPoints3[$count]["x"] = $row["idx"];
		$dataPoints3[$count]["y"] = floatval($row["14b"])/10.0;
		
		$dataPoints4[$count]["label"] = $row["data"];
		$dataPoints4[$count]["x"] = $row["idx"];
		$dataPoints4[$count]["y"] = floatval($row["77a"])/10.0;
//Batteria01 Volt Energizza / Batteria01 Amper Energizza		
		$dataPoints5[$count]["label"] = $row["data"];
		$dataPoints5[$count]["x"] = $row["idx"];
		$dataPoints5[$count]["y"] = floatval($row["77a"])/10.0;
		
		$dataPoints6[$count]["label"] = $row["data"];
		$dataPoints6[$count]["x"] = $row["idx"];
		$dataPoints6[$count]["y"] = floatval($row["76a"])/10.0;
//Batteria02 Volt Energizza / Batteria02 Amper Energizza		
		$dataPoints7[$count]["label"] = $row["data"];
		$dataPoints7[$count]["x"] = $row["idx"];
		$dataPoints7[$count]["y"] = floatval($row["77b"])/10.0;
		
		$dataPoints8[$count]["label"] = $row["data"];
		$dataPoints8[$count]["x"] = $row["idx"];
		$dataPoints8[$count]["y"] = floatval($row["76b"])/10.0;
//PV Voltage / PV Charge Current		
		$dataPoints9[$count]["label"] = $row["data"];
		$dataPoints9[$count]["x"] = $row["idx"];
		$dataPoints9[$count]["y"] = floatval($row["15"])/10.0;
		
		$dataPoints10[$count]["label"] = $row["data"];
		$dataPoints10[$count]["x"] = $row["idx"];
		$dataPoints10[$count]["y"] = floatval($row["17"])/10.0;
		
//Fan Voltage / Fan Charge Current		
		$dataPoints11[$count]["label"] = $row["data"];
		$dataPoints11[$count]["x"] = $row["idx"];
		$dataPoints11[$count]["y"] = floatval($row["15"])/10.0;
		
		$dataPoints12[$count]["label"] = $row["data"];
		$dataPoints12[$count]["x"] = $row["idx"];
		$dataPoints12[$count]["y"] = floatval($row["17"])/10.0;
//PLC Solare Casa	

		$vl = 0;
		$lbl = "";
	
		$dataPoints13[$count]["label"] = $row["data"];
		$dataPoints13[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 0; //puntatore del bit associato all'utenza da controllare // Bit1 Motore 0 - Azimut
		$value = 10; //valore assegnato all'uscita
		$chk1 = CountOneBits($word,$nBit);
		$nBit = 1; //puntatore del bit associato all'utenza da controllare  // Bit 1 - Elevazione
		$chk2 = CountOneBits($word,$nBit);
		//echo $chk1."< >".$chk2;
		if($chk1 == 0){
			$vl = 0;
			$lbl = "No Data";
		}elseif(($chk1 == 1) & ($chk2 == 0)){
			$vl = 1;
			$lbl = "Mot.Azi";
		}else{
			$vl = 1;
			$lbl = "Mot.Ele";
		}
		$dataPoints13[$count]["y"] = $vl; 
		$dataPoints13[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints14[$count]["label"] = $row["data"];
		$dataPoints14[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 2; //puntatore del bit associato all'utenza da controllare // Bit2 Pistoncino sgancio vericello
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 1.01;
			$lbl = "Sgnc.Ver";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints14[$count]["y"] = $vl;
		$dataPoints14[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints15[$count]["label"] = $row["data"];
		$dataPoints15[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 3; //puntatore del bit associato all'utenza da controllare // Bit3 Alimentazione Ingressi
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.5;
			$lbl = "Alim.Ing";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints15[$count]["y"] = $vl;
		$dataPoints15[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints16[$count]["label"] = $row["data"];
		$dataPoints16[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 4; //puntatore del bit associato all'utenza da controllare //  Bit4 Alimentazione Bobine MT Batteria In Carica 
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 1.8;
			$lbl = "Alim.MT_BC";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints16[$count]["y"] = $vl;
		$dataPoints16[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints17[$count]["label"] = $row["data"];
		$dataPoints17[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 5; //puntatore del bit associato all'utenza da controllare // Bit5 Alimentazione Bobine MT Eolico Solare
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 1.6;
			$lbl = "Alim.MT_ES";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints17[$count]["y"] = $vl;
		$dataPoints17[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints18[$count]["label"] = $row["data"];
		$dataPoints18[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 6; //puntatore del bit associato all'utenza da controllare // Bit6 Alimentazione Bobine MT Batteria Energizzano
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 1.4;
			$lbl = "Alim.MT_BE";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints18[$count]["y"] = $vl;
		$dataPoints18[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints19[$count]["label"] = $row["data"];
		$dataPoints19[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 7; //puntatore del bit associato all'utenza da controllare // Bit7 Floating Charge Voltage
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.8;
			$lbl = "Floating Chrg";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints19[$count]["y"] = $vl;
		$dataPoints19[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints20[$count]["label"] = $row["data"];
		$dataPoints20[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 8; //puntatore del bit associato all'utenza da controllare // Bit8   Bobina MT Eolico
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.981;
			$lbl = "BobinaMTEol";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints20[$count]["y"] = $vl;
		$dataPoints20[$count]["name"] = $lbl;
		
		//-o-o-\\
	
		$dataPoints21[$count]["label"] = $row["data"];
		$dataPoints21[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 9; //puntatore del bit associato all'utenza da controllare // Bit9  Bobina MT Solare
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.982;
			$lbl = "BobinaMTSol";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints21[$count]["y"] = $vl;
		$dataPoints21[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints22[$count]["label"] = $row["data"];
		$dataPoints22[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 10; //puntatore del bit associato all'utenza da controllare // Bit10  Bobina B1 In Carica
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.983;
			$lbl = "BobinaMTB1Car";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints22[$count]["y"] = $vl;
		$dataPoints22[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints23[$count]["label"] = $row["data"];
		$dataPoints23[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 11; //puntatore del bit associato all'utenza da controllare // Bit11  Bobina B2 In Carica
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.984;
			$lbl = "BobinaMTB2Car";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints23[$count]["y"] = $vl;
		$dataPoints23[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints24[$count]["label"] = $row["data"];
		$dataPoints24[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 12; //puntatore del bit associato all'utenza da controllare // Bit12  Bobina B1 Energizza
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.985;
			$lbl = "BobinaMTB1Enrg";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints24[$count]["y"] = $vl;
		$dataPoints24[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints25[$count]["label"] = $row["data"];
		$dataPoints25[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 13; //puntatore del bit associato all'utenza da controllare // Bit13  Bobina B2 Energizza
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.986;
			$lbl = "BobinaMTB2Enrg";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints25[$count]["y"] = $vl;
		$dataPoints25[$count]["name"] = $lbl;
		
		/*
		//-o-o-\\
		
		$dataPoints26[$count]["label"] = $row["data"];
		$dataPoints26[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 14; //puntatore del bit associato all'utenza da controllare // Bit14
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.99;
			$lbl = "Bit14Ris";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints26[$count]["y"] = $vl;
		$dataPoints26[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints27[$count]["label"] = $row["data"];
		$dataPoints27[$count]["x"] = $row["idx"];
		$word = $row["o0s"];//word a cui punto
		$nBit = 15; //puntatore del bit associato all'utenza da controllare // Bit15
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 0.99;
			$lbl = "Bit15Ris";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints27[$count]["y"] = $vl;
		$dataPoints27[$count]["name"] = $lbl;
		*/
		
		//-o-o-\\
		
		$dataPoints28[$count]["label"] = $row["data"];
		$dataPoints28[$count]["x"] = $row["idx"];
		$word = $row["o0c"];//word a cui punto
		$nBit = 0; //puntatore del bit associato all'utenza da controllare // Bit0
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 1.0;
			$lbl = "Pompa Pozzo";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints28[$count]["y"] = $vl;
		$dataPoints28[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints29[$count]["label"] = $row["data"];
		$dataPoints29[$count]["x"] = $row["idx"];
		$word = $row["o0c"];//word a cui punto
		$nBit = 1; //puntatore del bit associato all'utenza da controllare // Bit1
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1.25){
			$vl = 1.0;
			$lbl = "Pompa Casa";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints29[$count]["y"] = $vl;
		$dataPoints29[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints30[$count]["label"] = $row["data"];
		$dataPoints30[$count]["x"] = $row["idx"];
		$word = $row["o0c"];//word a cui punto
		$nBit = 2; //puntatore del bit associato all'utenza da controllare // Bit2
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 1.5;
			$lbl = "Pompa Pozzo";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints30[$count]["y"] = $vl;
		$dataPoints30[$count]["name"] = $lbl;
		
		//-o-o-\\
		
		$dataPoints31[$count]["label"] = $row["data"];
		$dataPoints31[$count]["x"] = $row["idx"];
		$word = $row["o0c"];//word a cui punto
		$nBit = 3; //puntatore del bit associato all'utenza da controllare // Bit3
		$chk1 = CountOneBits($word,$nBit);
		if($chk1 == 1){
			$vl = 2.0;
			$lbl = "MT Solare";
		}else{
			$vl = 0;
			$lbl = "No Data";
		}
		$dataPoints31[$count]["y"] = $vl;
		$dataPoints31[$count]["name"] = $lbl;
		
		
		
		//COUNT
		$count = $count + 1;
		
	}
	
	$conn->close();


     
    /*$dataPoints1 = array(
    	array("label"=> "2020", "x" => "20", "y"=> 4.6735),
    	array("label"=> "2020",	"x" => "21", "y"=> 1.619),
    	array("label"=> "2020",	"x" => "22", "y"=> 1.5673),
    	array("label"=> "2020",	"x" => "23", "y"=> 1.5182)
    );
    $dataPoints2 = array(
    	array("label"=> "2020",	"x" => "20", "y"=> 0.9999),
    	array("label"=> "2020",	"x" => "21", "y"=> 1),
    	array("label"=> "2020",	"x" => "22", "y"=> 1),
    	array("label"=> "2020",	"x" => "23", "y"=> 1)
    );*/
    	
?>
    <!DOCTYPE HTML>
    <html>
    <head> 
    <meta charset="UTF-8"> 
	
    <script>

		
var charts = [],
  axisX = {
    crosshair: {
      enabled: true,
      updated: onCrosshairUpdated,
      hidden: onCrosshairHidden
    }
  },
  toolTip = {
    shared: true,
    updated: onToolTipUpdated,
    hidden: onToolTipHidden
  };
	
	
function onCrosshairUpdated(e) {
	for( var i = 0; i < charts.length; i++){
	  if(charts[i] != e.chart)
		charts[i].axisX[0].crosshair.showAt(e.value);
	}
}

function onCrosshairHidden(e) {
  for( var i = 0; i < charts.length; i++){
    if(charts[i] != e.chart)
      charts[i].axisX[0].crosshair.hide();
  }
}

function onToolTipUpdated(e) {
  for( var i = 0; i < charts.length; i++){
    if(charts[i] != e.chart)
      charts[i].toolTip.showAtX(e.entries[0].xValue);
  }
}

function onToolTipHidden(e) {
  for( var i = 0; i < charts.length; i++){
    if(charts[i] != e.chart)
      charts[i].toolTip.hide();
  }
}	
	
    window.onload = function () {


//Batteria01 Volt Carica / Batteria02 Energizza     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	title:{
    		text: "# Batteria 01 In Carica # / # Batteria 02 Energizza #"
    	},
    	axisX:{
    		title: "Volt",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden,
				snapToDataPoint: true
			},
			toolTip: toolTip
    	},
    	axisY:{
    		title: "Volt Batteria 01 In Carica",
    		titleFontColor: "#4F81BC",
    		lineColor: "#4F81BC",
    		labelFontColor: "#4F81BC",
    		tickColor: "#4F81BC"
    	},
    	axisY2:{
    		title: "Volt Batteria 02 Energizza",
    		titleFontColor: "#C0504E",
    		lineColor: "#C0504E",
    		labelFontColor: "#C0504E",
    		tickColor: "#C0504E"
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: false,
    		itemclick: toggleDataSeries
    	},
    	data: [{
    		type: "line",
    		name: "Batteria 01 In Carica",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} V",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		axisYType: "secondary",
    		name: "Batteria 02 Energizza",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice {x} Idx <br>{name}: {y} V",
    		showInLegend: true,
    		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
	charts.push(chart);
     
    function toggleDataSeries(e){
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = false;
    	}
    	else{
    		e.dataSeries.visible = true;
    	}
    	chart.render();
    }
	
	
	
//Batteria02 Volt Carica / Batteria01 Energizza 	
	var chart1 = new CanvasJS.Chart("chartContainer1", {
    	animationEnabled: true,
    	title:{
    		text: "# Batteria 02 In Carica # / # Batteria 01 Energizza #"
    	},
    	axisX:{
    		title: "Volt",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden
			},
			toolTip: toolTip
    	},
    	axisY:{
    		title: "Volt Batteria 02 In Carica",
    		titleFontColor: "#4F81BC",
    		lineColor: "#4F81BC",
    		labelFontColor: "#4F81BC",
    		tickColor: "#4F81BC"
    	},
    	axisY2:{
    		title: "Volt Batteria 01 Energizza",
    		titleFontColor: "#C0504E",
    		lineColor: "#C0504E",
    		labelFontColor: "#C0504E",
    		tickColor: "#C0504E"
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: true,
    		itemclick: toggleDataSeries1
    	},
    	data: [{
    		type: "line",
    		name: "Batteria 02 In Carica",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx (label)<br>{name}: {y} V",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		axisYType: "secondary",
    		name: "Batteria 01 Energizza",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} V",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart1.render();
	charts.push(chart1);
	
	function toggleDataSeries1(e){
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = false;
    	}
    	else{
    		e.dataSeries.visible = true;
    	}
    	chart1.render();
    }


//Batteria01 Volt Energizza / Batteria01 Ampere Energizza
	var chart2 = new CanvasJS.Chart("chartContainer2", {
    	animationEnabled: true,
    	title:{
    		text: "# Batteria 01 Energizza #"
    	},
    	axisX:{
    		title: "Volt / Ampere",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden
			},
			toolTip: toolTip
    	},
    	axisY:{
    		title: "Volt Batteria 01 Energizza",
    		titleFontColor: "#4F81BC",
    		lineColor: "#4F81BC",
    		labelFontColor: "#4F81BC",
    		tickColor: "#4F81BC"
    	},
    	axisY2:{
    		title: "Amp Batteria 01 Energizza",
    		titleFontColor: "#C0504E",
    		lineColor: "#C0504E",
    		labelFontColor: "#C0504E",
    		tickColor: "#C0504E"
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: true,
    		itemclick: toggleDataSeries2
    	},
    	data: [{
    		type: "line",
    		name: "Batteria 01 V",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} V",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		axisYType: "secondary",
    		name: "Batteria 01 A",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} A",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart2.render();
	charts.push(chart2);
	
	function toggleDataSeries2(e){
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = false;
    	}
    	else{
    		e.dataSeries.visible = true;
    	}
    	chart2.render();
    }
	
//Batteria02 Volt Energizza / Batteria02 Amper Energizza
	var chart3 = new CanvasJS.Chart("chartContainer3", {
    	animationEnabled: true,
    	title:{
    		text: "# Batteria 02 Energizza #"
    	},
    	axisX:{
    		title: "Volt / Ampere",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden
			},
			toolTip: toolTip
    	},
    	axisY:{
    		title: "Volt Batteria 02 Energizza",
    		titleFontColor: "#4F81BC",
    		lineColor: "#4F81BC",
    		labelFontColor: "#4F81BC",
    		tickColor: "#4F81BC"
    	},
    	axisY2:{
    		title: "Amp Batteria 02 Energizza",
    		titleFontColor: "#C0504E",
    		lineColor: "#C0504E",
    		labelFontColor: "#C0504E",
    		tickColor: "#C0504E"
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: true,
    		itemclick: toggleDataSeries3
    	},
    	data: [{
    		type: "line",
    		name: "Batteria 02 V",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} V",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		axisYType: "secondary",
    		name: "Batteria 02 A",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} A",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints8, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart3.render();
	charts.push(chart3);
     
    function toggleDataSeries3(e){
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = false;
    	}
    	else{
    		e.dataSeries.visible = true;
    	}
    	chart3.render();
    }	
	
	
//PV Voltage / PV Charge Current	
	var chart4 = new CanvasJS.Chart("chartContainer4", {
    	animationEnabled: true,
    	title:{
    		text: "# PV Voltage # / # PV Charge Current #"
    	},
    	axisX:{
    		title: "Volt / Ampere",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden
			},
			toolTip: toolTip
    	},
    	axisY:{
    		title: "PV Voltage",
    		titleFontColor: "#4F81BC",
    		lineColor: "#4F81BC",
    		labelFontColor: "#4F81BC",
    		tickColor: "#4F81BC"
    	},
    	axisY2:{
    		title: "PV Charge Current",
    		titleFontColor: "#C0504E",
    		lineColor: "#C0504E",
    		labelFontColor: "#C0504E",
    		tickColor: "#C0504E"
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: true,
    		itemclick: toggleDataSeries4
    	},
    	data: [{
    		type: "line",
    		name: "PV Voltage",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} V",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints9, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		axisYType: "secondary",
    		name: "PV Charge Current",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} A",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints10, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart4.render();
	charts.push(chart4);
     
    function toggleDataSeries4(e){
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = false;
    	}
    	else{
    		e.dataSeries.visible = true;
    	}
    	chart4.render();
    }
     
	
	
	//Fan Voltage / Fan Charge Current	
	var chart5 = new CanvasJS.Chart("chartContainer5", {
    	animationEnabled: true,
    	title:{
    		text: "# Fan Voltage # / # Fan Charge Current #"
    	},
    	axisX:{
    		title: "Volt / Ampere",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden
			},
			toolTip: toolTip
    	},
    	axisY:{
    		title: "Fan Voltage",
    		titleFontColor: "#4F81BC",
    		lineColor: "#4F81BC",
    		labelFontColor: "#4F81BC",
    		tickColor: "#4F81BC"
    	},
    	axisY2:{
    		title: "Fan Charge Current",
    		titleFontColor: "#C0504E",
    		lineColor: "#C0504E",
    		labelFontColor: "#C0504E",
    		tickColor: "#C0504E"
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: true,
    		itemclick: toggleDataSeries5
    	},
    	data: [{
    		type: "line",
    		name: "Fan Voltage",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} V",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints11, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		axisYType: "secondary",
    		name: "Fan Charge Current",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x} Idx <br>{name}: {y} A",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints12, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart5.render();
	charts.push(chart5);
	
	function toggleDataSeries5(e){
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = false;
    	}
    	else{
    		e.dataSeries.visible = true;
    	}
    	chart5.render();
    }
	
	
	//Uscite PLC solare	
	var chart6 = new CanvasJS.Chart("chartContainer6", {
    	animationEnabled: true,
    	title:{
    		text: "# PLC Solare # (Utenze In Funzione)"
    	},
    	axisX:{
    		title: "Utenze On / Off",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden
			},
			toolTip: toolTip
    	},
    	axisY:{
			lineThickness: 0,
			gridThickness: 0,
			tickLength: 0,
			labelFormatter: function(e) { 
			return "";}
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: true,
    		itemclick: toggleDataSeries
    	},
    	data: [{
    		type: "line",
    		//name: "Out0 - 1",
    		//markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints13, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out2",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints14, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out3",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints15, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out4",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints16, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out5",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints17, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out6",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints18, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out7",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints19, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out8",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints20, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out9",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints21, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out10",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints22, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out11",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints23, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out12",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints24, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out13",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints25, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart6.render();
	charts.push(chart6);
	
	//Uscite PLC casa	
	var chart7 = new CanvasJS.Chart("chartContainer7", {
    	animationEnabled: true,
    	title:{
    		text: "# PLC Casa # (Utenze In Funzione)"
    	},
    	axisX:{
    		title: "Utenze On / Off",
			crosshair: {
				enabled: true,
				updated: onCrosshairUpdated,
				hidden: onCrosshairHidden
			},
			toolTip: toolTip
    	},
    	axisY:{
			lineThickness: 0,
			gridThickness: 0,
			tickLength: 0,
			labelFormatter: function(e) { 
			return "";}
    	},
    	legend:{
    		cursor: "pointer",
    		dockInsidePlotArea: true,
    		itemclick: toggleDataSeries
    	},
    	data: [{
    		type: "line",
    		//name: "Out0",
    		//markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints28, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out1",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints29, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out2",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints30, JSON_NUMERIC_CHECK); ?>
    	},{
    		type: "line",
    		//name: "Out3",
    		markerSize: 0,
    		toolTipContent: "{label}<br/>Indice: {x}<br>{name}",
    		showInLegend: false,
    		dataPoints: <?php echo json_encode($dataPoints31, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart7.render();
	charts.push(chart7);
    
  }
 
    </script>
	
    </head>
    <body>
	
	<div id="chartContainer4" style="height: 480px; width: 100%; display:<?php echo $gr2?>;"></div>	<!--PV Voltage / PV Charge Current-->
    <div id="chartContainer"  style="height: 350px; width: 100%; display:<?php echo $gr1?>;"></div> <!--Batteria01 Volt Carica / Batteria02 Energizza-->
	<div id="chartContainer1" style="height: 350px; width: 100%; display:<?php echo $gr3?>;"></div> <!--Batteria02 Volt Carica / Batteria01 Energizza-->
	<div id="chartContainer2" style="height: 350px; width: 100%; display:<?php echo $gr4?>;"></div> <!--Batteria01 Volt Energizza / Batteria01 Ampere Energizza-->
	<div id="chartContainer3" style="height: 350px; width: 100%; display:<?php echo $gr5?>;"></div> <!--Batteria02 Volt Energizza / Batteria02 Amper Energizza-->
	<div id="chartContainer6" style="height: 200px; width: 100%; display:<?php echo $gr6?>;"></div> <!--Uscite PLC solare casa-->
	<div id="chartContainer7" style="height: 200px; width: 100%; display:<?php echo $gr7?>;"></div> <!--Uscite PLC casa-->
	<div id="chartContainer5" style="height: 480px; width: 100%; display:<?php echo $gr8?>;"></div> <!--Fan Voltage / Fan Charge Current-->
	
	<p class="maxlight">Creato da <a href="https://www.massimaluce.it" target="_blank">massimaluce</a> di Cesare Pasqualetti</p>
	
	
    <!--<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>-->
	<script src="/chart/js\canvasjs\canvasjs-chart-3.7.38/canvasjs.min.js"></script>
	
    </body>
    </html>                              