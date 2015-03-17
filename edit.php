<? 
$is_edit = true;
if (empty($_SERVER['QUERY_STRING'])) {
  $is_edit = false;
} else {
  parse_str($_SERVER['QUERY_STRING']);
}
include ('header.php');
?>
<div  class="editres cab"  style="visibility:<? if($_GET["flag"]=="true"){ echo 'hidden';} else{echo 'visible';}?>">
  <div id="log" ></div>
  <!-- <form action="admin_do.php" metdod="post"> -->
  <table  id="tab" class="tab_div" >
   <?php
   if ($is_edit) {
    $f = $files[0];
//foreach ($files as $f) {
    $string = file_get_contents("data/$f.txt");
    $json_a = json_decode($string, true);

    $id = $_GET["index"]-1;
    $line= $json_a["item"];

    $num = count($line);
    if($_GET["tag"]=="new"){
      $num++;
    }

    //edit the item of ‘text’
    if($_GET["message"]=="text")
    {
     ?>
     <tr>
      <th class="tab_set"><label>序号</label></th>
      <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
    </tr>

    <tr>
      <th class="tab_set"><label>类型</label></th>
      <td class="tab_dd">
       <select name="type"  onchange="<?php 
       if($_GET["tag"]=="new"){
         ?>
         addItem(this.value,<? echo $id; ?>)
         <?php
       }
       else{
        ?>
        addCell(this.value,<? echo $id; ?>)
        <?php
      }
      ?>">
      <?php
      $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
      foreach($types as $key=>$value){
        if($_GET["message"] == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }else{
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select></td>
  </tr>

  <tr>
    <th class="tab_set"><label>X</label></th>
    <td class="tab_dd">
      <input type="text"  name="x" value="<?php 
      if($line[$id]["x"]!=""){
       echo $line[$id]["x"] ; 
     }
     else
     {
      echo "0";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>Y</label></th>
  <td class="tab_dd">
    <input type="text"  name="y" value="<?php
    if($line[$id]["content"]!=""){
      echo $line[$id]["y"] ;
    }
    else
    {
      echo "0";
    }

    ?>">
  </td>
</tr>

<tr id="tag1">
  <th class="tab_set"><label>字体</label></th>
  <td class="tab_dd">
    <select name="font">
      <?php 
      $fonts = array('simkai' => '楷体', 'wqy-zenhei' => '黑体');
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
  <th class="tab_set"><label>字号</label></th>
  <td class="tab_dd">
    <input type="text" name="fontsize" value="<?php
    if($line[$id]["fontsize"]!=""){
      echo $line[$id]["fontsize"] ;
    }
    else
    {
      echo "20";
    }

    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>值</label></th>
  <td class="tab_dd">
   <input type="text"  name="content" value="<?php 
   if($line[$id]["content"]!=""){
    echo $line[$id]["content"] ;
  }
  else
  {
    echo "value".$num;
  }
  
  ?>">
</td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_set"><label>操作</label></th>
  <td class="tab_dd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

// edit the item of 'picture'
else if($_GET["message"]=="picture"){
 ?>
 <tr>
  <th class="tab_set"><label>序号</label></th>
  <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_set"><label>类型</label></th>
  <td class="tab_dd">
   <select name="type" onchange="<?php 
   if($_GET["tag"]=="new"){
     ?>
     addItem(this.value,<? echo $id; ?>)
     <?php
   }
   else{
    ?>
    addCell(this.value,<? echo $id; ?>)
    <?php
  }
  ?>">
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
  <th class="tab_set"><label>X</label></th>
  <td class="tab_dd">
    <input type="text"  name="x" value="<?php 
    if($line[$id]["x"]!=""){
     echo $line[$id]["x"] ; 
   }
   else
   {
    echo "0";
  }
  ?>">
</td>
</tr>

<tr>
  <th class="tab_set"><label>Y</label></th>
  <td class="tab_dd">
    <input type="text"  name="y" value="<?php
    if($line[$id]["content"]!=""){
      echo $line[$id]["y"] ;
    }
    else
    {
      echo "0";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>文件名</label></th>
  <td class="tab_dd">
   <input type="text"  name="content" value="<?php 
   if($_GET["tag"]=="new"){
    echo "new.bmp";
  }
  else
  {
    echo $line[$id]["content"];
  }
  ?>">
</td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_set"><label>操作</label></th>
  <td class="tab_dd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php 
}

// edit the item of 'qrcode'
else if($_GET["message"]=="qrcode"){
 ?>
 <tr>
  <th class="tab_set"><label>序号</label></th>
  <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_set"><label>类型</label></th>
  <td class="tab_dd">
   <select name="type" onchange="<?php 
   if($_GET["tag"]=="new"){
     ?>
     addItem(this.value,<? echo $id; ?>)
     <?php
   }
   else{
    ?>
    addCell(this.value,<? echo $id; ?>)
    <?php
  }
  ?>">
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
  <th class="tab_set"><label>X</label></th>
  <td class="tab_dd">
    <input type="text"  name="x" value="<?php 
    if($line[$id]["x"]!=""){
     echo $line[$id]["x"] ; 
   }
   else
   {
    echo "0";
  }
  ?>">
</td>
</tr>

<tr>
  <th class="tab_set"><label>Y</label></th>
  <td class="tab_dd">
    <input type="text"  name="y" value="<?php
    if($line[$id]["content"]!=""){
      echo $line[$id]["y"] ;
    }
    else
    {
      echo "0";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>文字内容</label></th>
  <td class="tab_dd">
   <input type="text"  name="content" value="<?php 
   if($_GET["tag"]=="new"){
    echo "new";
  }
  else
  {
    echo $line[$id]["content"];
  }
  ?>">
</td>
</tr>

<tr>
  <th class="tab_setting"><label>纠错级别</label></th>
  <td class="tab_dd">
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
  <th class="tab_setting"><label>图案大小</label></th>
  <td class="tab_dd">
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
  <th class="tab_set"><label>操作</label></th>
  <td class="tab_dd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php 
}

// edit the item of 'qrcode'
else if($_GET["message"]=="barcode"){
 ?>
 <tr>
  <th class="tab_set"><label>序号</label></th>
  <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_set"><label>类型</label></th>
  <td class="tab_dd">
   <select name="type" onchange="<?php 
   if($_GET["tag"]=="new"){
     ?>
     addItem(this.value,<? echo $id; ?>)
     <?php
   }
   else{
    ?>
    addCell(this.value,<? echo $id; ?>)
    <?php
  }
  ?>">
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
  <th class="tab_set"><label>X</label></th>
  <td class="tab_dd">
    <input type="text"  name="x" value="<?php 
    if($line[$id]["x"]!=""){
     echo $line[$id]["x"] ; 
   }
   else
   {
    echo "0";
  }
  ?>">
</td>
</tr>

<tr>
  <th class="tab_set"><label>Y</label></th>
  <td class="tab_dd">
    <input type="text"  name="y" value="<?php
    if($line[$id]["content"]!=""){
      echo $line[$id]["y"] ;
    }
    else
    {
      echo "0";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>值</label></th>
  <td class="tab_dd">
   <input type="text"  name="content" value="<?php 
   if($_GET["tag"]=="new"){
    echo "new";
  }
  else
  {
    echo $line[$id]["content"];
  }
  ?>">
</td>
</tr>

<tr>
  <th class="tab_setting"><label>编码格式</label></th>
  <td class="tab_dd">
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
  <th class="tab_setting"><label>图案大小</label></th>
  <td class="tab_dd">
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
  <th class="tab_set"><label>操作</label></th>
  <td class="tab_dd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php 
}

//edit the item of 'counter'
else if($_GET["message"]=="counter"){
  ?>
  <tr>
    <th class="tab_set"><label>序号</label></th>
    <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
  </tr>

  <tr>
    <th class="tab_set"><label>类型</label></th>
    <td class="tab_dd">
     <select name="type" onchange="<?php 
     if($_GET["tag"]=="new"){
       ?>
       addItem(this.value,<? echo $id; ?>)
       <?php
     }
     else{
      ?>
      addCell(this.value,<? echo $id; ?>)
      <?php
    }
    ?>">
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
  <th class="tab_set"><label>X</label></th>
  <td class="tab_dd">
    <input type="text"  name="x" value="<?php 
    if($line[$id]["x"]!=""){
     echo $line[$id]["x"] ; 
   }
   else
   {
    echo "0";
  }
  
  ?>">
</td>
</tr>

<tr>
  <th class="tab_set"><label>Y</label></th>
  <td class="tab_dd">
    <input type="text"  name="y" value="<?php
    if($line[$id]["content"]!=""){
      echo $line[$id]["y"] ;
    }
    else
    {
      echo "0";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>增减</label></th>
  <td class="tab_dd">
    <select name="updown">
      <?php 
      $fonts = array('up' => '递增', 'down' => '递减');
      foreach($fonts as $key=>$value){
        if($line[$id]["updown"] == $key){
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
  <th class="tab_set"><label>字号</label></th>
  <td class="tab_dd">
    <input type="text" name="fontsize" value="<?php
    if($line[$id]["fontsize"]!=""){
      echo $line[$id]["fontsize"] ;
    }
    else
    {
      echo "20";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>初始值</label></th>
  <td class="tab_dd">
   <input type="text"  name="content" value="<?php 
   if($line[$id]["content"]==""){
    echo "1";
  }
  else{
    if(preg_match("/[^\d., ]/",$line[$id]["content"]))
    {
      echo "1";
    } 
    else 
    {
      echo $line[$id]["content"] ;
    }
  }
  
  ?>">
</td>
</tr>

<tr>
  <th class="tab_set"><label>步长</label></th>
  <td class="tab_dd">
   <input type="text"  name="step" value="<?php 
   if($line[$id]["step"]=="")
   {
    echo "1";
  }
  else{
    echo $line[$id]["step"] ;
  }
  ?>">
</td>
</tr>

<tr>
  <th class="tab_set"><label> 循环</label></th>
  <td class="tab_dd">
   <input type="text"  name="cycle" value="<?php 
   if($line[$id]["cycle"]==""){
    echo "0";
  }
  else{
    echo $line[$id]["cycle"] ;
  }
  ?>">
</td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_set"><label>操作</label></th>
  <td class="tab_dd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

//edit the item of 'date'
else if($_GET["message"]=="date"){
  ?>
  <tr>
    <th class="tab_set"><label>序号</label></th>
    <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
  </tr>

  <tr>
    <th class="tab_set"><label>类型</label></th>
    <td class="tab_dd">
     <select name="type" onchange="<?php 
     if($_GET["tag"]=="new"){
       ?>
       addItem(this.value,<? echo $id; ?>)
       <?php
     }
     else{
      ?>
      addCell(this.value,<? echo $id; ?>)
      <?php
    }
    ?>">
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
  <th class="tab_set"><label>X</label></th>
  <td class="tab_dd">
    <input type="text"  name="x" value="<?php 
    if($line[$id]["x"]!=""){
     echo $line[$id]["x"] ; 
   }
   else
   {
    echo "0";
  }
  ?>">
</td>
</tr>

<tr>
  <th class="tab_set"><label>Y</label></th>
  <td class="tab_dd">
    <input type="text"  name="y" value="<?php
    if($line[$id]["content"]!=""){
      echo $line[$id]["y"] ;
    }
    else
    {
      echo "0";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>格式</label></th>
  <td class="tab_dd">
    <select name="dformate">
      <?php 
      $fonts = array('y/m/d' => 'y/m/d', 'y-m-d' => 'y-m-d','y.m.d'=>'y.m.d','y年m月d日'=>'y年m月d日','m/d/y'=>'m/d/y');
      foreach($fonts as $key=>$value){
        if($line[$id]["dformate"] == $key){
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
  <th class="tab_set"><label>字号</label></th>
  <td class="tab_dd">
    <input type="text" name="fontsize" value="<?php
    if($line[$id]["fontsize"]!=""){
      echo $line[$id]["fontsize"] ;
    }
    else
    {
      echo "20";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>日期</label></th>
  <td class="tab_dd">
   <input type="text"  name="content" value="<?php 
   if($line[$id]["content"]!=""){
    $result=preg_match("/^[0-9]{4}(\-|\/)[0-9]{1,2}(\\1)[0-9]{1,2}$/",$line[$id]["content"]);
    if($result){
                  $year=((int)substr($line[$id]["content"],0,4));//取得年份
                  $month=((int)substr($line[$id]["content"],5,2));//取得月份
                  $day=((int)substr($line[$id]["content"],8,2));//取得几号
                  
                  if($month<10)
                  {
                      $month = "0".$month;
                  }
                  if($day<10)
                  {
                      $day = "0".$day;
                  }
                  if($line[$id]["dformate"]=="y/m/d"){
                    echo $year."/".$month."/".$day;
                  }
                  else if($line[$id]["dformate"]=="y-m-d"){
                    echo $year."-".$month."-".$day;
                  }
                  else if($line[$id]["dformate"]=="y.m.d"){
                    echo $year.".".$month.".".$day;
                  }
                  else if($line[$id]["dformate"]=="y年m月d日"){
                    echo $year."年".$month."月".$day."日";
                  }
                  else{
                   echo $day."/".$month."/".$year;
                   echo $line[$id]["content"];
                 }
               }
               else
               {
                date_default_timezone_set('PRC');
                if($line[$id]["dformate"]=="y-m-d"){
                  echo $showdate=strftime("%Y-%m-%d" );
                }
                else if($line[$id]["dformate"]=="y.m.d"){
                  echo $showdate=strftime("%Y.%m.%d" );
                }
                else if($line[$id]["dformate"]=="y年m月d日"){
                  echo $showdate=strftime("%Y年%m月%d日" );
                }
                else if($line[$id]["dformate"]=="m/d/y"){
                  echo $showdate=strftime("%m/%d/%Y" );
                }
                else{
                  echo $showdate=strftime("%Y/%m/%d" );
                }
              }
            }
            else
            {
              date_default_timezone_set('PRC');
              echo $showdate=strftime("%Y/%m/%d" );
            }

            ?>">
          </td>
        </tr>

        <script type="text/javascript">
          var a='<?php echo  json_encode($line); ?>';
        </script>

        <tr>
          <th class="tab_set"><label>操作</label></th>
          <td class="tab_dd">
           <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
         </td>
       </tr>
       <?php
     }

     //edit the item of 'time'
     else if($_GET["message"]=="time"){
      ?>
      <tr>
        <th class="tab_set"><label>序号</label></th>
        <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
      </tr>

      <tr>
        <th class="tab_set"><label>类型</label></th>
        <td class="tab_dd">
         <select name="type" onchange="<?php 
         if($_GET["tag"]=="new"){
           ?>
           addItem(this.value,<? echo $id; ?>)
           <?php
         }
         else{
          ?>
          addCell(this.value,<? echo $id; ?>)
          <?php
        }
        ?>">
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
      <th class="tab_set"><label>X</label></th>
      <td class="tab_dd">
        <input type="text"  name="x" value="<?php 
        if($line[$id]["x"]!=""){
         echo $line[$id]["x"] ; 
       }
       else
       {
        echo "0";
      }
      ?>">
    </td>
  </tr>

  <tr>
    <th class="tab_set"><label>Y</label></th>
    <td class="tab_dd">
      <input type="text"  name="y" value="<?php
      if($line[$id]["content"]!=""){
        echo $line[$id]["y"] ;
      }
      else
      {
        echo "0";
      }
      ?>">
    </td>
  </tr>

  <tr>
    <th class="tab_set"><label>格式</label></th>
    <td class="tab_dd">
      <select name="tformate">
        <?php 
        $fonts = array('h:i:s' => 'H:I:S', 'h:i:s a/p' => 'H:I:S AM','h时i分s秒'=>'H时I分S秒',);
        foreach($fonts as $key=>$value){
          if($line[$id]["tformate"] == $key){
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
    <th class="tab_set"><label>字号</label></th>
    <td class="tab_dd">
      <input type="text" name="fontsize" value="<?php
      if($line[$id]["fontsize"]!=""){
        echo $line[$id]["fontsize"] ;
      }
      else
      {
        echo "20";
      }
      ?>">
    </td>
  </tr>

  <tr>
    <th class="tab_set"><label>时间</label></th>
    <td class="tab_dd">
     <input type="text"  name="content" value="<?php 
     if($line[$id]["content"]!=""){
      $mytime=preg_match("/^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/",$line[$id]["content"]);
      if($mytime){
        echo $line[$id]["content"] ;
      }
      else
      {
        date_default_timezone_set('PRC');
        echo $showtime=strftime("%H:%M:%S" );
      }
    }
    else
    {
      date_default_timezone_set('PRC');
      echo $showtime=strftime("%H:%M:%S" );
    }

    ?>">
  </td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_set"><label>操作</label></th>
  <td class="tab_dd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}

//edit the item of other types
else
{
  if($_GET["message"]=="new"){
   $num++;
 }

 ?>
 <tr>
  <th class="tab_set"><label>序号</label></th>
  <td class="tab_dd"  ><input type="text" name="index"  readonly="true" value="<?php echo $id+1;?>"></input></td>
</tr>

<tr>
  <th class="tab_set"><label>类型</label></th>
  <td class="tab_dd">
   <select name="type" onchange="<?php 
   if($_GET["message"]=="new"){
     ?>
     addItem(this.value,<? echo $id; ?>)
     <?php
   }
   else{
    ?>
    addCell(this.value,<? echo $id; ?>)
    <?php
  }
  ?>">
  <?php
  $types = array("text"=>"文本","date"=>"日期","time"=>"时间","counter"=>"计数","picture"=>"图片","qrcode"=>"二维码","barcode"=>"条形码");
  foreach($types as $key=>$value){
    if($line[$id]["type"]  == $key){
      echo "<option value='$key' selected='selected'>$value</option>";
    }
    else
    {
      echo "<option value='$key'>$value</option>";
    }
  }
  ?>
</select></td>
</tr>

<tr>
  <th class="tab_set"><label>X</label></th>
  <td class="tab_dd">
    <input type="text"  name="x" value="<?php
    if($_GET["message"]==""){
      echo $line[$id]["x"];
    } 
    else
    {
      echo "0";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>Y</label></th>
  <td class="tab_dd">
    <input type="text"  name="y" value="<?php
    if($_GET["message"]==""){
      echo $line[$id]["y"];
    }
    else{
      echo "0";
    }

    ?>">
  </td>
</tr>

<tr id="tag1">
  <th class="tab_set"><label>字体</label></th>
  <td class="tab_dd">
    <select name="font">
      <?php 
      $fonts = array('simkai' => '楷体', 'wqy-zenhei' => '黑体');
      foreach($fonts as $key=>$value){
        if($line[$id]["font"]  == $key){
          echo "<option value='$key' selected='selected'>$value</option>";
        }
        else
        {
          echo "<option value='$key'>$value</option>";
        }
      }
      ?>
    </select>
  </td>
</tr>

<tr>
  <th class="tab_set"><label>字号</label></th>
  <td class="tab_dd">
    <input type="text" name="fontsize" value="<?php
    if($_GET["message"]==""){
      echo $line[$id]["fontsize"];
    }
    else{
      echo "20";
    }
    ?>">
  </td>
</tr>

<tr>
  <th class="tab_set"><label>值</label></th>
  <td class="tab_dd">
   <input type="text"  name="content" value="<?php 
   if($_GET["message"]==""){
    echo $line[$id]["content"];
  }
  else{
    echo "value".($id+1);
  }
  ?>">
</td>
</tr>

<script type="text/javascript">
  var a='<?php echo  json_encode($line); ?>';
</script>

<tr>
  <th class="tab_set"><label>操作</label></th>
  <td class="tab_dd">
   <input type="button" value="删除" onClick="doDel(a,<?php echo $id; ?>)">
 </td>
</tr>
<?php
}
}
?>
</table>

<!-- </form> -->
</div>

<div  class="move_div cab" style="visibility:<? if($_GET["flag"]=="true"){ echo 'visible';} else{echo 'hidden';}?>" >
  <?php
  if($_GET["message"]!="new")
  {
    for($i=0;$i<$num;$i++){
      ?>
      <input type="button"  class="btn26" style="position:absolute;left:<?php if($line[$i]["x"]>=0) {echo $line[$i]["x"];} else{echo 0;}?>px;top:<?php if($line[$i]["y"]>=0){echo $line[$i]["y"];} else{ echo 0;}?>px" value="<?php if($i<$num) {echo $line[$i]["content"];} else{
        echo "value".($i+1);
      } ?>"  
      onClick=" doshowmessage('<? echo $_SERVER['QUERY_STRING']; ?>','<? echo "message=".$line[$i]["type"] ?>','<? echo "&index=".$line[$i]["index"]; ?>')"/>
      <?php
    }
  }
  else
  {
    for($i=0;$i<$num;$i++){
      ?>
      <input type="button"  class="btn26" style="position:absolute;left:<?php if($line[$i]["x"]>=0) {echo $line[$i]["x"];} else{echo 0;}?>px;top:<?php if($line[$i]["y"]>=0){echo $line[$i]["y"];} else{ echo 0;}?>px" value="<?php if($i!=$num-1) {echo $line[$i]["content"];} else{echo "value".($i+1);} ?>"  
      onClick=" doshowmessage('<? echo $_SERVER['QUERY_STRING']; ?>','<? if($i!=$num-1){echo "message=".$line[$i]["type"];}else {echo "message=new";} ?>','<? echo "&index=".$line[$i]["index"]; ?>')"/>
      <?php
    }
  }
  ?>
</div>


<div  class="bottom_fixed_div  cab">
 <input type="button" class="btn6" value="添加字段"  
 onClick=" doshowmessage('<? echo $_SERVER['QUERY_STRING']; ?>','<? echo "message=new"; ?>','<? echo "&index=".($num+1); ?>')" />
 <label for="">文件名:</label>                                                                    
 <input type="text" id='file' value="<?php if($is_edit) echo $files[0];else echo 'new'?>">         

 <input type="button"  class="btn6" value="提交"  onclick="doJson(a,<?php echo $id; ?>)"   />
</div>     
</div>                   
</body>
</html>
