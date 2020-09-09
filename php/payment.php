<?php
    require_once "include/header.php";
    require_once "include/db.inc.php";

    if(!isset($_SESSION['email'])){
        header("Location: index.php");
        die;
    }
    $email = $_SESSION['email'];
    $card = retrieve_card_details($email);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/payments.js"></script>
    <link rel="stylesheet" href="../css/payment.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="../javascript/navbar.js"></script>
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Document</title>
</head>
<body>

<?php require_once "navbar.php"; ?>

    <h1 id="payment-title">Payments</h1>

    <?php
    if($card == null){ // caso in cui l'utente non ha ancora registrato una carta sul suo profilo
    ?>
        <div class="row">
            <div class="column left">
                <img id="card-img" src="../images/cards/default.png" alt="card">

            </div>
            <div class="column right">
                <h2>Add a card</h2>
                <div id="card-detail-div" class="invisible">
                    <form id="add-card-form" method="POST">
                        <div class="card">
                            <label for="card-holder">Card holder:</label>
                            <input id="card-holder" type="text" name="card-holder" pattern="[a-zA-Z]{2,15}\s[a-zA-Z]{2,15}" placeholder="Card holder" required>
                        </div>
                        <div class="card">
                            <label for="card-holder">Card number:</label>
                            <input id="card-number" type="text" name="card-number" pattern="[0-9]{13,16}" maxlength="16" placeholder="••••••••••••••••" required>
                        </div>
                        <div class="card-item">
                            <label for="expiry-date">Expiry date:</label>
                            <input id="expiry-date" type="text" name="expiry-date" pattern="(0[1-9]|10|11|12)/[2-9]{1}[0-9]{1}$" maxlength="5" placeholder="••/••" required>
                        </div>
                        <div class="card-item">
                            <label for="cvc">CVC:</label>
                            <input id="cvc" type="text" name="cvc" pattern="[0-9]{3}" maxlength="3" placeholder="•••" required>
                        </div>
                        <div>
                            <select name="type" id="type">
                                <option value="american-express">American Express</option>
                                <option value="master-card">Mastercard</option>
                                <option value="visa">Visa</option>
                                <option value="default" selected="selected">Other</option>
                            </select>
                        </div>
                        <div>
                            <input class="submit" id="submit" type="submit" name="submit" value="add card">
                        </div>
                    </form>
                    <div id="ajax-response"></div>
                </div>
            </div>
        </div>
    <?php
    }
    else{
        $card_number_decoded = base64_decode($card['card_number']);
        $cvc_decoded = base64_decode($card['cvv']);

        ?>
        <div class="row">
            <div class="column left">
                <img id="card-img" src="../images/cards/<?= $card['card_type']?>.png" alt="card">

            </div>
            <div class="column right">
                <h2>Card details</h2>

                <div id="card-detail-div" class="invisible">
                    <form id="update-card-form" method="POST">
                        <div class="card">
                            <label for="card-holder">Card holder:</label>
                            <input id="card-holder" type="text" name="card-holder" pattern="[a-zA-Z]{2,15}\s[a-zA-Z]{2,15}" placeholder="Card holder" value="<?= $card['card_holder'] ?>" required>
                        </div>
                        <div class="card">
                            <label for="card-holder">Card number:</label>
                            <input id="card-number" type="text" name="card-number" pattern="[0-9]{13,16}" maxlength="16" placeholder="••••••••••••••••" value="<?= $card_number_decoded ?>" required>
                        </div>
                        <div class="card-item">
                            <label for="expiry-date">Expiry date:</label>
                            <input id="expiry-date" type="text" name="expiry-date" pattern="(0[1-9]|10|11|12)/[2-9]{1}[0-9]{1}$" maxlength="5" placeholder="••/••" value="<?= $card['expiry_date'] ?>" required>
                        </div>
                        <div class="card-item">
                            <label for="cvc">CVC:</label>
                            <input id="cvc" type="text" name="cvc" pattern="[0-9]{3}" maxlength="3" placeholder="•••" value="<?= $cvc_decoded ?>" required>
                        </div>
                        <div>
                            <label for="type">type</label>
                            <select name="type" id="type">
                                <?php
                                if(strcmp($card['card_type'], 'american-express') == 0){?>
                                    <option value="american-express" selected="selected">American Express</option>
                                    <option value="master-card">Mastercard</option>
                                    <option value="visa">Visa</option>
                                    <option value="default">Other</option>
                                    <?php
                                }
                                else if(strcmp($card['card_type'], 'master-card') == 0){?>
                                    <option value="american-express">American Express</option>
                                    <option value="master-card" selected="selected">Mastercard</option>
                                    <option value="visa">Visa</option>
                                    <option value="default">Other</option>
                                    <?php
                                }
                                else if(strcmp($card['card_type'], 'visa') == 0){?>
                                    <option value="american-express">American Express</option>
                                    <option value="master-card">Mastercard</option>
                                    <option value="visa" selected="selected">Visa</option>
                                    <option value="default">Other</option>
                                    <?php
                                }
                                else{?>
                                    <option value="american-express">American Express</option>
                                    <option value="master-card">Mastercard</option>
                                    <option value="visa">Visa</option>
                                    <option value="default" selected="selected">Other</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <input class="submit" id="submit" type="submit" name="submit" value="Update card">
                        </div>
                    </form>
                    <button id="remove-card-btn">Remove card</button>
                    <div id="ajax-response"></div>
                </div>
            </div>
        </div>



    <?php
    }
    require_once "include/footer.php";
    ?>

</body>
</html>


<?php

function retrieve_card_details($user){
    $db = database_connection();
    $rows = $db->query("SELECT * from Payments where user='$user'");

    try{
        if($rows){
            if($rows->num_rows == 0){
                return null;
            }
            else foreach ($rows as $row){
                return $row;
            }
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        $e->getMessage();
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
    }
}
?>

