$(function () {
  const response = $("#response");
  $("#login").on("submit", function (e) {
    e.preventDefault();
    // console.log("Submit");
    response.text("Effettuo il login...");
    // Remove all classes
    response.removeClass();
    response.addClass("info");
    //
    $.ajax("ajax/login.php", {
      method: "POST",
      data: {
        action: "login",
        username: $("#username").val(),
        password: $("#password").val(),
      },
      success: (r) => {
        // console.log(r);
        if (r) {
          response.text("Login effettuato");
          // Remove all classes
          response.removeClass();
          response.addClass("success");
        } else {
          response.text("Login fallito");
          // Remove all classes
          response.removeClass();
          response.addClass("error");
        }
      },
      error: () => {
        response.text("Errore AJAX");
        // Remove all classes
        response.removeClass();
        response.addClass("error");
      },
    });
  });
});
