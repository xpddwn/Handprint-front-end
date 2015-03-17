<? 
$is_edit = true;
if ($_GET["edit"]=="false") {
  $is_edit = false;
} else {
  parse_str($_SERVER['QUERY_STRING']);
}
include ('header.php');
?>
<div class="edit">
  <div id="log"></div>
  <!-- <form action="admin_do.php" metdod="post"> -->
  <table id="tab" class="tab_div">
   <?php
   $f = $files[0];
   if ($is_edit) {
//foreach ($files as $f) {
    $string = file_get_contents("data/$f.txt");
    $json_a = json_decode($string, true);
  }

  $id = 0;
  $num=1;

  $line= $json_a["item"];
  //add the type of 'text' or create new type 
  if($_GET["message"]=="text"||$_GET["message"]=="new"){
   ?>
   <tr>
    <th class="tab_item"><label>序号</label></th>
    <td class="tab_fd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
  </tr>

  <tr>
    <th class="tab_item"><label>类型</label></th>
    <td class="tab_fd">
      <select name="type"  onchange="addNew(this.value)">
        <?php
        $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
        foreach($types as $key=>$value){
          echo "<option value='$key'>$value</option>";
        }
        ?>
      </select></td>
    </tr>

    <tr>
      <th class="tab_item"><label>X</label></th>
      <td class="tab_fd">
        <input type="text"  name="x" value="<?php 
        echo "0";
        ?>">
      </td>
    </tr>

    <tr>
      <th class="tab_item"><label>Y</label></th>
      <td class="tab_fd">
        <input type="text"  name="y" value="<?php
        echo "0";
        ?>">
      </td>
    </tr>

    <tr>
      <th class="tab_item"><label>字体</label></th>
      <td class="tab_fd">
        <select name="font">
          <?php 
          $fonts = array('simkai' => '楷体', 'wqy-zenhei' => '黑体');
          foreach($fonts as $key=>$value){
            echo "<option value='$key'>$value</option>";
          }
          ?>
        </select>
      </td>
    </tr>

    <tr>
      <th class="tab_item"><label>字号</label></th>
      <td class="tab_fd">
        <input type="text" name="fontsize" value="<?php
        echo "20";
        ?>">
      </td>
    </tr>

    <tr>
      <th class="tab_item"><label>值</label></th>
      <td class="tab_fd">
       <input type="text"  name="content" value="<?php 
       echo "value".($id+1);
       ?>">
     </td>
   </tr>

   <script type="text/javascript">
    var a='<?php echo  json_encode($line); ?>';
  </script>

  <tr>
    <th class="tab_item"><label>操作</label></th>
    <td class="tab_fd">
     <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
   </td>
 </tr>
 <?php
}

    // add the type of 'picture'
else if($_GET["message"]=="picture"){
 ?>
 <tr>
  <th class="tab_item"><label>序号</label></th>
  <td class="tab_fd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_item"><label>类型</label></th>
  <td class="tab_fd"  >
   <select name="type" onchange="addNew(this.value)">
    <?php
    $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
    foreach($types as $key=>$value){
      if($_GET["message"]  == $key){
        echo "<option value='$key' selected='selected'>$value</option>";
      }else{
        echo "<option value='$key'>$value</option>";
      }
    }
    ?>
  </select></td>
</tr>

<tr>
  <th class="tab_item"><label>X</label></th>
  <td class="tab_fd">
    <input type="text"  name="x" value="<?php 
    echo "0" ;
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>Y</label></th>
  <td class="tab_fd">
    <input type="text"  name="y" value="<?php
    echo "0" ;
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>文件名</label></th>
  <td class="tab_fd">
   <input type="text"  name="content" value="<?php 
   echo "new.bmp";
   ?>">
 </td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_item"><label>操作</label></th>
  <td class="tab_fd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

  //add the type of 'qrcode'
  else if($_GET["message"]=="qrcode"){
 ?>
 <tr>
  <th class="tab_item"><label>序号</label></th>
  <td class="tab_fd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_item"><label>类型</label></th>
  <td class="tab_fd"  >
   <select name="type" onchange="addNew(this.value)">
    <?php
    $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
    foreach($types as $key=>$value){
      if($_GET["message"]  == $key){
        echo "<option value='$key' selected='selected'>$value</option>";
      }else{
        echo "<option value='$key'>$value</option>";
      }
    }
    ?>
  </select></td>
</tr>

<tr>
  <th class="tab_item"><label>X</label></th>
  <td class="tab_fd">
    <input type="text"  name="x" value="<?php 
    echo "0" ;
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>Y</label></th>
  <td class="tab_fd">
    <input type="text"  name="y" value="<?php
    echo "0" ;
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>值</label></th>
  <td class="tab_fd">
   <input type="text"  name="content" value="<?php 
   echo "new";
   ?>">
 </td>
</tr>

<tr>
  <th class="tab_item"><label>纠错级别</label></th>
  <td class="tab_fd">
    <select name="refix">
      <?php 
      $fonts = array('L' => 'L-worst', 'M' => 'M','Q' => 'Q','H' => 'H-best');
      foreach($fonts as $key=>$value){
        if($line[$id]["refix"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<tr>
  <th class="tab_item"><label>图案大小</label></th>
  <td class="tab_fd">
    <select name="size">
      <?php 
      $fonts = array('1' => '1', '2' => '2','3' => '3','4' => '4','5' => '5');
      foreach($fonts as $key=>$value){
        if($line[$id]["size"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_item"><label>操作</label></th>
  <td class="tab_fd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

//add the type of 'barcode'
  else if($_GET["message"]=="barcode"){
 ?>
 <tr>
  <th class="tab_item"><label>序号</label></th>
  <td class="tab_fd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_item"><label>类型</label></th>
  <td class="tab_fd"  >
   <select name="type" onchange="addNew(this.value)">
    <?php
    $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
    foreach($types as $key=>$value){
      if($_GET["message"]  == $key){
        echo "<option value='$key' selected='selected'>$value</option>";
      }else{
        echo "<option value='$key'>$value</option>";
      }
    }
    ?>
  </select></td>
</tr>

<tr>
  <th class="tab_item"><label>X</label></th>
  <td class="tab_fd">
    <input type="text"  name="x" value="<?php 
    echo "0" ;
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>Y</label></th>
  <td class="tab_fd">
    <input type="text"  name="y" value="<?php
    echo "0" ;
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>值</label></th>
  <td class="tab_fd">
   <input type="text"  name="content" value="<?php 
   echo "new";
   ?>">
 </td>
</tr>

<tr>
  <th class="tab_item"><label>编码格式</label></th>
  <td class="tab_fd">
    <select name="codetype" onchange="showmessage(this.value)">
      <?php 
      $fonts = array('EAN' => 'EAN-8', 'UPC' => 'UPC-A','S25' => 'S25','I25' => 'I25','Codabar' => 'Codabar','C39' => 'code 39','C128' => 'code 128');
      foreach($fonts as $key=>$value){
        if($line[$id]["codetype"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<tr>
  <th class="tab_item"><label>图案大小</label></th>
  <td class="tab_fd">
    <select name="size">
      <?php 
      $fonts = array('1' => '1', '2' => '2','3' => '3','4' => '4','5' => '5');
      foreach($fonts as $key=>$value){
        if($line[$id]["size"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_item"><label>操作</label></th>
  <td class="tab_fd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

  // add the type of 'counter'
else if($_GET["message"]=="counter"){
 ?>
 <tr>
  <th class="tab_item"><label>序号</label></th>
  <td class="tab_fd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_item"><label>类型</label></th>
  <td class="tab_fd"  >
   <select name="type" onchange="addNew(this.value)">
    <?php
    $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
    foreach($types as $key=>$value){
      if($_GET["message"]  == $key){
        echo "<option value='$key' selected='selected'>$value</option>";
      }else{
        echo "<option value='$key'>$value</option>";
      }
    }
    ?>
  </select></td>
</tr>

<tr>
  <th class="tab_item"><label>X</label></th>
  <td class="tab_fd">
    <input type="text"  name="x" value="<?php 
    echo "0";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>Y</label></th>
  <td class="tab_fd">
    <input type="text"  name="y" value="<?php
    echo "0";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>增减</label></th>
  <td class="tab_fd">
    <select name="updown">
      <?php 
      $fonts = array('up' => '递增', 'down' => '递减');
      foreach($fonts as $key=>$value){
        if($line[$id]["font"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<tr>
  <th class="tab_item"><label>字号</label></th>
  <td class="tab_fd">
    <input type="text" name="fontsize" value="<?php
    echo "20";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>初始值</label></th>
  <td class="tab_fd">
   <input type="text"  name="content" value="<?php 
   echo "0";
   ?>">
 </td>
</tr>

<tr>
  <th class="tab_item"><label>步长</label></th>
  <td class="tab_fd">
   <input type="text"  name="step" value="<?php 
   echo "12";
   ?>">
 </td>
</tr>

<tr>
  <th class="tab_item"><label> 循环</label></th>
  <td class="tab_fd">
   <input type="text"  name="cycle" value="<?php 
   echo "1";
   ?>">
 </td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_item"><label>操作</label></th>
  <td class="tab_fd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

//add the type of 'date'
else if($_GET["message"]=="date"){
 ?>
 <tr>
  <th class="tab_item"><label>序号</label></th>
  <td class="tab_fd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_item"><label>类型</label></th>
  <td class="tab_fd"  >
   <select name="type" onchange="addNew(this.value)">
    <?php
    $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
    foreach($types as $key=>$value){
      if($_GET["message"]  == $key){
        echo "<option value='$key' selected='selected'>$value</option>";
      }else{
        echo "<option value='$key'>$value</option>";
      }
    }
    ?>
  </select></td>
</tr>

<tr>
  <th class="tab_item"><label>X</label></th>
  <td class="tab_fd">
    <input type="text"  name="x" value="<?php 
    echo "0";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>Y</label></th>
  <td class="tab_fd">
    <input type="text"  name="y" value="<?php
    echo "0";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>格式</label></th>
  <td class="tab_fd">
    <select name="dformate">
      <?php 
      $fonts = array('y/m/d' => 'y/m/d', 'y-m-d' => 'y-m-d','y.m.d'=>'y.m.d','y年m月d日'=>'y年m月d日','m/d/y'=>'m/d/y');
      foreach($fonts as $key=>$value){
        if($line[$id]["font"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<tr>
  <th class="tab_item"><label>字号</label></th>
  <td class="tab_fd">
    <input type="text" name="fontsize" value="<?php
    echo "20";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>日期</label></th>
  <td class="tab_fd">
   <input type="text"  name="content" value="<?php 
   date_default_timezone_set('PRC');
   echo $showdate=strftime("%Y/%m/%d" );
   ?>">
 </td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_item"><label>操作</label></th>
  <td class="tab_fd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

//add the type of 'time'
else if($_GET["message"]=="time"){
 ?>
 <tr>
  <th class="tab_item"><label>序号</label></th>
  <td class="tab_fd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_item"><label>类型</label></th>
  <td class="tab_fd"  >
   <select name="type" onchange="addNew(this.value)">
    <?php
    $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
    foreach($types as $key=>$value){
      if($_GET["message"]  == $key){
        echo "<option value='$key' selected='selected'>$value</option>";
      }else{
        echo "<option value='$key'>$value</option>";
      }
    }
    ?>
  </select></td>
</tr>

<tr>
  <th class="tab_item"><label>X</label></th>
  <td class="tab_fd">
    <input type="text"  name="x" value="<?php 
    echo "0";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>Y</label></th>
  <td class="tab_fd">
    <input type="text"  name="y" value="<?php
    echo "0";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>格式</label></th>
  <td class="tab_fd">
    <select name="tformate">
      <?php 
      $fonts = array('h:i:s' => 'H:I:S', 'h:i:s a/p' => 'H:I:S AM','h时i分s秒'=>'H时I分S秒',);
      foreach($fonts as $key=>$value){
        if($line[$id]["font"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<tr>
  <th class="tab_item"><label>字号</label></th>
  <td class="tab_fd">
    <input type="text" name="fontsize" value="<?php
    echo "20";
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_item"><label>时间</label></th>
  <td class="tab_fd">
   <input type="text"  name="content" value="<?php 
   date_default_timezone_set('PRC');
   echo $showtime=strftime("%H:%M:%S" );
   ?>">
 </td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_item"><label>操作</label></th>
  <td class="tab_fd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}
?>
</table>

<!-- </form> -->
</div>

<!-- show the new item in the way of visible -->
<div id="mydiv" class="move_div" >
  <input type="button"  class="btn26" style="position:fixed;left:<?php if($line[$i]["x"]<215) {echo $line[$i]["x"]+250;} else{echo 264;}?>px;top:<?php if($line[$i]["y"]<125){echo $line[$i]["y"]+50;} else{ echo 174;}?>px" value="<?php 
  if($_GET["message"]=="date"){
    echo $showdate;
  }
  else if($_GET["message"]=="time"){
    echo $showtime;
  }
  else  if($_GET["message"]=="counter")
  {
    echo "1";
  }
  else
  {
    echo "value1";
  }
  ?>"  
  onClick=" doshowmessage('<? echo $_SERVER['QUERY_STRING']; ?>','<? echo "message=".$line[$i]["content"] ?>')"/>
</div>


<div class="bottom_fixed_div">
 <input type="button" class="btn6" value="添加字段"  
 onClick=" doshowmessage('<? echo $_SERVER['QUERY_STRING']; ?>','<? echo "message=new"; ?>')" />
 <label for="">文件名:</label>                                                                    
 <input type="text" id='file' value="<?php  echo $_GET["tag"];?>">         

 <input type="button"  class="btn6" value="提交"  onclick=" doJson_new(0)" />
</div>                        
</body>
</html>
