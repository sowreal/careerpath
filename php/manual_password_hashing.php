<!-- Password for dummy HR account:
    myouimina@gmail.com
 -->
<?php
$password = 'Temporary@Password01'; // Replace with the password you want to hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Using bcrypt

echo "Hashed Password: " . $hashed_password;
