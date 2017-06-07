<html>
<head>
<meta charset="UTF-8">
<title>
</title>    

<script>        
function mini(txt) 
{
    document.getElementById('show_text').innerHTML = txt;
    document.getElementById('xz').checked = true;
}
</script>
</head>


<body>    
    <input type="checkbox" name="category" value="今日话题" onclick="mini('你好')"/>今日话题
    <input type="checkbox" name="category" value="选中" id="xz"/>选中
    <div id="show_text"> </div>
</body>
</html>