$(function () {
  const response = $("#response");

  function setResponse(severity, text) {
    response.text(text);
    // Remove all classes
    response.removeClass();
    response.addClass(severity);
  }

  $("#logout").on("click", function () {
    //
    setResponse("info", "Effettuo il logout...");
    //
    $.ajax("ajax/login.php", {
      method: "POST",
      data: { action: "logout" },
      success: function () {
        setResponse("success", "Logout effettuato");
        setTimeout(() => (location.href = "./"), 500);
      },
      error: function () {
        setResponse("error", "Errore AJAX");
      },
    });
  });

  $("#save").on("click", function () {
    setResponse("info", "Salvataggio in corso...");
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
          setResponse("success", "Update effettuato");
        } catch (e) {
          setResponse("error", `${e.name}, ${e.message}`);
        }
      },
      error: function () {
        setResponse("error", "Errore AJAX");
      },
    });
  });

  $("#delete").on("click", function () {
    setResponse("info", "Richiesta conferma...");
    if (
      confirm(
        "Sei sicuro di voler eliminare il tuo account. Tutti i dati saranno cancellati e non sarà più possibile ripristinarli.\n\nSe confermi non sarà più possibile accedere all'area privata del sito."
      )
    ) {
      setResponse("info", "Elimino l'account...");
      $.ajax("ajax/profilo.php", {
        method: "POST",
        data: { action: "delete" },
        success: function (r) {
          try {
            // Check if response is valid JSON
            JSON.parse(r);
            setResponse("success", "Account eliminato");
            setTimeout(() => {
              location.href = "./";
            }, 500);
          } catch (e) {
            setResponse("error", `${e.name}, ${e.message}`);
          }
        },
        error: function () {
          setResponse("error", "Errore AJAX");
        },
      });
    } else {
      setResponse("info", "Operazione annullata");
    }
  });
});
