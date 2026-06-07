<?php
session_start();

$products = [
["id"=>1,"name"=>"Laptop","price"=>35000,"icon"=>"💻"],
["id"=>2,"name"=>"Akıllı Telefon","price"=>18000,"icon"=>"📱"],
["id"=>3,"name"=>"Kablosuz Kulaklık","price"=>2500,"icon"=>"🎧"],
["id"=>4,"name"=>"Akıllı Saat","price"=>4000,"icon"=>"⌚"]
];

if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=[];
}

if(isset($_GET['add'])){
    $id=$_GET['add'];

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]++;
    }else{
        $_SESSION['cart'][$id]=1;
    }

    header("Location:index.php");
    exit;
}

if(isset($_GET['minus'])){
    $id=$_GET['minus'];

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]--;

        if($_SESSION['cart'][$id] <= 0){
            unset($_SESSION['cart'][$id]);
        }
    }

    header("Location:index.php");
    exit;
}

if(isset($_GET['remove'])){
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location:index.php");
    exit;
}

if(isset($_GET['clear'])){
    $_SESSION['cart']=[];
    header("Location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>abdussamed</title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
background:#f4f4f4;
}

header{
background:#111827;
color:white;
padding:20px;
text-align:center;
}

.search{
padding:20px;
text-align:center;
}

.search input{
width:80%;
padding:12px;
border-radius:8px;
border:1px solid #ccc;
}

.products{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
padding:20px;
}

.card{
background:white;
padding:20px;
border-radius:10px;
text-align:center;
box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.icon{
font-size:60px;
}

.price{
font-size:22px;
font-weight:bold;
color:#2563eb;
margin:10px 0;
}

.btn{
display:inline-block;
padding:10px 15px;
background:#2563eb;
color:white;
text-decoration:none;
border-radius:6px;
margin-top:10px;
}

.btn:hover{
background:#1d4ed8;
}

.cart{
background:white;
margin:20px;
padding:20px;
border-radius:10px;
}

.action{
padding:5px 10px;
background:#2563eb;
color:white;
text-decoration:none;
border-radius:4px;
margin:0 3px;
}

.delete{
background:#dc2626;
}

.clear{
background:#dc2626;
padding:10px 15px;
display:inline-block;
margin-top:15px;
color:white;
text-decoration:none;
border-radius:6px;
}

footer{
background:#111827;
color:white;
text-align:center;
padding:15px;
margin-top:20px;
}
</style>

</head>
<body>

<header>
<h1> Mini Shop</h1>
<p>Basit E-Ticaret Sistemi</p>
</header>

<div class="search">
<input type="text" id="search" placeholder="Ürün ara...">
</div>

<div class="products">

<?php foreach($products as $p): ?>

<div class="card product">

<div class="icon">
<?php echo $p['icon']; ?>
</div>

<h2><?php echo $p['name']; ?></h2>

<div class="price">
₺<?php echo number_format($p['price'],0,",","."); ?>
</div>

<a class="btn" href="?add=<?php echo $p['id']; ?>">
Sepete Ekle
</a>

</div>

<?php endforeach; ?>

</div>

<div class="cart">

<h2>Sepetim</h2>
<hr><br>

<?php

$total=0;

if(count($_SESSION['cart'])>0){

foreach($_SESSION['cart'] as $id=>$qty){

foreach($products as $p){

if($p['id']==$id){

$sub=$p['price']*$qty;
$total+=$sub;

echo "
<p>
<b>{$p['name']}</b>
| Adet: {$qty}
| ₺".number_format($sub,0,",",".")."

<a class='action' href='?add={$id}'>+</a>

<a class='action' href='?minus={$id}'>-</a>

<a class='action delete' href='?remove={$id}'>❌</a>

</p><br>
";

}
}

}

echo "<h3>Toplam: ₺".number_format($total,0,",",".")."</h3>";

echo "<br><a class='clear' href='?clear=1'>Sepeti Temizle</a>";

}else{

echo "Sepetiniz boş.";

}

?>

</div>

<footer>
E-ticaret yapısı 
</footer>

<script>
let search=document.getElementById("search");

search.addEventListener("keyup",function(){

let value=this.value.toLowerCase();

document.querySelectorAll(".product").forEach(function(item){

if(item.innerText.toLowerCase().includes(value)){
item.style.display="block";
}else{
item.style.display="none";
}

});

});
</script>

</body>
</html>