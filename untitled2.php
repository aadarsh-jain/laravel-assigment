<?php
  $__fp = fopen("php://stdin", "r");
  $all_lines = array();

  $res = 0; // will win match(s)
  $stdout = fopen('php://stdout', 'w');
  $t = $line = fgets($__fp);

  // data reading part
  if ($t == 1){
    while($line = fgets($__fp)){
      $all_lines[0][] = $line;
    }
  }else if($t > 1){
    $i = 0;
    $j = 1;
    while($line = fgets($__fp)){
      $all_lines[$i][] = $line;
      if($j%3 == 0){
        $i++;
      }
      $j++;
      //break;
    }
  }
  else{
    fwrite($stdout, $res . PHP_EOL);
  }
  fclose($__fp);
  
  // calcualtion of the power
  foreach($all_lines as $each_line){
    //check for null
    if($each_line[0] == '' || $each_line[1] == '' || $each_line[2] == ''){
      fwrite($stdout, $res . PHP_EOL);  
      continue;
    }
    //check for actual correct data
    $n  = $each_line[0];
    $gt = explode(' ', trim($each_line[1]));
    $at = explode(' ', trim($each_line[2]));
    rsort($gt);
    rsort($at);
    print_r($n.PHP_EOL);
    print_r(implode(' ',$gt).PHP_EOL);
    print_r(implode(' ',$at).PHP_EOL.PHP_EOL);
    $i = 0;
    // checking how many players are of greater power
    for(; $i < $n; $i++){
      if($gt[0] > $at[$i]){
        break;
      }
    }
    $gp = $i; // greater power
    $s  = 0;  // same count
    $l  = 0;  // less power
    // checking how many players are having same power,match tie
    $i = 0;
    $k = 0;
    for(; $i < $n; $i++){
      $k = $gp+$i+$l;
      // if($k > $n){
      //   break;
      // }
      if($gt[$i] == $at[$k]){
        $s++;
      }
      else if($gt[$i] < $at[$k]){
        $l++;
      }
    }
    $res = $n - $gp - $s - $l;
    fwrite($stdout, $res . PHP_EOL);    
  }
  fclose($stdout);
?>