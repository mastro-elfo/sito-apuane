$(function () {
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
            snackbar("Registrazione effettuata", "success");
            setTimeout(() => (location.href = "/login.php"), 500);
          } else {
            snackbar("Errore di registrazione", "error");
          }
        } catch {
          snackbar("Errore risposta", "error");
        }
      },
      error: function () {
        snackbar("Errore AJAX", "error");
      },
    });
  });
});
