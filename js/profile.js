
$(document).ready(function () {
  var loggedInUserJSON = localStorage.getItem("loggedInUser");

  if (loggedInUserJSON) {
    var loggedInUser = JSON.parse(loggedInUserJSON);
    $("#name").val(loggedInUser.name);
    $("#email").val(loggedInUser.email);
    $("#address").val(loggedInUser.address);

    //checkMongoDBConnection();

   fetchUserData(loggedInUser.email);

    $(document).on("click", "#editBtn", function () {
      $("input, textarea, select").not("#email").prop("disabled", false);
  
      $("#editBtn").hide();
      $("#saveBtn").show();
    });

    $(document).on("click", "#saveBtn", function () {
      $("input, textarea, select").prop("disabled", true);
      $("#editBtn").show();
      $("#saveBtn").hide();

    var updatedUserData = {
      email: $("#email").val(),
      name: $("#name").val(),
      age: $("#age").val(),
      dob: $("#dob").val(),
      address: $("#address").val(),
      phone: $("#phone").val(),
      gender: $("#gender").val(),
      designation: $("#designation").val(),
    };

    // Send updated user data to server for saving
    saveUserData(updatedUserData);
  });

  }else {
    // Handle the case when loggedInUser is not available (e.g., user not logged in)
    alert("User not logged in. Redirecting to login page.");
    window.location.href = "./login.html";
  }

  function fetchUserData(email) {
    $.ajax({
      url: "php/profile.php", 
      method: "GET",
      data:{email:email},
      dataType: "json",
      success: function (data) {
        
        $("#name").val(data.name);
        $("#email").val(data.email);
        $("#age").val(data.age);
        $("#dob").val(data.dob);
        $("#address").val(data.address);
        $("#phone").val(data.phone);
        $("#gender").val(data.gender);
        $("#designation").val(data.designation);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching user data:", error);
        console.log(xhr.responseText);
        
        if(xhr.status === 404){
          console.log("User not found, assuming new user.");
        } else {
          console.error("Failed to fetch user data. Please try again.");
      }
      },
    });
  }

  function saveUserData(updatedUserData) {

    updatedUserData.email = $("#email").val();
    $.ajax({
      type: "POST",
      url: "php/profile.php",
      data: updatedUserData,
      dataType: "json",
      success: function (response) {

        if (response.status === "success") {
          var action = (response.message.includes("Updated")) ? "updated" : "submitted";
          alert("User data " + action + " successfully!");
        } else {
          alert("Failed to save user data. Please try again.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error saving user data:", error);

        // Check if the response contains a message field
        var errorMessage = "Unexpected Error. Please try again later";
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }

        console.error(errorMessage);
    },
    });
  }
  
});
