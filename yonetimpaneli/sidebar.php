<div class="page-sidebar-wrapper">

<div class="page-sidebar navbar-collapse collapse">
<!-- BEGIN SIDEBAR MENU -->
<?php

$menuHtml='';
function MenuYarat($parentId){
    global $menuHtml;
    global $db;
    global $url;
    $result = $db->get_results("SELECT * FROM yetki_sayfalar WHERE ust_id='".$parentId."' AND goster=1 ORDER BY sira ASC");
    $rowCount = $db->num_rows;
    if ($rowCount == 0) return;
    if ($parentId == 0){
        $menuHtml.='<ul class="page-sidebar-menu solmenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">';
    }else{
      $menuHtml.='<ul class="sub-menu">';
    }
    $yetkisayfalari = $db->get_row("SELECT erisilensayfalar FROM yetkiler WHERE yetki='".$_SESSION['yetki']."' ");

    $yetkisayfaarray = json_decode($yetkisayfalari->erisilensayfalar);

    foreach ($result as $key => $row) {
        $yetkivarmibalalim = in_array($row->id,$yetkisayfaarray);
        if($yetkivarmibalalim){
        if($url == $row->sayfalar){$activeclass = "active";}else{$activeclass = "";}
        $varmi = $db->get_results("SELECT * FROM yetki_sayfalar WHERE ust_id='".$row->id."' AND goster=1 ORDER BY sira ASC");
        $varmicount = $db->num_rows;
        if ($varmicount != 0){$ok='<span class="arrow "></span>';}else{$ok='';}
        $menuHtml.='<li class="'.$activeclass.'"><a href="'.$row->sayfalar.'"><i class="'.$row->icon.'"></i><span class="title">'.$row->menuadi.'</span>'.$ok.'</a>';
        MenuYarat($row->id);
        $menuHtml.='</li>';
      }
    }
$menuHtml.='</ul>';
return $menuHtml;
}
echo MenuYarat(0);

?>
<!-- END SIDEBAR MENU -->
</div>
</div>
