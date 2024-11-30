<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire de paiement</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="credit/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="credit/font-awesome/css/font-awesome.min.css" />
    <script type="text/javascript" src="credit/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="credit/bootstrap/js/bootstrap.min.js"></script>
  <style>
      
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .payment-form {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 400px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }
    .card-display {
      margin-top: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .card-display i {
      font-size: 40px;
      color: #007bff;
    }
  </style>
</head>
<div class="container">

<div class="page-header">
    <h1><center><small>Credit card payment</small></center></h1>
</div>

<!-- Credit Card Payment Form - START -->

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <h3 class="text-center">Payment Details</h3>
                        <img class="img-responsive cc-img" src="http://www.prepbootstrap.com/Content/images/shared/misc/creditcardicons.png">
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CARD NUMBER</label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control" placeholder="Valid Card Number" />
                                        <span class="input-group-addon"><span class="fa fa-credit-card"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                    <input type="tel" class="form-control" placeholder="MM / YY" />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label>CV CODE</label>
                                    <input type="tel" class="form-control" placeholder="CVC" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CARD OWNER</label>
                                    <input type="text" class="form-control" placeholder="Card Owner Names" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-warning btn-lg btn-block">Process payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cc-img {
        margin: 0 auto;
    }
</style>
<!-- Credit Card Payment Form - END -->

</div>


  <script>
    const cardInput = document.getElementById('cardNumber');
    const cardDisplay = document.getElementById('cardDisplay');
    const cardType = document.getElementById('cardType');

    cardInput.addEventListener('input', () => {
      const cardNumber = cardInput.value.replace(/\s/g, '');
      let type = 'Type de carte';
      let icon = 'fa-credit-card';

      if (/^4/.test(cardNumber)) {
        type = 'Visa';
        icon = '  fa-cc-visa';
      } else if (/^5[1-5]/.test(cardNumber)) {
        type = 'Mastercard';
        icon = 'fa-cc-mastercard';
      } else if (/^3[47]/.test(cardNumber)) {
        type = 'American Express';
        icon = 'fa-cc-amex';
      } else if (/^6(?:011|5)/.test(cardNumber)) {
        type = 'Discover';
        icon = 'fa-cc-discover';
      } else if (/^3(?:0[0-5]|[68])/.test(cardNumber)) {
        type = 'Diners Club';
        icon = 'fa-cc-diners-club';
      } else if (/^35/.test(cardNumber)) {
        type = 'JCB';
        icon = 'fa-cc-jcb';
      }

      cardType.textContent = type;
      cardDisplay.querySelector('i').className = `fas ${icon}`;
    });
  </script>
</body>
</html>
