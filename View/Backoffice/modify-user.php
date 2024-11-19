<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Modification Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html, body {
        height: 100%;
    }
    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>
<body>
    <!-- ============================================================== -->
    <!-- User Modification Form -->
    <!-- ============================================================== -->
    <form class="splash-container" method="POST" action="update_user.php">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Modify User Information</h3>
                <p>Update the user details below.</p>
            </div>
            <div class="card-body">
                <!-- User ID (hidden) -->
                <div class="form-group">
                    <input class="form-control form-control-lg" type="hidden" name="user_id" required>
                </div>
                <!-- First Name -->
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="first_name" required placeholder="First Name">
                </div>
                <!-- Last Name -->
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="last_name" required placeholder="Last Name">
                </div>
                <!-- Username -->
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="username" required placeholder="Username">
                </div>
                <!-- Password -->
                <div class="form-group">
                    <input class="form-control form-control-lg" id="pass1" type="password" name="password" required placeholder="Password">
                </div>
                <!-- Confirm Password -->
                <div class="form-group">
                    <input class="form-control form-control-lg" type="password" name="confirm_password" required placeholder="Confirm Password">
                </div>
                <!-- Year of Birth -->
                <div class="form-group">
                    <input class="form-control form-control-lg" type="number" name="year_of_birth" required placeholder="Year of Birth">
                </div>
                <!-- Establishment -->
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="establishment" required placeholder="Establishment">
                </div>
                <!-- Submit Button -->
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit">Save Changes</button>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p><a href="User-management.php" class="text-secondary">Back to User Management</a></p>
            </div>
        </div>
    </form>
</body>
</html>
