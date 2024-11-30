<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire de paiement</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
<body>
  <div class="payment-form">
    <h2>Formulaire de paiement</h2>
    <div class="form-group">
      <label for="cardNumber">Numéro de la carte</label>
      <input type="text" id="cardNumber" placeholder="Entrez votre numéro de carte">
    </div>
    <div class="form-group">
      <label for="expiryDate">Date d'expiration</label>
      <input type="text" id="expiryDate" placeholder="MM/AA">
    </div>
    <div class="form-group">
      <label for="cvv">CVV</label>
      <input type="text" id="cvv" placeholder="CVV">
    </div>
    <button type="submit">Payer</button>
    <div class="card-display" id="cardDisplay">
      <i class="fas fa-credit-card"></i>
      <span id="cardType">Type de carte</span>
    </div>
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
        icon = 'fa-cc-visa';
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
