
$(document).ready(function () {
  function fetchUserData() {
    $.ajax({
      url: "php/profile.php", 
      method: "GET",
      dataType: "json",
      success: function (data) {
        
        $("#name").val(data.name);
        $("#email").val(data.email);
        $("#dob").val(data.dob);
        $("#address").val(data.address);
        $("#phone").val(data.phone);
        $("#gender").val(data.gender);
        $("#designation").val(data.designation);
      },
      error: function (error) {
        console.error("Error fetching user data:", error);
      },
    });
  }

  
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

  fetchUserData();
});
