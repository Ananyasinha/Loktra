<?php
session_start();
$conn_cart=new MySQLi("localhost","root","","shopping_cart");

if (isset($_POST['remove_to_cart'])){

   $id = $_POST['remove_to_cart'];

   $removed = "UPDATE items SET added='0' WHERE id='$id'";
   $r= $conn_cart->query($removed);
  
   $remove_quantity = "UPDATE items SET quantity='0' WHERE id='$id'";
   $r= $conn_cart->query($remove_quantity);

   header("location:viewcart.php");

}

if (isset($_POST['change'])){
    $id = $_POST['change'];
    $quantity = $_POST['quantity'];

    $change = "UPDATE items SET quantity='$quantity' WHERE id='$id'";
    $r= $conn_cart->query($change);  

   header("location:viewcart.php");
}


if (isset($_POST['clear_cart'])){

   $removed = "UPDATE items SET added='0' WHERE added='1'";
   $r= $conn_cart->query($removed);
  
   $remove_quantity = "UPDATE items SET quantity='0' WHERE quantity!='0'";
   $r= $conn_cart->query($remove_quantity);

   header("location:viewcart.php");

}



if (isset($_POST['continue_adding'])){
  header("location:index.php");
}


?>



<!DOCTYPE html>
<html>
<head>
	<title>SHOPPING CART | LOKTRA</title>
<link rel="icon" href="logo.jpg" type="image/png" sizes="16x16">
<link rel="stylesheet" type="text/css" href="arvo.css">

<script src="jquery.js"></script>
<script src="jquery_new.js"></script>

<script type="text/javascript">
  
function numbersonly(myfield, e, dec){
  var key;
  var keychar;

  if (window.event)
     key = window.event.keyCode;
  else if (e)
     key = e.which;
  else
     return true;
  keychar = String.fromCharCode(key);

  // control keys
  if ((key==null) || (key==0) || (key==8) || 
      (key==9) || (key==13) || (key==27) )
     return true;

  // numbers
  else if ((("0123456789").indexOf(keychar) > -1))
     return true;

  // decimal point jump
  else if (dec && (keychar == "."))
     {
     myfield.form.elements[dec].focus();
     return false;
     }
  else
     return false;
}

</script>

<style type="text/css">
body{background-color:#f0f0f0}
a{text-decoration:none;}
h9{font-size:22px;font-family:'Arvo', serif;font-weight:600;color:#000;}
h10{font-size:23px;font-family:'calibri', serif;font-weight:100;color:#000;}
h11{font-size:16px;font-family:'Arvo', serif;font-weight:600;color:white;}
h12{font-size:16px;font-family:'Arvo', serif;font-weight:600;color:#000;}
h13{font-size:20px;font-family:'calibri', serif;font-weight:100;color:#000;}
h14{font-size:22px;font-family:'calibri', serif;font-weight:600;color:#a0a0a0;}
h15{font-size:16px;font-family:'calibri', serif;font-weight:100;color:blue;}
h16{font-size:26px;font-family:'calibri', serif;font-weight:600;color:#0099ff;}
h17{font-size:26px;font-family:'calibri', serif;font-weight:100;color:white;}
h18{font-size:26px;font-family:'calibri', serif;font-weight:100;color:white;}


#continue_adding{position:absolute;left:275px;width:220px;top:175px;height:40px;background-color:#0099ff;border:none;box-shadow:0px 0px 1px 1px #a0a0a0;cursor:pointer}
#empty_cart_writen{position:absolute;left:355px;width:200px;top:45px;height:70px;}
#cart_icon{position:absolute;left:256px;width:70px;top:30px;height:70px;}
#complete_area_of_empty_cart{position:absolute;left:100px;width:770px;top:160px;height:400px;background-color:white;box-shadow:0px 0px 1px 1px #a0a0a0}


#change_quantity{position:absolute;left:296px;width:70px;height:30px;top:165px;border:none;background-color:transparent;cursor:pointer;}
#quantity_writen{position:absolute;left:219px;width:50px;height:35px;top:130px;}
#quantity_box{position:absolute;left:7px;top:2px;width:38px;height:25px;border:none;font-family:calibri;font-size:18px;color:#a0a0a0;font-weight:100;outline:none}
#quantity_area{position:absolute;left:310px;width:45px;height:35px;top:127px;box-shadow:0px 0px 0px 1px #e0e0e0;}
#add_cart_fade{position:absolute;left:520px;width:150px;top:130px;height:40px;background-color:#e0e0e0;border:none;box-shadow:0px 0px 1px 1px #a0a0a0;cursor:pointer;}
#add_cart_blink{position:absolute;left:520px;width:150px;top:130px;height:40px;background-color:#0099ff;border:none;box-shadow:0px 0px 1px 1px #a0a0a0;cursor:pointer;}

#shopping_cart_writen{position:absolute;left:100px;top:20px;}
#shopping_cart_top_bar{z-index:100;position:fixed;width:1365px;height:70px;top:0px;left:0px;background-color:white;box-shadow:0px 0px 1px 1px #a0a0a0}
#cart_logo{position:absolute;left:16px;width:70px;top:0px;height:70px;}


#complete_area_of_items_show{position:absolute;left:100px;width:770px;top:100px;background-color:white;box-shadow:0px 0px 1px 1px #a0a0a0}



#clear_cart{position:absolute;left:1200px;width:140px;height:40px;top:15px;background-color:#0099ff;border:none;box-shadow:0px 0px 1px 1px #a0a0a0;cursor:pointer}

</style>
</head>

<body>
	<div id='shopping_cart_top_bar'> 
	 <a href='index.php'>
     <div id='cart_logo'>
      <img src='cart.png' width='100%' height='100%'/>
     </div>
   </a>  
   <a href='index.php'> 
    <div id='shopping_cart_writen'>
	   <h9>SHOPPING CART</h9>  	
	  </div>
   </a> 
  <form name='clear_cart' action='viewcart.php' method='POST'>
  <button id='clear_cart' name='clear_cart'><h18>CLEAR CART</h18></button>
  </form> 
	</div>

    


<?php
$result_now = $conn_cart->query("SELECT * FROM items WHERE added='1'");
$total=$result_now->num_rows;
$height_final = (($total*230)+70);
$height_new = "$height_final"."px"; 

if($total!='0'){  

    echo "<div id='complete_area_of_items_show' style='height:$height_new'>";
    ?>


    <?php
    $top_final=50;
    $selecting_items = $conn_cart->query("SELECT * FROM items WHERE added='1'");
    while($extract = $selecting_items->fetch_assoc()){
        $item_name = $extract['item_name'];
        $id = $extract['id'];
        $item_image = $extract['item_image'];
        
          $top_temp = $top_final;    
          $top_new = "$top_temp"."px";
        
        echo "<div id='col-md-item-$id' style='overflow:hidden;position:absolute;left:22px;width:720px;
            top:$top_new;height:200px;background-color:white;text-overflow:ellipsis;white-space:nowrap;box-shadow:0px 0px 1px 1px #dedede'>
          <div id='item_cover_$id' style='position:absolute;left:15px;width:150px;height:170px;top:15px;cursor:pointer'><img src='images/$item_image' width='150px' height='170px'/>
          </div>
          <div id='item_name_writen_$id' style='overflow:hidden;position:absolute;left:220px;width:350px;height:30px;top:30px;
          cursor:pointer;text-overflow:ellipsis;white-space:nowrap;'><h10>$item_name.</h10>
          </div>";

          $query_items= "SELECT * FROM items WHERE id='$id'";
          $newresult_item = $conn_cart->query($query_items);
          $row_item = $newresult_item->fetch_assoc();
          $added_status = $row_item['added'];  
          $quantity = $row_item['quantity'];

           
          echo "<form name='view_cart' action='viewcart.php' method='POST'>  
                <div id='quantity_writen'><h13>Quantity :</h13></div>
                <div id='quantity_area'>
                  <input id='quantity_box' type='text' name='quantity' placeholder='$quantity' maxlength='3' onKeyPress='return numbersonly(this,event)' autocomplete='off' required />
                </div>       
            <button id='change_quantity' name='change' value='$id'><h15>CHANGE</h15></button>
            </form>
            <form name='remove_item' action='viewcart.php' method='POST'>
            <button id='add_cart_fade' name='remove_to_cart' value='$id'><h12>REMOVE</h12></button>
              </form>";
        
                
    echo "</div>";
        

    $top_final = $top_final + 230;

    }
    echo "</div>";

}
else{

echo "<div id='complete_area_of_empty_cart'>";
  echo "<div id='cart_icon'>";
   echo "<img src='cart.png' width='100%' height='100%'/>";
  echo "</div>";
  echo "<div id='empty_cart_writen'>";
    echo "<h16>CART EMPTY</h16>";
  echo "</div>";

 echo "<form name='add' action='viewcart.php' method='POST'>"; 
  echo "<button id='continue_adding' name='continue_adding'><h17>CONTINUE ADDING</h17></button>";
 echo "</form>";

echo "</div>";

}


?>

  

</body>

</html>


