$(function () {
  $("#registrazione").on("submit", function (e) {
    e.preventDefault();
    //
    const name = $('#registrazione [name="name"]').val();
    const email = $('#registrazione [name="email"]').val();
    const password = $('#registrazione [name="password"]').val();
    // Controllo nome
    if (!name) {
      snackbar("Devi compilare il nome", "warning");
      return false;
    }
    // Controllo validita' email
    if (
      !/^[a-zA-Z0-9][a-zA-Z0-9!#$%&'*+-/=?^_`{|]*\@[a-zA-Z0-9\.\-]+$/.test(
        email
      )
    ) {
      snackbar("Email non valida", "warning");
      return false;
    }
    // Controllo password sicura
    if (password.length < 8) {
      snackbar("Password troppo corta", "warning");
      return false;
    }
    if (!/[a-zA-Z]/.test(password)) {
      snackbar("La password deve contenere almeno un carattere", "warning");
      return false;
    }
    if (!/[0-9]/.test(password)) {
      snackbar("La password deve contenere almeno un numero", "warning");
      return false;
    }
    if (!/\W/.test(password)) {
      snackbar(
        "La password deve contenere almeno un carattere non alfanumerico",
        "warning"
      );
      return false;
    }
    // snackbar("Tutti i campi sono validi", "success");
    // return false;
    // console.log(e);
    $.ajax("ajax/registrazione.php", {
      method: "POST",
      data: {
        action: "signup",
        name,
        email,
        password,
      },
      success: function (r) {
        try {
          const { id } = JSON.parse(r);
          if (id) {
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
