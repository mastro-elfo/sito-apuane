$(function () {
  const response = $("#response");

  function setResponse(severity, text) {
    response.text(text);
    // Remove all classes
    response.removeClass();
    response.addClass(severity);
  }

  $("#login").on("submit", function (e) {
    e.preventDefault();
    //
    setResponse("info", "Effettuo il login...");
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
          setResponse("success", "Login effettuato");
          // Redirect to Home Page
          setTimeout(() => (location.href = "./"), 500);
        } else {
          setResponse("error", "Login fallito");
        }
      },
      error: () => {
        setResponse("error", "Errore AJAX");
      },
    });
  });
});
