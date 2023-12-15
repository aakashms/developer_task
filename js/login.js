$(document).ready(function () {
  $("#submitBtn").click(function (e) {
    e.preventDefault();

    if (!validateForm()) {
      return;
    }

    $.ajax({
      type: "POST",
      url: "./php/login.php",
      data: $("#loginForm").serialize(),
      success: function (response) {
        let trimRes = response.trim().toLowerCase();

        if (trimRes !== "fail") {
            var userDetails = JSON.parse(trimRes);
            localStorage.setItem("loggedInUser", JSON.stringify(userDetails));

          window.location.href = "./profile.html";
        } else {
          alert("Invalid email or password");
        } 
      },
      error: function (error) {
        console.log("Error: " + error);
        alert("Unexpected Error. Please try again later");
      },
    });
  });

  const validateForm = () => {
    var email = $("#email").val();
    var password = $("#password").val();

    if (!email || !password) {
      alert("Please enter both email and password.");
      return false;
    }

    return true;
  };
});
