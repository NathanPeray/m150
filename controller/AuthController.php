<?php

    class AuthController {

        function loginAction() {
            Auth::getInstance()->verifyUser($_POST['email'], $_POST['hash']);
            echo json_encode([true]);
        }

        function registerAction() {
            $_POST['salt'] = User::hexString(16);
            $_POST['hash'] = User::hashPW($_POST['hash'], $_POST['salt']);
            $user = new User($_POST);
            echo json_encode([true]);
        }

        function logoutAction() {
            global $confArray;
            unset($_SESSION['user_id']);
            unset($_SESSION['auth']);
            Auth::getInstance()->logout();
            return new View("auth.logout", "Abgemeldet");
        }
    }
?>
