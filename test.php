
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> - jsFiddle demo by roberkules</title>
  
  <script type='text/javascript' src='http://code.jquery.com/jquery-1.6.js'></script>
  <link rel="stylesheet" type="text/css" href="/css/normalize.css">
  
  
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  
    
      <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
    
  
  <style type='text/css'>
    select {
    width: 100px;
}
select:focus {
    outline: 2px solid orange;
}
  </style>
  


<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
var focusables = $(":focusable");
focusables.eq(0).focus().select();
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
    });
});
});//]]>  

</script>


</head>
<body>
  <select>
    <option value="1a">option 1a</option>
    <option value="1b">option 1b</option>
</select>
<select>
    <option value="2a">option 2a</option>
    <option value="2b">option 2b</option>
</select>
<select>
    <option value="3a">option 3a</option>
    <option value="3b">option 3b</option>
</select>
<select>
    <option value="4a">option 4a</option>
    <option value="4b">option 4b</option>
</select>
<select>
    <option value="5a">option 5a</option>
    <option value="5b">option 5b</option>
</select>
  
</body>


</html>

