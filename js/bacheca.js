$(function () {
  const response = $("#response");

  function setResponse(severity, text) {
    response.text(text);
    // Remove all classes
    response.removeClass();
    response.addClass(severity);
  }

  const dialog = $("#dialog-new").dialog({
    autoOpen: false,
    modal: true,
    width: "90%",
    buttons: {
      Conferma: () => {
        setResponse("info", "Invio messaggio...");
        // alert("Conferma");
        $.ajax("ajax/board.php", {
          method: "POST",
          data: {
            action: "create",
            title: $("#title").val(),
            content: $("#content").val(),
          },
          success: (r) => {
            console.log("response", r);
            try {
              const id = JSON.parse(r);
              if (id) {
                setResponse("success", "Messaggio inviato");
                setTimeout(() => {
                  location.href = `bacheca.php?id=${id}`;
                }, 500);
              } else {
                setResponse("error", "Errore nel database");
              }
            } catch (e) {
              setResponse("error", `${e.name}, ${e.message}`);
            }
          },

          error: () => {
            setResponse("error", "Errore invio");
          },
        });
      },
      Annulla: () => {
        // alert("Annulla");
        dialog.dialog("close");
      },
    },
  });

  $("#write").on("click", function () {
    dialog.dialog("open");
    // alert("Work in progress");
  });

  $("#answer").on("click", function () {
    alert("Work in progress");
  });
});
