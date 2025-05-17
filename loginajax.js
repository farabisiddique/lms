
$(document).ready(function() {
    // When the form is submitted
    $('#signInBtn').click(function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Collect the form data
        var username = $('#username').val();
        var password = $('#password').val();
        
        // Send the data using AJAX to your PHP processing script
        $.ajax({
            type: "POST",
            url: "./login.php", // The PHP file you will create for processing login
            data: {
                username: username,
                password: password,
            },
            success: function(response) {
                console.log(response);
                var jsonData = JSON.parse(response);
              
              
                if (jsonData.success == 1) {
                    window.location.href = "admin/index.php"; // Redirect to the admin page on success
                } else {
                    
                    $(".loginHelpText").html("Wrong Email or Password. Please try again.");
                }
            }
        });
    });
});

