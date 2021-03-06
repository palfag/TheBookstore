<?php
    /**
     *  @author Paolo Fagioli
     *
     *  Pagina del carrello:
     *          vengono mostrati tutti gli articoli presenti nel carrello,
     *          le relative quantità e il totale.
     */

    require_once "include/header.php";
    require_once "include/db.inc.php";
    require_once "functions/common_cart.php";

    $items = update_cart($_SESSION['email']);
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/top.html"; ?>
    <link rel="stylesheet" href="../css/cart.css">
    <script src="../javascript/cart.js"></script>
    <script src="../javascript/navbar.js"></script>
    <title>Cart</title>
</head>
<body>

<?php require_once "navbar.php"; ?>

    <div class="row">
        <?php
            if(count($items) == 0){
        ?>
            <div class="warning-empty-cart">
                <h1>Cart is empty</h1>
                <h2>Looks like you have no items in your shopping cart</h2>
                <a href="home.php">Continue Shopping</a>
            </div>
        <?php
            }
            else{
        ?>
        <div id="warning"></div>
        <div id="cart">
            <h1 class="cart-name">Cart</h1>
            <p id="ajax-error" class="failure"></p>
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
                                <button id="checkout-button">Pay now</button>
                                <div id="ajax-response"></div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php } ?>
    </div>
         <?php require_once "include/footer.html"; ?>
</body>
</html>