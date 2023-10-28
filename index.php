<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <title>Login / Registration form</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.min.css">


</head>
</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <div class="bt">
                <label for="chk" aria-hidden="true">SIGN UP</label>
                <input type="text" name="FullName" placeholder="username" required>
                <input type="email" name="Email" placeholder="email" required>
                <input type="password" name="Password" placeholder="password" required>                
</div>
            <button type="submit" class="btn btn-primary" onclick="Registration()">SIGN IN</button>

        </div>
        <div class="login">
            <div class="bt">
                <label for="chk" aria-hidden="true">LOG IN</label>
                <input type="email" name="Login_Email" placeholder="email" required>
                <input type="password" name="Login_Password" placeholder="password" required>                
            </div>
            <button type="submit" class="btn btn-primary" onclick="Login()">LOG IN</button>

        </div>

    </div>
    


    <script>

function Registration() {
            var FullName = $("input[name=FullName]").val();
            var Email = $("input[name=Email]").val();
            var Password = $("input[name=Password]").val();

            // Regular expression for email validation
            var emailPattern = /^[A-Za-z0-9._%+-]+@gmail\.com$/;

            if (FullName == '' || Email == '' || Password == '') {
                alert('Please fill all the input boxes.');
            } else if (!emailPattern.test(Email)) {
                alert('Invalid email format. Please use a valid Gmail address.');
            } 
            else {

    var user_info = {
        FullName : FullName,
        Email:Email,
        Password:Password
    }

    $.ajax({
            type: "POST",
            url: 'register.php',
            data: user_info,
            success: function(response)
            {
                var response = JSON.parse(response);
                if(response)
                {
                    console.log(response.status);

                    if(response.status == 'success')
                    {
                    // redirect to profiles
                    swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Login Successful'
            }).then(function() {
            window.location = "index.php";
    });
}

                    else if(response.status == 'failed' && response.error == 'Email_already_taken')
                    {
                        alert('Email Id is already taken. Try another one...');
                    }
                    else
                    {
                        alert(response.error);
                    }  
                }
                else
                {
                    console.log('Error');
                }
        }
    });

}

}

function Login() {
    var Email = $("input[name=Login_Email]").val();
    var Password = $("input[name=Login_Password]").val();

    var user_login_info = {
        Email: Email,
        Password: Password
    }
    
    $.ajax({
        type: "POST",
        url: 'validation.php',
        data: user_login_info,
        success: function (response) {
            var response = JSON.parse(response);
            if (response) {
                console.log(response.status);

                if (response.status == 'success') {
                    // Use SweetAlert for success message with red background and border radius
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Login Successful',
                        customClass: {
                            container: 'green-gradient', // Apply custom CSS class for green gradient background
                            icon: 'leaf-icon', // Apply custom CSS class for leaf icon
                            popup: 'custom-popup' // Apply custom CSS class for the popup
                        },
                        showConfirmButton: false, // Hide the confirmation button
                        timer: 2000, // Auto close after 2 seconds
                        backdrop: `
                        rgba(0,255,0,0.7) 
                        ` // Red background color
                    }).then(function () {
                        window.location = "profile.php";
                    });
                } else if (response.status == 'Invalid') {
                    alert('Invalid Email Id and Password..');
                } else if (response.status == 'Error') {
                    alert(response.Error);
                }
            } else {
                console.log('Error');
            }
        }
    });
}



</script>
</body>
</html>