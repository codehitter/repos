<?php

/* Enter your code here. Read input from STDIN. Print output to STDOUT */
//$stdin = fopen('php://stdin', 'r');
$handle = fopen('input.txt', 'r');
$i = 0;
$nwords = 0;
$j = 0;
$paragraphWords;
global $nwords;
while (($buffer = fgets($handle)) !== false) {
      if ($i == 0) {
            $paragraph = $buffer;
      } else
      if ($i == 1) {
            $nwords = intval(trim($buffer));
      }
      if ($i > 1) {
            $words[$j] = $buffer;
            $j++;
      }
      $i++;
}

$paragraphStripped = preg_replace("/[^A-Za-z ]/u", "", $paragraph);
$paragraphStripped=str_replace("  "," ",$paragraphStripped);
$paragraphWords = explode(" ", $paragraphStripped);
$wordCount = str_word_count($paragraphStripped);
$flag=1;
if($nwords>count($words)||count(count($words))==0){
    echo "NO SUBSEGMENT FOUND";
    die;
}

if ($nwords <= 0 || $nwords > $wordCount) {
    $flag=0;
     // echo "Invalid number of  words given";
   // echo "NO SUBSEGMENT FOUND";
      die;
}
//$paragraphWords[200000];
$wordsInpara = str_word_count($paragraphStripped, 1);
foreach ($wordsInpara as $singleWord) {
      if (strlen($singleWord) >= 15) {
          $flag=0;
          //  echo "Word length should not exceed 15";
         // echo "NO SUBSEGMENT FOUND";
            die;
      }
}


$direction = "";

$words = array_map('trim', $words);
$words = array_map('strtolower', $words);
array_splice($words, $nwords);

for ($i = 0; $i < count($paragraphWords); $i++) {
      if (in_array(strtolower(trim($paragraphWords[$i])), $words)) {
            $key = array_search(strtolower(trim($paragraphWords[$i])), $words);
            $found[] = $i;
            
      }
}

$j = 0;
//print_r($found);
$consecutive;
if($nwords==1){
$consecutive[]=$found[0];
}else
for ($i = 1; $i < count($found); $i++) {
      //print_r($consecutive);echo "\n".count($consecutive);
      if (abs($found[$i] - $found[$i - 1]) == 1) {
            if($j==0){
                  $pointer=$i;
            }
            $consecutive[$j] = $found[$i - 1];
            $j++;
            if (count($consecutive) == $nwords - 1) {
                  // echo "asdasd";
                  $consecutive[$j] = $found[$i];
                  $count = 0;
                 // print_r($consecutive);
                  $words1=$words;
                  for ($k = 0; $k <count($consecutive); $k++) {
                        if (in_array(strtolower(trim($paragraphWords[$consecutive[$k]])), $words1)) {
                              $key=  array_search(strtolower(trim($paragraphWords[$consecutive[$k]])), $words1);
                              //echo strtolower(trim($paragraphWords[$consecutive[$k]]));
                              unset($words1[$key]);
                              $count++;
                        }

                  }
                  //echo $count.'/'.$nwords;
                  if ($count == $nwords)
                        break;
                  else{
                       // echo $i.'<br>';
                        $consecutive = "";
                        $i=$pointer;
                        $j=0;
                  }
            }
      } else {
            $consecutive = "";
            $j = 0;
      }
}
//echo $direction;
$strFinal="";
if(count($consecutive)<$nwords){
      $consecutive = "";
}
//print_r($consecutive);
if ($consecutive!="")
      foreach ($consecutive as $consec) {
            $arrFinal[] = $paragraphWords[$consec];
            $strFinal = implode(" ", $arrFinal);
      }
if($strFinal)
      echo trim($strFinal);
else
      echo "NO SUBSEGMENT FOUND";
?>