<!DOCTYPE html>
<html>

<head>
    <title>PHP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <form action="index.php" method="post">
        <label> quantity: </label>
        <input type="text" name="quantity" />
        <input type="submit" value="submit" />
    </form>
</body>

</html>
<?php
$itmem = "pizza";
$price = 4.55;
$quantity = $_POST["quantity"];
$total = $price * $quantity;
echo "you have ordered {$quantity} pizzas <br>";
echo "it will cost you {$total}";
?>
