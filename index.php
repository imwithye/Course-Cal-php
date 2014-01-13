<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="assets/css/style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="assets/js/script.js"></script>
<title>Course Cal</title>
</head>

<body>
  <div style="height:40px"></div>
  <div class="line" align="center">
  <div>
  <img src="assets/img/divider_up.png" width="800"/>
  </div>
  </div>
  
  <div id="main" align="center">
  <div>
    <h1>Course Cal.</h1>
    <p style="font-size:18px; color:#666">Simply paste 
    your printable page url into the box <br />below and generate personal iCal file.</p>
    
    <form method="POST" action="/perform.php">
        <input type="text" id="url" name="url" placeholder=" Printable page url"; autocomplete="off" style="border:1px solid #006699;"/>
        <input type="hidden" name="json" id="json" value="">
        <br />
        <br />
        <input type="submit" id="submit" value="Generate"/>
    </form>
    <br />
  </div>
  </div>
  
  <div class="line" align="center">
  <div>
  <img src="assets/img/divider_down.png" width="800"/>
  </div>
  </div>
  
  <div id="footer" align="center">
    <p style="font-size:13px; color:#666">Copyright <a href="http://ciel.im" style="text-decoration:none; color:#006699">Ciel</a>, 2013</p>
  </div>
</body>
</html>
