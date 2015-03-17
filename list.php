<?php include ('header.php');?>
		<div class="editres" >
				<div id="log"></div>
		<table class="tab_div">
			<tr>
			<th class="tab_set">选择</th>
			<th class="tab_set">配置文件</th>
			</tr>
				<?php	
				function sbasename($filename) {
return preg_replace('/^.+[\\\\\\/]/', '', $filename);
}			
$files = glob('data/*.txt');
foreach ($files as $fpath) {
$name = substr(sbasename($fpath),0,-4);
				?>
				<tr>
				<td class="tab_dd" style="height:25px"><input type="checkbox" name="file" value="<?=$name ?>"></td>
				<td class="tab_dd" style="height:25px"><?php echo $name ?></td>
				</tr>
				<?php } ?>
			
		</table>
	</div>

<?php
$tag='new'.rand(1,100);
?>

<div class="shade_div">
</div>

<div class="bottom_fixed_div cab" > 
<input type="button"  onClick="window.location.href='new.php?files[]=<? echo  $tag;?>&message=new&edit=false&&tag=<? echo  $tag;?>'" value="新建" />
  <input type="button"  onClick='doActionEdit()'  value="编辑" />
 <input type="button"   onClick='doActionDel()'  value="删除" />
<input type="button"  value="预览"  onClick='doActionPreview()'  />    
 <input type="button"  value="打印"   onClick='doActionPrint()'  />    
</div>
</div>
	</body>
</html>
