<?php

namespace App\Services;

class Payment {
    public static function payWithVisa($card_number, $cvc_code) {
        // Validate Visa card number and CVC code
        if (strlen($card_number) === 16 && ctype_digit($card_number) && strlen($cvc_code) === 3 && ctype_digit($cvc_code)) {
            return true;
        }
        return false;
    }

    public static function payWithPaypal($emailAddress) {
        // Validate email address
        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function payWithMBway($phone_number) {
        // Validate phone number
        if (strlen($phone_number) === 9 && ctype_digit($phone_number)) {
            return true;
        }
        return false;
    }
}
