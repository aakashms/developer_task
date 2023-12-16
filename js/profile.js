
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

    saveUserData(updatedUserData);
  });

  }else {
  
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
          console.log("User not found, assuming as new user.");
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
        try{
          if (response && response.status === "success") {
            var actionMessage = response.action === "inserted" ? "submitted" : "updated";
            alert(actionMessage + " successfully!");
        } else {
            throw new Error("Invalid response format");
        }
        }catch (error) {
                console.error("Error parsing server response:", error);
                alert("Unexpected Error. Please try again later");
            }
        
      },
      error: function (xhr, status, error) {
        console.error("Error saving user data:", error);
        console.log(xhr.responseText); 
        alert("Unexpected Error. Please try again later");
        
    },
    });
  }
  
});
