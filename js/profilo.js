$(function () {
  $("#logout").on("click", function () {
    //
    snackbar("Effettuo il logout...", "info");
    //
    $.ajax("ajax/login.php", {
      method: "POST",
      data: { action: "logout" },
      success: function () {
        snackbar("Logout effettuato", "success");
        setTimeout(() => (location.href = "./"), 500);
      },
      error: function () {
        snackbar("Errore AJAX", "error");
      },
    });
  });

  $("#save").on("click", function () {
    snackbar("Salvataggio in corso...", "info");
    $.ajax("ajax/profilo.php", {
      method: "POST",
      data: {
        action: "update",
        name: $("#name").val(),
        email: $("#email").val(),
      },
      success: function (r) {
        try {
          // Check if response is valid JSON
          JSON.parse(r);
          snackbar("Update effettuato", "success");
        } catch (e) {
          snackbar(`${e.name}, ${e.message}`, "error");
        }
      },
      error: function () {
        snackbar("Errore AJAX", "error");
      },
    });
  });

  $("#delete").on("click", function () {
    snackbar("Richiesta conferma...", "info");
    if (
      confirm(
        "Sei sicuro di voler eliminare il tuo account. Tutti i dati saranno cancellati e non sarà più possibile ripristinarli.\n\nSe confermi non sarà più possibile accedere all'area privata del sito."
      )
    ) {
      snackbar("Elimino l'account...", "info");
      // Soluzione provvisoria
      const password = prompt("Inserisci la password");
      if (password) {
        $.ajax("ajax/profilo.php", {
          method: "POST",
          data: { action: "delete", password },
          success: function (r) {
            try {
              // Check if response is valid JSON
              JSON.parse(r);
              snackbar("Account eliminato", "success");
              setTimeout(() => {
                location.href = "./";
              }, 500);
            } catch (e) {
              snackbar("error", `${e.name}, ${e.message}`);
            }
          },
          error: function () {
            snackbar("Errore AJAX", "error");
          },
        });
      } else {
        snackbar("Operazione annullata", "info");
      }
    } else {
      snackbar("Operazione annullata", "info");
    }
  });
});
