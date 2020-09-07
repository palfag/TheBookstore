<?php

function add_to_cart($user, $item){
    $db = database_connection();
    $sql = "INSERT INTO Cart(user, item) VALUES ('$user', '$item')";
    try{

        if(!$db->query($sql)){
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e){
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}

function remove_all_from_cart($user){
    $db = database_connection();
    $sql = "DELETE FROM Cart where user='$user'";
    try{

        if(!$db->query($sql)){
            throw new Exception("query error");
        }
        return true;
    } catch (Exception $e){
        $e->getMessage(); # TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
        return false;
    } finally {
        $db->close();
    }
}

function get_subtotal($email, $item){
    $db = database_connection();
    $sql = "SELECT SUM(price) as subtotal
            FROM Cart JOIN Books on item = book_id
            WHERE user = '$email' and item = '$item'
            Group by user, item";

    $rows = $db->query($sql);

    try{
        if($rows){
            foreach ($rows as $row){
                return $row['subtotal'];
            }
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        $e->getMessage();
        return null;
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
    }
}

function get_total($email){
    $items = update_cart($email);
    $total = 0;
    for ($i = 0; $i < count($items); $i++) {
        $item = $items[$i];
        $total += (double)$item['subtotal'];
    }
    /* non penso sia necessario... ma perché no ahah*/
    $total = sprintf('%0.2f', round($total, 2));
    return $total;
}

function update_cart($email){
    $db = database_connection();
    $sql = "SELECT book_id, cover, title, author, price, COUNT(insertion_id) as quantity, SUM(price) as subtotal
                    FROM Cart JOIN Books on item = book_id
                    WHERE user = '$email'
                    GROUP BY user, book_id, cover, title, author, price";

    $rows = $db->query($sql);
    $data = array();

    try{
        if($rows){
            foreach ($rows as $row){
                $data[] = $row;
            }
        }
        else throw new Exception("query error");
    } catch(Exception $e){
        $e->getMessage();
        ######### TODO: DA DEFINIRE COSA FARE IN CASO DI ECCEZIONI
    } finally {
        $db->close();
        return $data;
    }
}

// funzione importantissima che fa da badge
function retrieve_number_cart_items($email){
    $db = database_connection();
    $rows = $db->query("SELECT COUNT(item) from cart where user = '$email'");
    try{
        if($rows){
            foreach ($rows as $row){
                return $row['COUNT(item)'];
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
