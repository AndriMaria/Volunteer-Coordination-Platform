<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style_register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    include 'connect.php';

    if(isset($_POST["submit"])) {
        $name = $_POST['name'];
        $last_name = $_POST['last_name'];
        $phone_number = $_POST['phone_number'];
        $username = $_POST['user_name'];
        $password = $_POST['p'];

        // Έλεγχος αν το username υπάρχει ήδη
        $checkUsername = "SELECT COUNT(*) as total FROM civilian WHERE username_civ = '$username'";
        $result = $conn->query($checkUsername);
        $row = $result->fetch_assoc();

        if ($row['total'] > 0) {
            // Το username υπάρχει ήδη
            echo "<div class='alert alert-danger'>Username already exists. Please choose a different username.</div>";
        } else {
            // Το username δεν υπάρχει, proceed με την εγγραφή
            $insert = "INSERT INTO civilian (username_civ, password_civ, phone_number, name, last_name) 
                       VALUES ('$username', '$password', '$phone_number', '$name', '$last_name')";

            if($conn->query($insert) === TRUE) {
                echo "<div class='alert alert-success'>You registered successfully!</div>";
                echo "<a href='index.php' class='btn btn-primary'>Go Back to Login</a>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
    }
    ?>

    <form action="register.php" method="post">
        <h2>Civilian Register Area</h2>

        <!-- First Name Field -->
        <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="First Name" required>
        </div>

        <!-- Last Name Field -->
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
        </div>

        <!-- Phone Number Field -->
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" required>
        </div>

        <!-- Username Field -->
        <div class="form-group">
            <label for="user_name">Username</label>
            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username" required>
        </div>

        <!-- Password Field with Toggle -->
        <div class="form-group password-container">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="p" placeholder="Password" required>
            <span class="password-toggle" onclick="togglePassword()">👁️</span>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Register" name="submit">
        </div>

        <a href="index.php">Return</a>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
    }
</script>

</body>
</html>
