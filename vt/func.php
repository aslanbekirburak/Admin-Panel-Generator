<?php



    $ipAdresi = $_SERVER['REMOTE_ADDR'];
    $sadeTarih = date("Y-m-d");
    $sadeSaat = date("H:i:s");
    $simdikiZaman = date("Y-m-d H:i:s");

    // Fonksiyonlar
    function g($par){
        return strip_tags(trim(addslashes($_GET[$par])));
    }

    function p($par, $st = false){
        if ($st){
            return htmlspecialchars(addslashes(trim($_POST[$par])));
        }else {
            return addslashes(trim($_POST[$par]));
        }
    }

    function go($par, $time = 0){
        if ($time == 0){
            header("Location: {$par}");
        }else {
            header("Refresh: {$time}; url={$par}");
        }
    }

    function duzenPost($giris){
        $giris = htmlspecialchars($giris);
        $giris = (get_magic_quotes_gpc()?$giris:addslashes($giris));
        return $giris;
    }

    function sef_link($baslik){
        $bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
        $yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
        $perma = strtolower(str_replace($bul, $yap, $baslik));
        $perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
        $perma = trim(preg_replace('/\s+/',' ', $perma));
        $perma = str_replace(' ', '-', $perma);
        return $perma;
    }


    function tarih($par)
    {
        $explode = explode(" ", $par);
        $explode2 = explode("-", $explode[0]);
        $zaman = substr($explode[1], 0, 5);

        if ($explode2[1] == "1") $ay = "Ocak";
        elseif ($explode2[1] == "2") $ay = "Şubat";
        elseif ($explode2[1] == "3") $ay = "Mart";
        elseif ($explode2[1] == "4") $ay = "Nisan";
        elseif ($explode2[1] == "5") $ay = "Mayıs";
        elseif ($explode2[1] == "6") $ay = "Haziran";
        elseif ($explode2[1] == "7") $ay = "Temmuz";
        elseif ($explode2[1] == "8") $ay = "Ağustos";
        elseif ($explode2[1] == "9") $ay = "Eylül";
        elseif ($explode2[1] == "10") $ay = "Ekim";
        elseif ($explode2[1] == "11") $ay = "Kasım";
        elseif ($explode2[1] == "12") $ay = "Aralık";

        return $explode2[2]." ".$ay." ".$explode2[0].", ".$zaman;

    }

    function move_imagedata_file($data,$name,$w,$h){
        $base64img = str_replace('data:image/jpeg;base64,', '', $data);
        $data = base64_decode($base64img);
        file_put_contents($name, $data);
        include_once ("resize_class.php");
        $resizeObj = new resize($name);
        $resizeObj -> resizeImage($w, $h, 0);
        $resizeObj -> saveImage($name, 100);
    }
    ?>
