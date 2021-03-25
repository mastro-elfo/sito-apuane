$(function () {
  $("#login").on("submit", function (e) {
    e.preventDefault();
    // Request AJAX
    $.ajax("ajax/login.php", {
      method: "POST",
      data: {
        action: "login",
        username: $("#username").val(),
        password: $("#password").val(),
      },
      success: (r) => {
        // console.log(r);
        try {
          if (JSON.parse(r)) {
            snackbar("Login effettuato", "success");
            // Redirect to Home Page
            setTimeout(() => (location.href = "./"), 500);
          } else {
            snackbar("Login fallito", "error");
          }
        } catch (e) {
          snackbar(`${e.name}, ${e.message}`, "error");
        }
      },
      error: () => {
        snackbar("Errore AJAX", "error");
      },
    });
  });
});
