<?php
    require_once "../../include/db.inc.php";
    require_once "../../functions/common_authentication.php";

    session_start();

    if (isset($_POST['submit'])) {
        $email = filter_input(INPUT_POST, "email",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $password = filter_input(INPUT_POST, "password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (is_contained($email)) {
                    $hash = retrieve_hash($email);

                    if (password_verify($password, $hash)) {
                        $_SESSION['email'] = $email;

                        // AJAX RESPONSE
                        $response = array("success" => 1);
                        echo json_encode($response);

                    } else throw new Exception("password is incorrect");
                } else throw new Exception("email does not exist in our databases");
            } else throw new Exception("email not valid");
        } catch (Exception $e) {
            $response = array("success" => 0, "flash_message" => $e->getMessage());
            echo json_encode($response);
        }
    }