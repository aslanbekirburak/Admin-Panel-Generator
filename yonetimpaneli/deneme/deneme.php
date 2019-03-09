<?php
$dbname = "admin_yonetim";
$server = "localhost";
$dbusername = "admin_yonetim";
$dbpass = "Asdasd123";
$conn = new mysqli($server, $dbusername, $dbpass, $dbname);?>


<body>

    <form name="form" action="denemehelper.php" method="post">

      <?php

      $sql = "SELECT menuadi FROM yetki_sayfalar";
      $result=$conn->query($sql);
      ?>
       festival:<br/><select name="festival"><?php
     if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
           echo "<option>".$row['menuadi']."</option>";
       }
     }
     ?></select>
     
     <?php

     $sql1 = "SELECT icon FROM yetki_sayfa_icon";
     $result1=$conn->query($sql1);
     ?>
      icon:<br/><select name="icon"><?php
    if($result1->num_rows > 0){
      while($row = $result1->fetch_assoc()){
          echo "<option>".$row['icon']."</option>";
      }
    }
    ?></select><br/>

    <b>Menu adı:</b><br />
    <input type="text" name="menu" size="24"><br /><br />

     <b>php adresi:</b><br />
     <input type="text" name="adress" size="24"><br /><br />

     <b>Sıra No:</b><br />
     <input type="text" name="sira" size="24"><br /><br />

     <b>durum:</b><br/>
     <input type="radio" name"durum" value="1">geçerli
     <input type="radio" name"durum" value="0">geçersiz<br/> <br/>


     <input type="submit" value="ekle"><br/>

  </form>

</body>
