$(function () {
  const response = $("#response");

  function setResponse(severity, text) {
    response.text(text);
    // Remove all classes
    response.removeClass();
    response.addClass(severity);
  }

  $("#registrazione").on("submit", function (e) {
    e.preventDefault();
    // console.log(e);
    $.ajax("ajax/registrazione.php", {
      method: "POST",
      data: {
        action: "signup",
        name: $('#registrazione [name="name"]').val(),
        email: $('#registrazione [name="email"]').val(),
        password: $('#registrazione [name="password"]').val(),
      },
      success: function (r) {
        try {
          r = JSON.parse(r);
          if (r) {
            setResponse("success", "Registrazione effettuata");
            setTimeout(() => (location.href = "/login.php"), 500);
          } else {
            setResponse("error", "Errore di registrazione");
          }
        } catch {
          setResponse("error", "Errore risposta");
        }
        setResponse("success", "Registrazione effettuata");
      },
      error: function () {
        setResponse("error", "Errore AJAX");
      },
    });
  });
});
