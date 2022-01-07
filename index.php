<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/*sudokunun mevcut degerleri tanimlaniyor*/
$sudokuNumbersOrj = array(
	'1x4' => 2,
	'1x5' => 6,
	'1x7' => 7,
	'1x9' => 1,
	
	'2x1' => 6,
	'2x2' => 8,
	'2x5' => 7,
	'2x8' => 9,
	
	'3x1' => 1,
	'3x2' => 9,
	'3x6' => 4,
	'3x7' => 5,
	
	'4x1' => 8,
	'4x2' => 2,
	'4x4' => 1,
	'4x8' => 4,
	
	'5x3' => 4,
	'5x4' => 6,
	'5x6' => 2,
	'5x7' => 9,
	
	'6x2' => 5,
	'6x6' => 3,
	'6x8' => 2,
	'6x9' => 8,
	
	'7x3' => 9,
	'7x4' => 3,
	'7x8' => 7,
	'7x9' => 4,
	
	'8x2' => 4,
	'8x5' => 5,
	'8x8' => 3,
	'8x9' => 6,
	
	'9x1' => 7,
	'9x3' => 3,
	'9x5' => 1,
	'9x6' => 8,
);
$sudokuNumbers = $sudokuNumbersOrj;
/*sudokunun mevcut degerleri tanimlaniyor bitis*/


/*her kare tek tek kontrol edilerek bosluklar dolduruluyor*/
checkAllCell();
/*her kare tek tek kontrol edilerek bosluklar dolduruluyor bitis*/


//tum tabloyu kontrol eden fonksiyon
function checkAllCell(){
	global $sudokuNumbers;
	
	$checkStillFinding = 1;
	while($checkStillFinding > 0){
		$checkStillFinding = 0;
		for($i=1;$i<=9;$i++){
			for($j=1;$j<=9;$j++){
				if(!isset($sudokuNumbers[$i.'x'.$j])){
					$result = checkCell($i.'x'.$j);
					if($result != false){
						$checkStillFinding++;
					}
				}
			}
		}
	}
	//var_dump($checkStillFinding);
}

//bir kareyi kontrol eden fonsiyon
function checkCell($position){
	global $sudokuNumbers;
	
	//satir, sutun
	$lineColumn = explode("x",$position);//0 => line, 1 => column
	$arrayUnuseNumbers = array(1,2,3,4,5,6,7,8,9);
	
	//satir kontrol ediliyor	
	for($i=1;$i<=9;$i++){
		if(isset($sudokuNumbers[$lineColumn[0].'x'.$i])){
			$arrayUnuseNumbers = array_diff($arrayUnuseNumbers,array($sudokuNumbers[$lineColumn[0].'x'.$i]));
		}
	}
	
	//sutun kontrol ediliyor	
	for($i=1;$i<=9;$i++){
		if(isset($sudokuNumbers[$i.'x'.$lineColumn[1]])){
			$arrayUnuseNumbers = array_diff($arrayUnuseNumbers,array($sudokuNumbers[$i.'x'.$lineColumn[1]]));
		}
	}
	
	/*kucuk kare kontrol ediliyor*/
	/*satir siniri*/
	$lineModResult = $lineColumn[0] % 3;
	if($lineModResult == 1){
		$squareLineStart 	= $lineColumn[0];
		$squareLineFinish 	= $lineColumn[0] + 2;
	}elseif($lineModResult == 2){
		$squareLineStart 	= $lineColumn[0] - 1;
		$squareLineFinish 	= $lineColumn[0] + 1;
	}elseif(lineModResult){
		$squareLineStart 	= $lineColumn[0] - 2;
		$squareLineFinish 	= $lineColumn[0];
	}
	/*satir siniri bitis*/
	
	/*sutun siniri*/
	$columnModResult = $lineColumn[1] % 3;	
	if($columnModResult == 1){
		$squareColumnStart 	= $lineColumn[1];
		$squareColumnFinish = $lineColumn[1] + 2;
	}elseif($columnModResult == 2){
		$squareColumnStart 	= $lineColumn[1] - 1;
		$squareColumnFinish = $lineColumn[1] + 1;
	}elseif($columnModResult == 0){
		$squareColumnStart 	= $lineColumn[1] - 2;
		$squareColumnFinish = $lineColumn[1];
	}
	/*sutun siniri bitis*/
	
	for($i=$squareLineStart;$i<=$squareLineFinish;$i++){
		for($j=$squareColumnStart;$j<=$squareColumnFinish;$j++){
			if(isset($sudokuNumbers[$i.'x'.$j])){
				$arrayUnuseNumbers = array_diff($arrayUnuseNumbers,array($sudokuNumbers[$i.'x'.$j]));
			}
		}
	}
	
	/*kucuk kare kontrol ediliyor bitis*/
	
	/*tek bir sonuc varsa donulecek*/
	if(count($arrayUnuseNumbers) == 1){
		foreach($arrayUnuseNumbers as $arrayUnuseNumber){
			$sudokuNumbers[$lineColumn[0].'x'.$lineColumn[1]] = $arrayUnuseNumber;
			return $arrayUnuseNumber;
		}
	}else{
		return false;
	}
	/*tek bir sonuc varsa donulecek biris*/
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sudoku Solver</title>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
$(document).ready(function(){
    //jquery kodları burada
});
</script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    
      html, body {
        background-color: #FAFAFA
      }
      table {
        border: 2px solid #000000;
      }
      td {
        border: 1px solid #000000;
        text-align: center;
        vertical-align: middle;  
      }
      input {
        color: #000000;
        padding: 0;
        border: 0;
        text-align: center;
        width: 48px;
        height: 48px;
        font-size: 24px;
        background-color: #FFFFFF;
        outline: none;
      }
      input:disabled {
        background-color: #EEEEEE;
      }
      #cell-0,  #cell-1,  #cell-2  { border-top:    2px solid #000000; }
      #cell-2,  #cell-11, #cell-20 { border-right:  2px solid #000000; }
      #cell-18, #cell-19, #cell-20 { border-bottom: 2px solid #000000; }
      #cell-0,  #cell-9,  #cell-18 { border-left:   2px solid #000000; }
      #cell-3,  #cell-4,  #cell-5  { border-top:    2px solid #000000; }
      #cell-5,  #cell-14, #cell-23 { border-right:  2px solid #000000; }
      #cell-21, #cell-22, #cell-23 { border-bottom: 2px solid #000000; }
      #cell-3,  #cell-12, #cell-21 { border-left:   2px solid #000000; }
      #cell-6,  #cell-7,  #cell-8  { border-top:    2px solid #000000; }
      #cell-8,  #cell-17, #cell-26 { border-right:  2px solid #000000; }
      #cell-24, #cell-25, #cell-26 { border-bottom: 2px solid #000000; }
      #cell-6,  #cell-15, #cell-24 { border-left:   2px solid #000000; }
      #cell-27, #cell-28, #cell-29 { border-top:    2px solid #000000; }
      #cell-29, #cell-38, #cell-47 { border-right:  2px solid #000000; }
      #cell-45, #cell-46, #cell-47 { border-bottom: 2px solid #000000; }
      #cell-27, #cell-36, #cell-45 { border-left:   2px solid #000000; }
      #cell-30, #cell-31, #cell-32 { border-top:    2px solid #000000; }
      #cell-32, #cell-41, #cell-50 { border-right:  2px solid #000000; }
      #cell-48, #cell-49, #cell-50 { border-bottom: 2px solid #000000; }
      #cell-30, #cell-39, #cell-48 { border-left:   2px solid #000000; }
      #cell-33, #cell-34, #cell-35 { border-top:    2px solid #000000; }
      #cell-35, #cell-44, #cell-53 { border-right:  2px solid #000000; }
      #cell-51, #cell-52, #cell-53 { border-bottom: 2px solid #000000; }
      #cell-33, #cell-42, #cell-51 { border-left:   2px solid #000000; }
      #cell-54, #cell-55, #cell-56 { border-top:    2px solid #000000; }
      #cell-56, #cell-65, #cell-74 { border-right:  2px solid #000000; }
      #cell-72, #cell-73, #cell-74 { border-bottom: 2px solid #000000; }
      #cell-54, #cell-63, #cell-72 { border-left:   2px solid #000000; }
      #cell-57, #cell-58, #cell-59 { border-top:    2px solid #000000; }
      #cell-59, #cell-68, #cell-77 { border-right:  2px solid #000000; }
      #cell-75, #cell-76, #cell-77 { border-bottom: 2px solid #000000; }
      #cell-57, #cell-66, #cell-75 { border-left:   2px solid #000000; }
      #cell-60, #cell-61, #cell-62 { border-top:    2px solid #000000; }
      #cell-62, #cell-71, #cell-80 { border-right:  2px solid #000000; }
      #cell-78, #cell-79, #cell-80 { border-bottom: 2px solid #000000; }
      #cell-60, #cell-69, #cell-78 { border-left:   2px solid #000000; }
    </style>
</head>
 
<body>


    <div class="container">
      
      <h1>Sudoku Solver</h1>

      <table id="grid" align="left">

        <tr>
          <td><input id="cell-0"  type="text" value="<?=$sudokuNumbersOrj["1x1"]?>" disabled></td>
          <td><input id="cell-1"  type="text" value="<?=$sudokuNumbersOrj["1x2"]?>" disabled></td>
          <td><input id="cell-2"  type="text" value="<?=$sudokuNumbersOrj["1x3"]?>" disabled></td>
          
          <td><input id="cell-3"  type="text" value="<?=$sudokuNumbersOrj["1x4"]?>" disabled></td>
          <td><input id="cell-4"  type="text" value="<?=$sudokuNumbersOrj["1x5"]?>" disabled></td>
          <td><input id="cell-5"  type="text" value="<?=$sudokuNumbersOrj["1x6"]?>" disabled></td>
          
          <td><input id="cell-6"  type="text" value="<?=$sudokuNumbersOrj["1x7"]?>" disabled></td>
          <td><input id="cell-7"  type="text" value="<?=$sudokuNumbersOrj["1x8"]?>" disabled></td>
          <td><input id="cell-8"  type="text" value="<?=$sudokuNumbersOrj["1x9"]?>" disabled></td>
        </tr>

        <tr>
          <td><input id="cell-9"  type="text" value="<?=$sudokuNumbersOrj["2x1"]?>" disabled></td>
          <td><input id="cell-10" type="text" value="<?=$sudokuNumbersOrj["2x2"]?>" disabled></td>
          <td><input id="cell-11" type="text" value="<?=$sudokuNumbersOrj["2x3"]?>" disabled></td>
          
          <td><input id="cell-12" type="text" value="<?=$sudokuNumbersOrj["2x4"]?>" disabled></td>
          <td><input id="cell-13" type="text" value="<?=$sudokuNumbersOrj["2x5"]?>" disabled></td>
          <td><input id="cell-14" type="text" value="<?=$sudokuNumbersOrj["2x6"]?>" disabled></td>
          
          <td><input id="cell-15" type="text" value="<?=$sudokuNumbersOrj["2x7"]?>" disabled></td>
          <td><input id="cell-16" type="text" value="<?=$sudokuNumbersOrj["2x8"]?>" disabled></td>
          <td><input id="cell-17" type="text" value="<?=$sudokuNumbersOrj["2x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-18" type="text" value="<?=$sudokuNumbersOrj["3x1"]?>" disabled></td>
          <td><input id="cell-19" type="text" value="<?=$sudokuNumbersOrj["3x2"]?>" disabled></td>
          <td><input id="cell-20" type="text" value="<?=$sudokuNumbersOrj["3x3"]?>" disabled></td>
          
          <td><input id="cell-21" type="text" value="<?=$sudokuNumbersOrj["3x4"]?>" disabled></td>
          <td><input id="cell-22" type="text" value="<?=$sudokuNumbersOrj["3x5"]?>" disabled></td>
          <td><input id="cell-23" type="text" value="<?=$sudokuNumbersOrj["3x6"]?>" disabled></td>
          
          <td><input id="cell-24" type="text" value="<?=$sudokuNumbersOrj["3x7"]?>" disabled></td>
          <td><input id="cell-25" type="text" value="<?=$sudokuNumbersOrj["3x8"]?>" disabled></td>
          <td><input id="cell-26" type="text" value="<?=$sudokuNumbersOrj["3x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-27" type="text" value="<?=$sudokuNumbersOrj["4x1"]?>" disabled></td>
          <td><input id="cell-28" type="text" value="<?=$sudokuNumbersOrj["4x2"]?>" disabled></td>
          <td><input id="cell-29" type="text" value="<?=$sudokuNumbersOrj["4x3"]?>" disabled></td>
          
          <td><input id="cell-30" type="text" value="<?=$sudokuNumbersOrj["4x4"]?>" disabled></td>
          <td><input id="cell-31" type="text" value="<?=$sudokuNumbersOrj["4x5"]?>" disabled></td>
          <td><input id="cell-32" type="text" value="<?=$sudokuNumbersOrj["4x6"]?>" disabled></td>
          
          <td><input id="cell-33" type="text" value="<?=$sudokuNumbersOrj["4x7"]?>" disabled></td>
          <td><input id="cell-34" type="text" value="<?=$sudokuNumbersOrj["4x8"]?>" disabled></td>
          <td><input id="cell-35" type="text" value="<?=$sudokuNumbersOrj["4x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-36" type="text" value="<?=$sudokuNumbersOrj["5x1"]?>" disabled></td>
          <td><input id="cell-37" type="text" value="<?=$sudokuNumbersOrj["5x2"]?>" disabled></td>
          <td><input id="cell-38" type="text" value="<?=$sudokuNumbersOrj["5x3"]?>" disabled></td>
          
          <td><input id="cell-39" type="text" value="<?=$sudokuNumbersOrj["5x4"]?>" disabled></td>
          <td><input id="cell-40" type="text" value="<?=$sudokuNumbersOrj["5x5"]?>" disabled></td>
          <td><input id="cell-41" type="text" value="<?=$sudokuNumbersOrj["5x6"]?>" disabled></td>
          
          <td><input id="cell-42" type="text" value="<?=$sudokuNumbersOrj["5x7"]?>" disabled></td>
          <td><input id="cell-43" type="text" value="<?=$sudokuNumbersOrj["5x8"]?>" disabled></td>
          <td><input id="cell-44" type="text" value="<?=$sudokuNumbersOrj["5x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-45" type="text" value="<?=$sudokuNumbersOrj["6x1"]?>" disabled></td>
          <td><input id="cell-46" type="text" value="<?=$sudokuNumbersOrj["6x2"]?>" disabled></td>
          <td><input id="cell-47" type="text" value="<?=$sudokuNumbersOrj["6x3"]?>" disabled></td>
          
          <td><input id="cell-48" type="text" value="<?=$sudokuNumbersOrj["6x4"]?>" disabled></td>
          <td><input id="cell-49" type="text" value="<?=$sudokuNumbersOrj["6x5"]?>" disabled></td>
          <td><input id="cell-50" type="text" value="<?=$sudokuNumbersOrj["6x6"]?>" disabled></td>
          
          <td><input id="cell-51" type="text" value="<?=$sudokuNumbersOrj["6x7"]?>" disabled></td>
          <td><input id="cell-52" type="text" value="<?=$sudokuNumbersOrj["6x8"]?>" disabled></td>
          <td><input id="cell-53" type="text" value="<?=$sudokuNumbersOrj["6x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-54" type="text" value="<?=$sudokuNumbersOrj["7x1"]?>" disabled></td>
          <td><input id="cell-55" type="text" value="<?=$sudokuNumbersOrj["7x2"]?>" disabled></td>
          <td><input id="cell-56" type="text" value="<?=$sudokuNumbersOrj["7x3"]?>" disabled></td>
          
          <td><input id="cell-57" type="text" value="<?=$sudokuNumbersOrj["7x4"]?>" disabled></td>
          <td><input id="cell-58" type="text" value="<?=$sudokuNumbersOrj["7x5"]?>" disabled></td>
          <td><input id="cell-59" type="text" value="<?=$sudokuNumbersOrj["7x6"]?>" disabled></td>
          
          <td><input id="cell-60" type="text" value="<?=$sudokuNumbersOrj["7x7"]?>" disabled></td>
          <td><input id="cell-61" type="text" value="<?=$sudokuNumbersOrj["7x8"]?>" disabled></td>
          <td><input id="cell-62" type="text" value="<?=$sudokuNumbersOrj["7x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-63" type="text" value="<?=$sudokuNumbersOrj["8x1"]?>" disabled></td>
          <td><input id="cell-64" type="text" value="<?=$sudokuNumbersOrj["8x2"]?>" disabled></td>
          <td><input id="cell-65" type="text" value="<?=$sudokuNumbersOrj["8x3"]?>" disabled></td>
          
          <td><input id="cell-66" type="text" value="<?=$sudokuNumbersOrj["8x4"]?>" disabled></td>
          <td><input id="cell-67" type="text" value="<?=$sudokuNumbersOrj["8x5"]?>" disabled></td>
          <td><input id="cell-68" type="text" value="<?=$sudokuNumbersOrj["8x6"]?>" disabled></td>
          
          <td><input id="cell-69" type="text" value="<?=$sudokuNumbersOrj["8x7"]?>" disabled></td>
          <td><input id="cell-70" type="text" value="<?=$sudokuNumbersOrj["8x8"]?>" disabled></td>
          <td><input id="cell-71" type="text" value="<?=$sudokuNumbersOrj["8x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-72" type="text" value="<?=$sudokuNumbersOrj["9x1"]?>" disabled></td>
          <td><input id="cell-73" type="text" value="<?=$sudokuNumbersOrj["9x2"]?>" disabled></td>
          <td><input id="cell-74" type="text" value="<?=$sudokuNumbersOrj["9x3"]?>" disabled></td>
          
          <td><input id="cell-75" type="text" value="<?=$sudokuNumbersOrj["9x4"]?>" disabled></td>
          <td><input id="cell-76" type="text" value="<?=$sudokuNumbersOrj["9x5"]?>" disabled></td>
          <td><input id="cell-77" type="text" value="<?=$sudokuNumbersOrj["9x6"]?>" disabled></td>
          
          <td><input id="cell-78" type="text" value="<?=$sudokuNumbersOrj["9x7"]?>" disabled></td>
          <td><input id="cell-79" type="text" value="<?=$sudokuNumbersOrj["9x8"]?>" disabled></td>
          <td><input id="cell-80" type="text" value="<?=$sudokuNumbersOrj["9x9"]?>" disabled></td>
        </tr>

      </table>
	  
	  <!--######-->
	  
	  <table id="grid" align="right">

        <tr>
          <td><input id="cell-0"  type="text" value="<?=$sudokuNumbers["1x1"]?>" disabled></td>
          <td><input id="cell-1"  type="text" value="<?=$sudokuNumbers["1x2"]?>" disabled></td>
          <td><input id="cell-2"  type="text" value="<?=$sudokuNumbers["1x3"]?>" disabled></td>
          
          <td><input id="cell-3"  type="text" value="<?=$sudokuNumbers["1x4"]?>" disabled></td>
          <td><input id="cell-4"  type="text" value="<?=$sudokuNumbers["1x5"]?>" disabled></td>
          <td><input id="cell-5"  type="text" value="<?=$sudokuNumbers["1x6"]?>" disabled></td>
          
          <td><input id="cell-6"  type="text" value="<?=$sudokuNumbers["1x7"]?>" disabled></td>
          <td><input id="cell-7"  type="text" value="<?=$sudokuNumbers["1x8"]?>" disabled></td>
          <td><input id="cell-8"  type="text" value="<?=$sudokuNumbers["1x9"]?>" disabled></td>
        </tr>

        <tr>
          <td><input id="cell-9"  type="text" value="<?=$sudokuNumbers["2x1"]?>" disabled></td>
          <td><input id="cell-10" type="text" value="<?=$sudokuNumbers["2x2"]?>" disabled></td>
          <td><input id="cell-11" type="text" value="<?=$sudokuNumbers["2x3"]?>" disabled></td>
          
          <td><input id="cell-12" type="text" value="<?=$sudokuNumbers["2x4"]?>" disabled></td>
          <td><input id="cell-13" type="text" value="<?=$sudokuNumbers["2x5"]?>" disabled></td>
          <td><input id="cell-14" type="text" value="<?=$sudokuNumbers["2x6"]?>" disabled></td>
          
          <td><input id="cell-15" type="text" value="<?=$sudokuNumbers["2x7"]?>" disabled></td>
          <td><input id="cell-16" type="text" value="<?=$sudokuNumbers["2x8"]?>" disabled></td>
          <td><input id="cell-17" type="text" value="<?=$sudokuNumbers["2x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-18" type="text" value="<?=$sudokuNumbers["3x1"]?>" disabled></td>
          <td><input id="cell-19" type="text" value="<?=$sudokuNumbers["3x2"]?>" disabled></td>
          <td><input id="cell-20" type="text" value="<?=$sudokuNumbers["3x3"]?>" disabled></td>
          
          <td><input id="cell-21" type="text" value="<?=$sudokuNumbers["3x4"]?>" disabled></td>
          <td><input id="cell-22" type="text" value="<?=$sudokuNumbers["3x5"]?>" disabled></td>
          <td><input id="cell-23" type="text" value="<?=$sudokuNumbers["3x6"]?>" disabled></td>
          
          <td><input id="cell-24" type="text" value="<?=$sudokuNumbers["3x7"]?>" disabled></td>
          <td><input id="cell-25" type="text" value="<?=$sudokuNumbers["3x8"]?>" disabled></td>
          <td><input id="cell-26" type="text" value="<?=$sudokuNumbers["3x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-27" type="text" value="<?=$sudokuNumbers["4x1"]?>" disabled></td>
          <td><input id="cell-28" type="text" value="<?=$sudokuNumbers["4x2"]?>" disabled></td>
          <td><input id="cell-29" type="text" value="<?=$sudokuNumbers["4x3"]?>" disabled></td>
          
          <td><input id="cell-30" type="text" value="<?=$sudokuNumbers["4x4"]?>" disabled></td>
          <td><input id="cell-31" type="text" value="<?=$sudokuNumbers["4x5"]?>" disabled></td>
          <td><input id="cell-32" type="text" value="<?=$sudokuNumbers["4x6"]?>" disabled></td>
          
          <td><input id="cell-33" type="text" value="<?=$sudokuNumbers["4x7"]?>" disabled></td>
          <td><input id="cell-34" type="text" value="<?=$sudokuNumbers["4x8"]?>" disabled></td>
          <td><input id="cell-35" type="text" value="<?=$sudokuNumbers["4x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-36" type="text" value="<?=$sudokuNumbers["5x1"]?>" disabled></td>
          <td><input id="cell-37" type="text" value="<?=$sudokuNumbers["5x2"]?>" disabled></td>
          <td><input id="cell-38" type="text" value="<?=$sudokuNumbers["5x3"]?>" disabled></td>
          
          <td><input id="cell-39" type="text" value="<?=$sudokuNumbers["5x4"]?>" disabled></td>
          <td><input id="cell-40" type="text" value="<?=$sudokuNumbers["5x5"]?>" disabled></td>
          <td><input id="cell-41" type="text" value="<?=$sudokuNumbers["5x6"]?>" disabled></td>
          
          <td><input id="cell-42" type="text" value="<?=$sudokuNumbers["5x7"]?>" disabled></td>
          <td><input id="cell-43" type="text" value="<?=$sudokuNumbers["5x8"]?>" disabled></td>
          <td><input id="cell-44" type="text" value="<?=$sudokuNumbers["5x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-45" type="text" value="<?=$sudokuNumbers["6x1"]?>" disabled></td>
          <td><input id="cell-46" type="text" value="<?=$sudokuNumbers["6x2"]?>" disabled></td>
          <td><input id="cell-47" type="text" value="<?=$sudokuNumbers["6x3"]?>" disabled></td>
          
          <td><input id="cell-48" type="text" value="<?=$sudokuNumbers["6x4"]?>" disabled></td>
          <td><input id="cell-49" type="text" value="<?=$sudokuNumbers["6x5"]?>" disabled></td>
          <td><input id="cell-50" type="text" value="<?=$sudokuNumbers["6x6"]?>" disabled></td>
          
          <td><input id="cell-51" type="text" value="<?=$sudokuNumbers["6x7"]?>" disabled></td>
          <td><input id="cell-52" type="text" value="<?=$sudokuNumbers["6x8"]?>" disabled></td>
          <td><input id="cell-53" type="text" value="<?=$sudokuNumbers["6x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-54" type="text" value="<?=$sudokuNumbers["7x1"]?>" disabled></td>
          <td><input id="cell-55" type="text" value="<?=$sudokuNumbers["7x2"]?>" disabled></td>
          <td><input id="cell-56" type="text" value="<?=$sudokuNumbers["7x3"]?>" disabled></td>
          
          <td><input id="cell-57" type="text" value="<?=$sudokuNumbers["7x4"]?>" disabled></td>
          <td><input id="cell-58" type="text" value="<?=$sudokuNumbers["7x5"]?>" disabled></td>
          <td><input id="cell-59" type="text" value="<?=$sudokuNumbers["7x6"]?>" disabled></td>
          
          <td><input id="cell-60" type="text" value="<?=$sudokuNumbers["7x7"]?>" disabled></td>
          <td><input id="cell-61" type="text" value="<?=$sudokuNumbers["7x8"]?>" disabled></td>
          <td><input id="cell-62" type="text" value="<?=$sudokuNumbers["7x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-63" type="text" value="<?=$sudokuNumbers["8x1"]?>" disabled></td>
          <td><input id="cell-64" type="text" value="<?=$sudokuNumbers["8x2"]?>" disabled></td>
          <td><input id="cell-65" type="text" value="<?=$sudokuNumbers["8x3"]?>" disabled></td>
          
          <td><input id="cell-66" type="text" value="<?=$sudokuNumbers["8x4"]?>" disabled></td>
          <td><input id="cell-67" type="text" value="<?=$sudokuNumbers["8x5"]?>" disabled></td>
          <td><input id="cell-68" type="text" value="<?=$sudokuNumbers["8x6"]?>" disabled></td>
          
          <td><input id="cell-69" type="text" value="<?=$sudokuNumbers["8x7"]?>" disabled></td>
          <td><input id="cell-70" type="text" value="<?=$sudokuNumbers["8x8"]?>" disabled></td>
          <td><input id="cell-71" type="text" value="<?=$sudokuNumbers["8x9"]?>" disabled></td>
        </tr>

        <tr>          
          <td><input id="cell-72" type="text" value="<?=$sudokuNumbers["9x1"]?>" disabled></td>
          <td><input id="cell-73" type="text" value="<?=$sudokuNumbers["9x2"]?>" disabled></td>
          <td><input id="cell-74" type="text" value="<?=$sudokuNumbers["9x3"]?>" disabled></td>
          
          <td><input id="cell-75" type="text" value="<?=$sudokuNumbers["9x4"]?>" disabled></td>
          <td><input id="cell-76" type="text" value="<?=$sudokuNumbers["9x5"]?>" disabled></td>
          <td><input id="cell-77" type="text" value="<?=$sudokuNumbers["9x6"]?>" disabled></td>
          
          <td><input id="cell-78" type="text" value="<?=$sudokuNumbers["9x7"]?>" disabled></td>
          <td><input id="cell-79" type="text" value="<?=$sudokuNumbers["9x8"]?>" disabled></td>
          <td><input id="cell-80" type="text" value="<?=$sudokuNumbers["9x9"]?>" disabled></td>
        </tr>

      </table>

    </div>


</body>
</html>