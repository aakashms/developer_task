
$(document).ready(function () {
  var loggedInUserJSON = localStorage.getItem("loggedInUser");
  var redisUserData = getUserData(updatedUserData.email);

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

      var redisUserData = getUserData(updatedUserData.email);
      //console.log("Redis Data:", redisUserData);
      
      saveUserData(updatedUserData);
    });
  } else {
    alert("User not logged in. Redirecting to login page.");
    window.location.href = "./login.html";
  }

  function fetchUserData(email) {

    $.ajax({
      url: "php/profile.php",
      method: "GET",
      data: { email: email },
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
        if (xhr.status === 404) {
          console.log("User not found, assuming as new user.");
        } else {
          console.error("Failed to fetch user data. Please try again.");
        }
      },
    });
  }

  function saveUserData(updatedUserData) {
    updatedUserData.email = $("#email").val();
    console.log("Updated User Data:", updatedUserData);
    console.log("Sending AJAX request to save user data...");
    
    $.ajax({
      type: "POST",
      url: "php/profile.php",
      data: updatedUserData,
      dataType: "json",
      success: function (response) {
        console.log("Received server response:", response); // Log the entire response
    
        try {
          if (response && response.status === "success") {
            console.log("Redis Data:", redisUserData); // Log the Redis data
            console.log("Updated Data:", updatedUserData); // Log the updated data

            if (response.action === "no_changes") {
              console.log("No changes were made.");
              alert("No changes are there to edit and submit !!!");
            } else {
              var actionMessage = response.action === "inserted" ? "submitted" : "upd";
              alert(actionMessage + " successfully"+"!!!!!");
            }
          } else {
            throw new Error("Invalid response format");
          }
        } catch (error) {
          console.error("Error parsing server response:", error);
          alert("Unexpected Error. Please try again later (No more changes)");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error saving user data:", error);
        console.log(xhr);
        try {
          var response = JSON.parse(xhr.responseText);
          alert(
            "Unexpected Error. Please try again later.\nError: " +
              response.message
          );
        } catch (e) {
          alert("Unexpected Error. Please try again later.");
        }
      },
    });
  }
});
