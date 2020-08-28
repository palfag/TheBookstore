<?php
    require_once "top.php";
    require_once "db.inc.php";
    require_once "navbar.php";
    require_once "update_cart.php";

    if(!isset($_SESSION['email'])){
        header("Location: index.php");
        die;
    }
    $items = update_cart($_SESSION['email']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/cart.js"></script>
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
    <link rel="stylesheet" href="../css/footer.css">
    <title>Cart</title>
</head>
<body>

    <div class="row">
        <?php
            if(count($items) == 0){
                ?>
            <div class="warning-empty-cart">
                <h1>Cart is empty</h1>
                <h2>Looks like you have no items in your shopping cart</h2>
                <button><a href="home.php">Continue Shopping</a></button>
            </div>

            <?php
            }
            else{
                ?>
        <div id="warning"></div>
        <div id="cart">
            <h1 class="cart-name">Cart</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th><button class="remove-all-button">Empty cart</button></th>
                    </tr>
                </thead>
                <tbody id="books">
                    <?php
                        $total = 0;
                        for($i = 0; $i < count($items); $i++){
                            $item = $items[$i];
                            $total += (double)$item['subtotal'];
                    ?>
                            <tr id="<?= $item['book_id'] ?>" class="book">

                                <td>
                                    <div>
                                        <h1 class="title">
                                            <a href='book.php?id_book=<?= $item["book_id"] ?>'>
                                                <img class="cover" src="<?= $item['cover']?>" alt="book cover"><?= $item['title']?>
                                            </a>
                                        </h1>
                                        <h2 class="author"><span><?= $item['author']?></span></h2>
                                    </div>
                                </td>

                                <td class="price-column">
                                    <p class="price"><?= $item['price']?>€</p>
                                </td>

                                <td class="quantity-column">
                                    <p>
                                        <button class="minus-button"> - </button>
                                        <span class="quantity"><?= $item['quantity']?></span>
                                        <button class="plus-button"> + </button>
                                    </p>
                                </td>

                                <td class="subtotal-column">
                                    <p><?= $item['subtotal']?></p>
                                </td>

                                <td class="remove-column">
                                    <p>
                                        <button class="remove-button">remove</button>
                                    </p>
                                </td>
                            </tr>
                <?php
                        }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">
                            <p>Tot: €</p>
                        </td>
                        <td>
                            <p id="total"><?=$total?></p>
                        </td>
                        <td>
                            <div>
                                <button id="checkout-button"> Pay</button>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
        <?php } ?>
         <?php require_once "footer.php"; ?>
</body>
</html>