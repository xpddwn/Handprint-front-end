<?php
include "lib/tools.php";
include "lib/config.php";
parse_str($_SERVER['QUERY_STRING']);
$result = gen_html_and_bmp($files[0]);
$retval = $result[0];
$out_html = $result[1];
$out_bmp = $result[2];

$settings = get_parse_ini($inifile);
$settings['preview']['latest_file'] = $files[0];
put_ini_file($inifile,$settings, $i = 0);
include ('header.php');
?>
    <div >
        <img class="img_border" src='<?=$out_bmp?>'>
    </div>
    <div class="bottom_fixed_div">
    <input type="submit" value="打印" onclick="doActionPrint('files[]=<?=$files[0]?>')" />
    </div>
  </div>
</body>
</html>
