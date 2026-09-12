<?php
require_once("../../controllers/client/sessionManage.php");
require_once("../../models/usersModel.php");
$currentUser=getUser($_SESSION["uid"]);
require_once("../../partials/formHelper.php");
require("../../controllers/client/paymentControls.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php require("../../partials/client/head.php") ?>
<style>
            #middle {
                padding: 20px;
                flex: 1;
                min-width: 0;
            }

            #paymentBox {
                display: flex;
                gap: 20px;
            }

            #left {
                flex: 2;
                min-width: 0;
                background-color: white;
                border: 1px solid gray;
                border-radius: 10px;
                padding: 20px;
            }

            #right {
                flex: 1;
                min-width: 0;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            #left h4, #right h4 {
                margin-top: 0;
            }

            #left p, #right p {
                font-size: 13px;
                color: gray;
            }

            #methods {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 20px;
            }

            .method {
                width: 48%;
                border: 1px solid gray;
                border-radius: 7px;
                padding: 10px;
                box-sizing: border-box;
            }

            .method:hover {
                border-color: blue;
            }

            .method b {
                font-size: 13px;
            }

            .method p {
                margin: 5px 0 0 25px;
            }

            #left label {
                font-size: 13px;
            }

            #left input[type="text"] {
                border: 1px solid gray;
                border-radius: 7px;
                height: 40px;
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                box-sizing: border-box;
            }

            #verify {
                background-color: aliceblue;
                border: 1px solid gray;
                border-radius: 7px;
                padding: 10px;
                margin-top: 20px;
            }

            #verify b {
                color: blue;
                font-size: 13px;
            }

            #buttons {
                margin-top: 20px;
            }

            #buttons button {
                height: 35px;
                border-radius: 7px;
            }

            #confirm {
                width: 170px;
                background-color: blue;
                color: white;
                border: none;
            }

            #cancel {
                width: 100px;
                margin-left: 10px;
            }

            #summary {
                background-color: white;
                border: 1px solid gray;
                border-radius: 10px;
                padding: 20px;
                flex: 1;
            }

            #eventBox {
                background-color: aliceblue;
                padding: 15px;
                border-radius: 7px;
            }

            #eventBox b {
                font-size: 14px;
            }

            #details p {
                display: flex;
                justify-content: space-between;
                gap: 10px;
                margin: 20px 0;
            }

            #details b {
                color: black;
            }

            #total {
                border-top: 1px solid gray;
                padding-top: 15px;
                display: flex;
                justify-content: space-between;
            }

            #totalValue {
                color: blue;
            }

            #available {
                background-color: white;
                border: 1px solid gray;
                border-radius: 10px;
                padding: 20px;
            }

            #availableMethods {
                display: flex;
                flex-wrap: wrap;
            }

            #availableMethods p {
                width: 50%;
                color: black;
                margin: 5px 0;
            }

            #left .fieldError {
                color: red !important;
                font-size: 12px;
                margin: 5px 0 0 0;
                display: none;
            }

            #left .fieldError.show {
                display: block;
            }
        
</style>
</head>
<body>
<?php require("../../partials/client/header.php") ?>
<div id="middle">
            <h2>Ticket Payment</h2>
            <p>Choose a payment method and complete your corporate event ticket purchase.</p>
            <div id="paymentBox">
                <div id="left">
                    <h4>Payment Method</h4>
                    <p>Select one of the available payment options.</p>
                    <form method="POST" id="paymentForm" onsubmit="return validatePayment()" novalidate>
                        <?php formToken(); ?>
                        <input type="hidden" name="checkout" value="<?php echo h($_SESSION['checkout']); ?>">
                        <div id="methods">
                            <label class="method">
                                <input type="radio" name="method" value="BKASH" <?php if(!isset($_POST['method']) || $_POST['method']=='BKASH') { echo 'checked'; } ?>>
                                <b>bKash</b>
                                <p>Mobile financial service</p>
                            </label>
                            <label class="method">
                                <input type="radio" name="method" value="CARD" <?php if(isset($_POST['method']) && $_POST['method']=='CARD') { echo 'checked'; } ?>>
                                <b>Card</b>
                                <p>Debit or credit card</p>
                            </label>
                        </div>
                        <p id="methodError" class="fieldError<?php if($methodError!='') { echo ' show'; } ?>">
                            <?php echo h($methodError); ?>
                        </p>
                        <label>bKash Number</label>
                        <br>
                        <input
                            type="text"
                            name="mobileNumber"
                            id="mobileNumber"
                            maxlength="11"
                            inputmode="numeric"
                            placeholder="01XXXXXXXXX"
                            value="<?php echo isset($_POST['mobileNumber']) ? h($_POST['mobileNumber']) : ''; ?>"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        >
                        <p id="mobileError" class="fieldError<?php if($mobileError!='') { echo ' show'; } ?>">
                            <?php echo h($mobileError); ?>
                        </p>
                        <br>
                        <label>Card Number</label>
                        <br>
                        <input
                            type="text"
                            name="cardNumber"
                            id="cardNumber"
                            maxlength="19"
                            inputmode="numeric"
                            placeholder="Enter card number"
                            value="<?php echo isset($_POST['cardNumber']) ? h($_POST['cardNumber']) : ''; ?>"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        >
                        <p id="cardError" class="fieldError<?php if($cardError!='') { echo ' show'; } ?>">
                            <?php echo h($cardError); ?>
                        </p>
                        <div id="verify">
                            <b>Payment verification</b>
                            <p>Enter the number for the payment method you selected.</p>
                        </div>
                        <p id="paymentError" class="fieldError<?php if($paymentError!='') { echo ' show'; } ?>">
                            <?php echo h($paymentError); ?>
                        </p>
                        <div id="buttons">
                            <button type="submit" id="confirm">Confirm Payment</button>
                            <a href="buyTicket.php">
                                <button type="button" id="cancel">Cancel</button>
                            </a>
                        </div>
                    </form>
                </div>
                <div id="right">
                    <div id="summary">
                        <h4>Order Summary</h4>
                        <div id="eventBox">
                            <b>
                                <?php echo h($event['title']); ?>
                            </b>
                            <p>
                                <?php echo h($event['type']); ?>
                            </p>
                        </div>
                        <div id="details">
                            <p>
                                <span>Event ID</span>
                                <b>
                                    <?php echo $event['eid']; ?>
                                </b>
                            </p>
                            <p>
                                <span>Location</span>
                                <b>
                                    <?php echo h($event['latitude']); ?>, <?php echo h($event['longitude']); ?>
                                </b>
                            </p>
                            <p>
                                <span>Quantity</span>
                                <b>1 Ticket</b>
                            </p>
                            <p>
                                <span>Ticket Price</span>
                                <b>BDT <?php echo $event['tprice']; ?>
                                </b>
                            </p>
                        </div>
                        <div id="total">
                            <b>Total</b>
                            <b id="totalValue">BDT <?php echo $event['tprice']; ?>
                            </b>
                        </div>
                    </div>
                    <div id="available">
                        <h4>Available Methods</h4>
                        <div id="availableMethods">
                            <p>bKash</p>
                            <p>Card</p>
                        </div>
                        <p>Select a method before confirming payment.</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function validCardNumber(number) {
                if (!/^[0-9]{13,19}$/.test(number)) {
                    return false;
                }
                var sum = 0;
                var doubleDigit = false;
                for (var i = number.length - 1; i >= 0; i--) {
                    var digit = parseInt(number.charAt(i));
                    if (doubleDigit) {
                        digit = digit * 2;
                        if (digit > 9) {
                            digit = digit - 9;
                        }
                    }
                    sum = sum + digit;
                    doubleDigit = !doubleDigit;
                }
                return sum % 10 == 0;
            }
            function showError(id, text) {
                var error = document.getElementById(id);
                error.innerHTML = text;
                error.style.color = 'red';
                error.classList.add('show');
            }
            function clearError(id) {
                var error = document.getElementById(id);
                error.innerHTML = '';
                error.classList.remove('show');
            }
            function validatePayment() {
                var selected = document.querySelector('input[name="method"]:checked');
                var mobile = document.getElementById('mobileNumber').value;
                var card = document.getElementById('cardNumber').value;
                clearError('methodError');
                clearError('mobileError');
                clearError('cardError');
                if (!selected) {
                    showError('methodError', 'Choose a payment method.');
                    return false;
                }
                if (selected.value == 'BKASH') {
                    if (!/^01[3-9][0-9]{8}$/.test(mobile)) {
                        showError('mobileError', 'Enter a valid bKash number.');
                        return false;
                    }
                }
                if (selected.value == 'CARD') {
                    if (!validCardNumber(card)) {
                        showError('cardError', 'Enter a valid card number.');
                        return false;
                    }
                }
                return true;
            }
            document.getElementById('mobileNumber').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');             clearError('mobileError');
            }
            );
            document.getElementById('cardNumber').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');             clearError('cardError');
            }
            );
            var methods = document.querySelectorAll('input[name="method"]');
            for (var i = 0; i < methods.length; i++) {
                methods[i].addEventListener('change', function() {
                    clearError('methodError');                 clearError('mobileError');                 clearError('cardError');
                }
                );
            }
        </script>
<?php require("../../partials/client/header-end.php") ?>
    
</body>
</html>