<?php
session_start();

$totalAmount=$_SESSION['totalAmount'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://www.paypal.com/sdk/js?client-id=AaZT1-pe2xttKIbx-pJ_LP7sZnBEX8C2iHf4moRFQMo91TuhAcac_pD9N7dtkB0PvpFScGdlSytVzjAJ"></script>
</head>
<body>
  <center><div id="paypal-button-container"></div>
  <script>
  paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '<?php echo ($totalAmount) ; ?>'
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            alert("Transaction OK : " + details.payer.name.given_name);
        });
    },
    onError: function(err) {
        console.error('Payment Error :', err);
        alert("Paiement échoué !");
    }
}).render("#paypal-button-container");
  </script>
  </center>
</body>
</html>