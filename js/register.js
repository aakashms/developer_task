$(document).ready(function () {
  $("#submitBtn").click(function (e) {
    e.preventDefault();

    if(!validateForm()){
        return;
    }

    var password = $("#password").val();
    var confirmPassword = $("#cpass").val();

    if (password !== confirmPassword ) {
      alert("Password and Confirm Password must be same");
    } else {
      $.ajax({
        type: "POST",
        url: "./php/register.php",
        data: $("#signupForm").serialize(),
        success: function (response) {
            let trimRes = response.trim().toLowerCase();
            
          if (trimRes === "success") {
            window.location.href = "./login.html";

          } else if(trimRes === "user_email") {
            alert("You already have an Account. Please log in");
          }else {
            alert("Enter valid details");
          }
        },
        error: function (error) {
          console.log("Error: " + error);
          alert("Unexpected Error");
        },
      });
    }
  });

const validateForm = ()=>{
    var name = $("#name").val();
    var email = $("#email").val();
    var addr = $("#addr").val();
    var password = $("#password").val();
    var confirmPassword = $("#cpass").val();

    if (!name || !email || !addr || !password || !confirmPassword) {
      alert("Please fill all the required fields.");
      return false;
    }

    return true;
}

});