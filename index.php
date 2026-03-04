
<html>

<head>
    <link rel="stylesheet" href="style_index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container">


    <?php
    session_start();

    // Καθαρισμός cache
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: 0");

    // Έλεγχος αν η συνεδρία έχει λήξει ή αν έγινε αποσύνδεση
    if (isset($_GET['message']) && $_GET['message'] == 'session_expired') {
        echo "<p style='color:red;'>Η συνεδρία σας έχει λήξει. Παρακαλώ συνδεθείτε ξανά.</p>";
    } elseif (isset($_GET['logged_out']) && $_GET['logged_out'] == 1) {
        echo "<p style='color:green;'>Αποσυνδεθήκατε με επιτυχία.</p>";
    }


    ?>

    <table>
        <tr>
            <td>
                <h2>Civilian Login Area</h2>
                <form action="validate_civilian.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <input type="submit" value="Login">
                </form>
            </td>

            <td>
                <h2>Admin Login Area</h2>
                <form action="validate_admin.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <input type="submit" value="Login">
                </form>
            </td>

            <td>
                <h2>Rescuer Login Area</h2>
                <form action="validate_rescuer.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <input type="submit" value="Login">
                </form>
            </td>
        </tr>

        <tr>
            <td colspan="3" align="center">
                <a href="register.php">Registration</a>
            </td>
        </tr>
    </table>
</div>

</body>

</html>
