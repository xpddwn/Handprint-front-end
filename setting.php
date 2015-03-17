<?php 
include ('header.php');
?>

		<div class="setting "class="cab">

		<div id="log" class="cab">
<?php
	include "lib/config.php";
	$settings = get_parse_ini($inifile);
if($_POST){
	$cmd = 'date -s "'.$_POST['date'].' '.$_POST['time'].'" 1>/dev/null;hwclock -w 1>/dev/null';
	system($cmd);
	$settings['system'] = $_POST;
	put_ini_file($inifile,$settings, $i = 0);
}
?>
</div>

		<form method="post">
		<table class="tab_div">
		<tr>
		<th class="tab_setting">
		配置项
		</th>
		<th class="tab_header">值
		</th>
		</tr>
		<tr><td class="tab_td">本地日期</td><td id="date"></td></tr>
		<tr><td class="tab_td">本地时间</td><td id="time"></td></tr>
		<tr><td class="tab_td">列间延迟</td><td id="col_delay"><input type="text" name="col_delay" value="<?php echo $settings['system']['col_delay']?>"></td></tr>
		<tr><td class="tab_td">起始延迟</td><td id="on_delay"><input type="text" name="on_delay" value="<?php echo $settings['system']['on_delay']?>"></td></tr>
		<tr><td class="tab_td">打印方向</td><td id="direction"><input type="text" name="direction" value="<?php echo $settings['system']['direction']?>"></td></tr>
		<tr><td class="tab_td">同步模式</td><td id="sync_mode"><input type="text" name="sync_mode" value="<?php echo $settings['system']['sync_mode']?>"></td></tr>
		</table>
		<input type="submit" value="提交">
		</form>
</div>

<div class="bottom_fixed_div cab" > 
 <input type="button" style="width: 70px;height: 30px;border-radius: 3px" value="屏幕校准" onclick="doCalibrate()" />
</div>

</body>
<script type="text/javascript">
function getDate(deli){
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){dd='0'+dd} 
if(mm<10){mm='0'+mm} 
today = yyyy + deli + mm+ deli +dd;
return today;
}


function getTime(deli){
var now = new Date();
 var hh = now.getHours();            //时
 var mm = now.getMinutes();          //分
if(hh<10){hh='0'+hh} 
if(mm<10){mm='0'+mm} 
now = hh+ deli + mm;
return now;
}
document.getElementById('date').innerHTML = '<input type="text" name="date" value="' + getDate('-') + '">';
document.getElementById('time').innerHTML = '<input type="text" name="time" value="' + getTime(':') + '">';
</script>
</html>
