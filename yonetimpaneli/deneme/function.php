<html>
<head>
  <script>
  function bitir(){
    console.log("yonlendirme");
  window.location="http://yonetim.kuark.digital/deneme/bitir.php";
  }
  </script>
</head>

<body>
<form name="form" action="function.php" method="post">
    <select  name="which_one">
      <option >seçim yapınız</option>
      <option value="text_input">text_input</option>
      <option value="dropdown">dropdown</option>
      <option value="radio">radio</option>
    </select>
    <input type="submit" value="ekle">
</form>
<input type="submit" onclick="bitir();" value="eklemeyi bitir"><br/>
</body>
<?php $cc=$_POST["which_one"];
  //  $counter_row=0;

session_start();
//$_SESSION["counter"] = $counter_row;
$address = $_SESSION["address"];

 if ($cc=="text_input"){
     header("Location: http://yonetim.kuark.digital/deneme/text_input.php");
     //$_SESSION["adress_input"] = $address;
    }
        // read($cc,$address);}

elseif ($cc=="dropdown"){
    header("Location: http://yonetim.kuark.digital/deneme/dropdown.php");
    //$_SESSION["address"] = $address;
  }
    //read($cc,$address); }

elseif ($cc=="radio"){
    header("Location: http://yonetim.kuark.digital/deneme/radio.php");
    //$_SESSION["address"] = $address;
  //read($cc,$address); }
  }
?>
</html>
