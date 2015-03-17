<?php
include "lib/config.php";
$settings = get_parse_ini($inifile);
$latest = $settings['preview']['latest_file'];
include ('header.php');
?>
		
		<div >
		<div id="log"></div>
				<img class="img_border" src='./print/<?=$latest?>.bmp'>
					<!--onclick="window.location='admin_do.php?action=print&files[]=<?=$latest?>';" />-->
		</div>
		<div class="bottom_fixed_div">
			<input type="button" value="打印"  onclick="doActionPrint('files[]=<?=$latest?>')"/> 
			<input type="button" value="停止"  onclick="doActionStop()"/>  
		</div>
	</div>
</body>
</html>
