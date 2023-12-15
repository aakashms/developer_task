
$(document).ready(function () {
  var loggedInUserJSON = localStorage.getItem("loggedInUser");
  if (loggedInUserJSON) {
    var loggedInUser = JSON.parse(loggedInUserJSON);
    $("#name").val(loggedInUser.name);
    $("#email").val(loggedInUser.email);
    $("#address").val(loggedInUser.address);

  }else {
    // Handle the case when loggedInUser is not available (e.g., user not logged in)
    alert("User not logged in. Redirecting to login page.");
    window.location.href = "./login.html";
  }

  // function fetchUserData() {
  //   $.ajax({
  //     url: "php/profile.php", 
  //     method: "GET",
  //     dataType: "json",
  //     success: function (data) {
        
  //       $("#name").val(data.name);
  //       $("#email").val(data.email);
  //       $("#dob").val(data.dob);
  //       $("#address").val(data.address);
  //       $("#phone").val(data.phone);
  //       $("#gender").val(data.gender);
  //       $("#designation").val(data.designation);
  //     },
  //     error: function (error) {
  //       console.error("Error fetching user data:", error);
  //     },
  //   });
  // }

  
  $(document).on("click", "#editBtn", function () {
    
    $("input, textarea, select").not("#email").prop("disabled", false);
    //$("email").prop("disabled",true);

    $("#editBtn").hide();
    $("#saveBtn").show();
  });

 
  $(document).on("click", "#saveBtn", function () {
    $("input, textarea, select").prop("disabled", true);
    $("#editBtn").show();
    $("#saveBtn").hide();
  });

 // fetchUserData();
});
