function addRow() {
  if (addRow.rows == undefined) {
    addRow.rows = tab.rows.length;
  } else {
    addRow.rows++;
  }
  var newTr = tab.insertRow(-1);
  var fieldName = 'field' + addRow.rows;
  var fieldValue = 'value' + addRow.rows;
  var coordXName = 'x' + addRow.rows;
  var coordYName = 'y' + addRow.rows;
  var coordX = (addRow.rows % 2) * 400;
  var coordY = (addRow.rows / 2) * 40;

  var newTd = newTr.insertCell(-1);
  newTd.innerHTML = '<label>' + addRow.rows + '</label>';
  var newTd = newTr.insertCell(-1);
  //newTd.innerHTML='<input type="text" name='+fieldName+' id='+fieldName+' value='+fieldName+'>';
  newTd.innerHTML = '<select name="type"><option value="text">文本</option><option value="date">日期</option><option value="time">时间</option><option value="counter">计数器</option><option value="picture">图片</option></select>'

  var newTd = newTr.insertCell(-1);
  newTd.innerHTML = '<input type="text" name="x" value="' + coordX + '">';
  var newTd = newTr.insertCell(-1);
  newTd.innerHTML = '<input type="text" name="y" value="' + coordY + '">';

  var newTd = newTr.insertCell(-1);
  newTd.innerHTML = '<select name="font"><option value="simkai">楷体</option><option value="wqy-zenhei">黑体</option>/select>';

  var newTd = newTr.insertCell(-1); 
  newTd.innerHTML = '<input type="text" name="fontsize" value="20">';

  var newTd = newTr.insertCell(-1);
  newTd.innerHTML = '<input type="text" name="content" value="' + fieldValue + '">';

  var newTd = newTr.insertCell(-1);
  newTd.innerHTML = '<input type="button" value="删除字段" name="btn1" id="btn1" onClick="delRow(this)">';
}

function doCalibrate()
{
  window.location.href = "calibrate.php";
}

function addCell(type,index){
  var value = document.getElementById("file").value;
  var  message="&message="+type;
  var file="files[]="+value;
  var id="&index="+(index+1);
  window.location.href = "edit.php?" + file+message+id;
}

function addItem(type,index){
  var value = document.getElementById("file").value;
  var  message="&message="+type;
  var file="files[]="+value;
  var id="&index="+(index+1);
  var tag="&tag=new";
  window.location.href = "edit.php?" + file+message+id+tag;
}

function addNew(type){
  var value = document.getElementById("file").value;
  var  message="&message="+type;
  var file="files[]="+value;
  var edit="&edit=false";
  var flag="&tag="+value;
  window.location.href = "new.php?" + file+message+edit+flag;
}

function delRow(btn) {
  if (tab.rows.length > 2) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }
}

function doXML(del) {
  if (del == 0) {
    var xmlDocument = '<?xml version="1.0" encoding="UTF-8" ?><Production>';
    var httpRequest;
    var table = document.getElementById("tab");
    var rows = table.rows;
    for (var i = 1; i < rows.length; ++i) {
      var cells = rows[i].cells;
      xmlDocument += '<' + cells[1].childNodes[0].value;
      for (var j = 2; j < cells.length - 2; j++) {
        xmlDocument += ' ' + cells[j].childNodes[0].name + '=' + cells[j].childNodes[0].value;
        //alert("name=" +cells[j].childNodes[0].name +" value="+ cells[j].childNodes[0].value);
      }
      xmlDocument += '>' + cells[j].childNodes[0].value + '</' + cells[1].childNodes[0].value + '>';
    }
    //  xmlDocument += fill_xml_helper(defaultRows[i],table.rows[i]);

    xmlDocument += "</Production>";

  }
  //alert(xmlDocument)
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    httpRequest = new XMLHttpRequest();
  } else {// code for IE6, IE5
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (del == 0) {
    httpRequest.open('POST', "/cgi-bin/xml?action=save&file=" + document.getElementById("file").value + '.xml', false);
    httpRequest.send(xmlDocument);
  } else {
    httpRequest.open('GET', "/cgi-bin/xml?action=delete&file=" + document.getElementById("file").value + '.xml', false);
    httpRequest.send();
  }
  window.location.href = "/list.html";

}

////////////////////////////////////////////////////////////////////////////////////////////
//   list action
//////////////////////////////////////////////////////////////////////////
// edit.php use ,only one file
function doJson(jsonarr,id) {
  var line = eval("("+jsonarr+")");
  var value = document.getElementById("file").value;
  if (value == "") {
    alert("必须设置一个");
  }
  var httpRequest;
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    httpRequest = new XMLHttpRequest();
  } else {// code for IE6, IE5
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
  }

  var table = document.getElementById("tab");
  var rows = table.rows;
  var data;
  data = '{"item":[';
  if(id<line.length)
  {
    for(var i=0;i<id;i++)
{
  if(line[i]["type"]=="text"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'font":"'+line[i]["font"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="date"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'dformate":"'+line[i]["dformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="time"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'tformate":"'+line[i]["tformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="picture"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="qrcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'refix":"'+line[i]["refix"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else if(line[i]["type"]=="barcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'codetype":"'+line[i]["codetype"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else{
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'updown":"'+line[i]["updown"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'step":"'+line[i]["step"];
    data+='","'+'cycle":"'+line[i]["cycle"];
    data+='"},';
  }
}

  data+='{"';
  for (var i = 0; i < rows.length-1; ++i) {
      var cells = rows[i].cells;
     if(i<rows.length-2)
    {
       data += cells[1].children[0].name + '":"'+cells[1].children[0].value;
       data+='","';
    }
    else
    {
      data += cells[1].children[0].name + '":"' + cells[1].children[0].value ;
      data+='"';
    }
  }
  if(id==line.length-1){
    data +='}';
  }
  else{
    data += '},';
  }
   

  for(var i=id+1;i<line.length;i++)
  {
  if(line[i]["type"]=="text"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'font":"'+line[i]["font"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="date"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'dformate":"'+line[i]["dformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="time"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'tformate":"'+line[i]["tformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="picture"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="qrcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'refix":"'+line[i]["refix"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else if(line[i]["type"]=="barcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'codetype":"'+line[i]["codetype"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else{
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'updown":"'+line[i]["updown"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'step":"'+line[i]["step"];
    data+='","'+'cycle":"'+line[i]["cycle"];
  }
  if(i==line.length-1)
  {
    data+='"}';
  }
  else
  {
    data+='"},';
  }
  }
  }
else
{
  for(var i=0;i<line.length;i++)
{
  if(line[i]["type"]=="text"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'font":"'+line[i]["font"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="date"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'dformate":"'+line[i]["dformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="time"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'tformate":"'+line[i]["tformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="picture"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='"},';
  }
  else if(line[i]["type"]=="qrcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'refix":"'+line[i]["refix"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else if(line[i]["type"]=="barcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'codetype":"'+line[i]["codetype"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else{
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'updown":"'+line[i]["updown"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'step":"'+line[i]["step"];
    data+='","'+'cycle":"'+line[i]["cycle"];
    data+='"},';
  }
}

  data+='{"';
  for (var i = 0; i < rows.length-1; ++i) {
    var cells = rows[i].cells;
      if(i<rows.length-2)
    {
       data += cells[1].children[0].name + '":"'+cells[1].children[0].value;
       data+='","';
    }
    else
    {
      data += cells[1].children[0].name + '":"' + cells[1].children[0].value ;
      data+='"';
    }
  }
   data += '}';
}
  data += ']}';
  console.log(data);
  httpRequest.open('POST', "admin_do.php?action=save&files[]=" + value, false);
  httpRequest.setRequestHeader("Content-type", "application/json; charset=utf-8");
  httpRequest.send(data);
  document.getElementById("log").innerHTML = httpRequest.responseText;
  var cell=rows[1].cells;
  var  message="&message="+cell[1].children[0].value;
  var file="files[]="+value;
  var index="&index="+(id+1);
  var flag="&flag=true";
  window.location.href = "edit.php?" + file+message+index+flag;
}

function doDel(jsonarr,id)
{
  var line = eval("("+jsonarr+")");
  var value = document.getElementById("file").value;
  if (value == "") {
    alert("必须设置一个");
  }
  var httpRequest;
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    httpRequest = new XMLHttpRequest();
  } else {// code for IE6, IE5
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
  }

  var table = document.getElementById("tab");
  var rows = table.rows;
  var data;
  var del;

for(var j=0;j<line.length;j++){
  if(line[j]["index"]==(id+1)){
    del=j;
  }
}

  data = '{"item":[';
    for(var i=0;i<del;i++)
{
    if(line[i]["type"]=="text"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'font":"'+line[i]["font"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="date"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'dformate":"'+line[i]["dformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="time"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'tformate":"'+line[i]["tformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="picture"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="qrcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'refix":"'+line[i]["refix"];
    data+='","'+'size":"'+line[i]["size"];
  }
  else if(line[i]["type"]=="barcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'codetype":"'+line[i]["codetype"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else {
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'updown":"'+line[i]["updown"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'step":"'+line[i]["step"];
    data+='","'+'cycle":"'+line[i]["cycle"];
  }
  if(i==line.length-2)
  {
    data+='"}';
  }
  else
  {
    data+='"},';
  }
}

  for(var i=del+1;i<line.length;i++)
  {
  if(line[i]["type"]=="text"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'font":"'+line[i]["font"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="date"){
    data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'dformate":"'+line[i]["dformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="time"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'tformate":"'+line[i]["tformate"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="picture"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
  }
  else if(line[i]["type"]=="qrcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'refix":"'+line[i]["refix"];
    data+='","'+'size":"'+line[i]["size"];
  }
  else if(line[i]["type"]=="barcode"){
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'codetype":"'+line[i]["codetype"];
    data+='","'+'size":"'+line[i]["size"];
    data+='"},';
  }
  else{
     data+='{"index":"'+line[i]["index"];
    data+='","'+'type":"'+line[i]["type"];
    data+='","'+'x":"'+line[i]["x"];
    data+='","'+'y":"'+line[i]["y"];
    data+='","'+'updown":"'+line[i]["updown"];
    data+='","'+'fontsize":"'+line[i]["fontsize"];
    data+='","'+'content":"'+line[i]["content"];
    data+='","'+'step":"'+line[i]["step"];
    data+='","'+'cycle":"'+line[i]["cycle"];
  }
  if(i==line.length-1)
  {
    data+='"}';
  }
  else
  {
    data+='"},';
  }
  }
  data += ']}';
  console.log(data);
  httpRequest.open('POST', "admin_do.php?action=save&files[]=" + value, false);
  httpRequest.setRequestHeader("Content-type", "application/json; charset=utf-8");
  httpRequest.send(data);
  document.getElementById("log").innerHTML = httpRequest.responseText;
  if(id==0)
  {
      var  message="&message="+line[id+1]["type"];
  }
  else
  {
    var  message="&message=";
  }
  
  var file="files[]="+value;
  var index="&index=1";
  window.location.href = "edit.php?" + file+message+index;
}


function doJson_new() {
  var value = document.getElementById("file").value;
  if (value == "") {
    alert("必须设置一个");
  }
  var httpRequest;
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    httpRequest = new XMLHttpRequest();
  } else {// code for IE6, IE5
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
  }

  var table = document.getElementById("tab");
  var rows = table.rows;
  var data;
  data = '{"item":[';
  data+='{"';
    for (var i = 0; i < rows.length-1; ++i) {
    var cells = rows[i].cells;
   if(i<rows.length-2)
    {
       data += cells[1].children[0].name + '":"'+cells[1].children[0].value;
       data+='","';
    }
    else
    {
      data += cells[1].children[0].name + '":"' + cells[1].children[0].value ;
      data+='"';
    }
  }
   data += '}';
  data += ']}';
  console.log(data);
  httpRequest.open('POST', "admin_do.php?action=save&files[]=" + value, false);
  httpRequest.setRequestHeader("Content-type", "application/json; charset=utf-8");
  httpRequest.send(data);
  document.getElementById("log").innerHTML = httpRequest.responseText;

 var message="&message="
  var file="files[]="+value;
  var index="&index=1";
  var flag="&flag=true"
  window.location.href = "edit.php?" + file+message+index+flag;
}


function getFiles() {
  var selected = document.getElementsByName("file");
  var value = "";
  for (var i = 0; i < selected.length; i++) {
    if (selected[i].checked == true) {
      value += "files[]=" + selected[i].value + "&";
    }
  }
  return value.substring(0, value.length - 1);
}

function doActionEdit() {
  var value = getFiles();
  var message = "&message=";
  var index="&index=1";
  var flag="&flag=true";
  if (value == "") {
    alert("必须选择一个");
  } else {
    window.location.href = "edit.php?" + value+message+index+flag;
  }

}

function doActionDel() {
  var value = getFiles();
  if (value == "") {
    alert("必须选择一个");
  } else {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      httpRequest = new XMLHttpRequest();
    } else {// code for IE6, IE5
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.open('GET', "admin_do.php?action=delete&" + value, false);
    httpRequest.send();
    window.location.href = "list.php";
  }
}

function doActionPreview() {
  var value = getFiles();
  if (value == "") {
    alert("必须选择一个");
  } else {
    window.location.href = 'preview.php?' + value;
  }
}

function doActionStop() {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      httpRequest = new XMLHttpRequest();
    } else {// code for IE6, IE5
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.open('GET', "admin_do.php?action=stop", false);
    httpRequest.send();
    document.getElementById("log").innerHTML = httpRequest.responseText;
}

function doActionPrint(value) {
  if(value == null)
    value = getFiles();
  if (value == "") {
    alert("必须选择一个");
  } else {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      httpRequest = new XMLHttpRequest();
    } else {// code for IE6, IE5
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    httpRequest.open('GET', "admin_do.php?action=print&" + value, false);
    httpRequest.send();
    document.getElementById("log").innerHTML = httpRequest.responseText;
  }
}

/*create random number*/
function GetRandomNum(Min,Max)
{   
var Range = Max - Min;   
var Rand = Math.random();   
return(Min + Math.round(Rand * Range));   
}   

window.addEventListener("load", function() { 
var num=0; 
var focusables = $(":focusable");
//focusables.eq(0).focus().select();
focusables.each(function () {
    $(this).keydown(function (e) {
        if (e.which == '37') { // left-arrow
            e.preventDefault();
            var current = focusables.index(this),
                next = focusables.eq(current - 1).length ? focusables.eq(current - 1) : focusables.eq(0);
            this.blur();
            setTimeout(function() { next.focus().select(); }, 50);
        }
        if (e.which == '39') { // right-arrow
            e.preventDefault();
            var current = focusables.index(this),
                next = focusables.eq(current + 1).length ? focusables.eq(current + 1) : focusables.eq(0);
            this.blur();
            setTimeout(function() { next.focus().select(); }, 50);
        }
        
        if(e.which=="189"){
          num++;
          e.preventDefault();

           if(num%3==2){
            var index = $(".cab").next();
            if(index.length==0){
              index=$(".container").children().next();
            }
            setTimeout(function() { index.find('input').get(0).focus(); }, 50);
          }
          else if(num%3==1){
            var index = $(".cab");
            next = focusables.eq(0);
            setTimeout(function() { next.focus(); }, 50);
          }
          else if(num%3==0) {
            var index = $(".cab").next();
            tab=index.next();
            if(tab.length==0){
              tab=$(".container").children().next().next();
            }
            setTimeout(function() { tab.find('input').get(0).focus(); }, 50);
          }
          this.blur();
          
          //  alert(index);
          // //index.find('input').get(0).focus();
          // index = index.next();
          // if(index.length == 0) {
          //   index = $(".container").children().next();
          
       // }
      }   
    });
});
   $('input').keyup(function(e){
if(e.which==40)
   $(this).closest('tr').next().find('td:eq('+$(this).closest('td').index()+')').find('input').focus();
  else if(e.which==38)
   $(this).closest('tr').prev().find('td:eq('+$(this).closest('td').index()+')').find('input').focus();
 });

   // $("div").keydown(function(e){
   //  if(e.which =='113'){
   //    alert("press one time");
   //        var index = $("#tab").next();
   //        index.find('input').get(0).focus();
   //        index = index.next();
   //        if(index.length == 0) {
   //          index = $(".starter-template").children().next();
   //        }
   //      }
   // });
 });

function doshowmessage(value,message,index)
{
   var flag="&flag=false"
    window.location.href = "edit.php?"+value+"&"+message+"&"+index+flag;
}

function showmessage(value)
{
   switch(value)
   {
    case "EAN":
      alert("该条形码格式只能包含8位数字");
      break;

    case "UPC":
      alert("该条形码格式只能包含12位数字");
      break;

    case "S25":
      alert("该条形码只能表示数字,长度可变");
      break;

    case "I25":
      alert("该条形码只能表示数字,长度可变");
      break;

    case "Codabar":
      alert("该条形码可表示数字,字符$/+/-,只能用作始/终a,b,c d四个字符,长度可变");
      break;

    case "C39":
      alert("该条形码长度可变,字符任意");
      break;

    case "C128":
      alert("该条形码有A、B、C三个版本,具体填写要求请自查");
      break;

    default:
      alert("错误");
      break;
   }
}


