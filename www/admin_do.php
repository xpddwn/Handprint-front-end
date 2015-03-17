<?php
// $_POST = file_get_contents('php://input');
parse_str($_SERVER['QUERY_STRING']);

if ($action == "save") {
  include "lib/tools.php"; //use prettyPrint
  $myFile = "data/" . $files[0] . ".txt";
  $fh = fopen($myFile, 'w') or die("can't open file");
  $stringData = prettyPrint(file_get_contents('php://input'));
  fwrite($fh, $stringData);
  fclose($fh);
  echo "save success!";
} else if ($action == "delete") {
  foreach ($files as $file) {
    unlink("data/" . $file . ".txt");
  }
  echo "delete success!";
}  else if ($action == "print") {
  include "lib/tools.php"; //use gen_html_and_bmp
  include "lib/config.php";

  $result = gen_html_and_bmp($files[0]);
  // print_r($result);
  $out_html = $result[1];;
  $out_bmp = $result[2];
  $counter = $result[3];
  echo $counter;
  $counter_number = $result[4];
  $date_number = $result[5];
  $time_number = $result[6];
  $date = $result[7];
  $time = $result[8];

  // update config;
  $settings = get_parse_ini($inifile);
  $settings['preview']['latest_file'] = $files[0];
  put_ini_file($inifile,$settings, $i = 0);

  $absolute_bmp = getcwd()."/".$out_bmp;

  ///////////////////////////////////////
  // load config and pass to driver
  $config_args = $settings['system']['col_delay'] . " " . $settings['system']['on_delay']. " " . $settings['system']['direction']. " " . $settings['system']['sync_mode'];
  ///////////////////////////////////////


  ///////////////////////////////////////
  //create the config file
  $cgi = "cgi.arg";
  $config_file = fopen($cgi, 'w') or die("can't open file");
  $content = $config_args." ".$counter_number." ".$date_number." ".$time_number;
  if($counter_number!=0)
  {
    for($i=0;$i<$counter_number;$i++)
    {
      $content = $content." ". $counter[$i]['x'] . " " . $counter[$i]['y']. " " .$counter[$i]['fontsize']. " ". $counter[$i]['content'] . " " . $counter[$i]['step'];
    }
  }
  
  if($date_number!=0)
  {
    for($j=0;$j<$date_number;$j++)
    {
      $content = $content." ". $date[$j]['x'] . " " . $date[$j]['y']. " " . $date[$j]['fontsize'] . " 0";
    }
  }
  
  if($time_number!=0)
  {
    for($k=0;$k<$time_number;$k++)
    {
      $content = $content." ". $time[$k]['x']." ". $time[$k]['y']." ". $time[$k]['fontsize']." 0";
    }
  }
  
  fwrite($config_file, $content);
  fclose($config_file);

  $cmd = "send_printer print $absolute_bmp cgi.arg 2>&1";
  // echo $cmd;
  system($cmd, $retval);
}
else if($action == "stop")
{
  $cmd = "send_printer stop";
  // echo $cmd;
  system($cmd, $retval);
}
else {
  echo "err action";
}
?>
