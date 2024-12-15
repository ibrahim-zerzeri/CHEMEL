<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin-top: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .confirmation-message {
            text-align: center;
            font-size: 24px;
            color: #28a745;
            margin-top: 20px;
        }

        .alert-success {
            margin-top: 20px;
            padding: 15px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Order Confirmation</h2>
        <form action="order_delivered.php" method="POST">
            <div class="form-group">
                <button type="submit" class="btn btn-primary py-3 px-4">Place an order</button>
            </div>
        </form>

        <!-- Confirmation Message -->
        <div class="confirmation-message">
            <h3>Order Delivered</h3>
        </div>

        <!-- Success Alert -->
        <div class="alert alert-success" role="alert">
            Your order has been successfully delivered! Thank you for your purchase.
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
