<?php
require_once("./components/header.php");
?>

<head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="test/css/t_style.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class = 'log_tmk'>
            <img src="test/img/tmk-gp-orange-white.png" width="100" height="100">
        </div>
            
        </div>
       
        <div class="menu">
            <img class = "name"
         src = "test/img/company_name.jpg"  width="260" height="90">
            </div>
    </div>
    <div class="Gallery" id="Gal">
        <h1 class = 'gallery_title'>Каталог</h1>
        <h1 class = 'marka'>Марка стали</h1>
        <img class = "bg_image"
         src = "img/fon.png"  width="210" height="40"
         alt = "background for site">
        <h1 class = 'marka2'>Диаметр</h1>
        <img class = "bg_image"
         src = "img/fon.png"  width="210" height="40"
         alt = "background for site">
        <h1 class = 'marka3'>Стенка</h1>
        <img class = "bg_image"
         src = "img/fon.png"  width="210" height="40"
         alt = "background for site">
        <h1 class = 'marka4'>Гост</h1>
        <img class = "bg_image"
         src = "img/fon.png"  width="210" height="20"
         alt = "background for site">
        <div class ='forms'>
      <div class ='form1'>
  <label for="stals"></label>
  <select id="stals" name="stal">
    <option value="stal_1">Значение 1</option>
    <option value="stal_2">Значение 2</option>
    <option value="stal_3">Значение 3</option>
  </select>
          </div>
          
      <div class ='form2'>
          <label for="stals"></label>
  <select id="stals" name="stal">
    <option value="stal_1">Значение 1</option>
    <option value="stal_2">Значение 2</option>
    <option value="stal_3">Значение 3</option>
  </select>
          </div>
        <div class ='form3'>
          <label for="stals"></label>
  <select id="stals" name="stal">
    <option value="stal_1">Значение 1</option>
    <option value="stal_2">Значение 2</option>
    <option value="stal_3">Значение 3</option>
  </select>
        </div>
        <div class ='form4'>
          <label for="stals"></label>
  <select id="stals" name="stal">
    <option value="stal_1">Значение 1</option>
    <option value="stal_2">Значение 2</option>
    <option value="stal_3">Значение 3</option>
  </select>
            </div>
            </div>

  <div class = 'faska'>
      <form>
  <input id="html" type="checkbox">
          <span class="checkmark"></span>
  <label for="html">Фаска</label>
</form>
        </div>
        
    <div class = 'svoystva'>
        <h1 class = 'svoystva_title'>Механические свойства</h1>
        </div>
    <div class = 'button1'>
  <button onclick="SpisokFunc()" class="dropbtn"><img src="test/img/plus.PNG" alt="Плюс" 
          style="vertical-align: middle" width="10"></button>
            <div id="MyDropdown" class="dropdown-content">
        </div>
        
            </div>

     <div class = 'ispytania'>
        <h1 class = 'ispytania'>Испытания</h1>
        </div>
        <div class = 'button1'>
        <form>
  <button><img src="test/img/plus.PNG" alt="Плюс" 
          style="vertical-align: middle" width="10"></button>
</form>
            </div>
    
        
        
        
    </div>
</body>
</html>

<?php
require_once("./components/footer.php");
echo 'as';
?>