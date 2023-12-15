$(document).ready(function () {
    $("#submitBtn").click(function (event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "./php/login.php",
            data: $("#loginForm").serialize(),
            success: function (response) {
                window.location.href = "./profile.html";
             
            },
            error: function (error) {
                console.log("Error: " + error);
            }
        });
    });
});