$(document).ready(function() {
    $("#submitBtn").click(function() {
        $.ajax({
            type: "POST",
            url: "./php/register.php",
            data: $("#signupForm").serialize(),
            success: function(response) {
               
                window.location.href = "./login.html";
            },
            error: function(error) {
                console.log("Error: " + error);
            }
        });
    });
}); 