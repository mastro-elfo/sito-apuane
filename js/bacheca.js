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
  });
});

$(function () {
  const response = $("#answer-response");

  function setResponse(severity, text) {
    response.text(text);
    // Remove all classes
    response.removeClass();
    response.addClass(severity);
  }

  const dialog = $("#dialog-answer").dialog({
    autoOpen: false,
    modal: true,
    width: "90%",
    buttons: {
      Conferma: () => {
        setResponse("info", "Invio risposta...");
        //
        const id = location.search
          .substr(1)
          .split("&")
          .map((i) => i.split("="))
          .find((i) => i[0] === "id");
        //
        if (id && id.length) {
          $.ajax("ajax/board.php", {
            method: "POST",
            data: {
              action: "answer",
              content: $("#answer-text").val(),
              boardId: id[1],
            },
            success: (r) => {
              console.log("response", r);
              try {
                const id = JSON.parse(r);
                if (id) {
                  setResponse("success", "Messaggio inviato");
                  setTimeout(() => {
                    location.reload();
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
        }
      },
      Annulla: () => {
        dialog.dialog("close");
      },
    },
  });

  $("#answer-button").on("click", function () {
    dialog.dialog("open");
  });

  $("[data-delete-board]").on("click", function (e) {
    // console.log(e.currentTarget.getAttribute("data-delete-board"));
    if (
      confirm(
        "Sei sicuro di voler eliminare questo post?\n\nUna volta eliminato non sarà più visibile e non sarà possibile ripristinarlo.\n\nConfermi?"
      )
    ) {
      $.ajax("ajax/board.php", {
        method: "POST",
        data: {
          action: "delete-board",
          boardId: e.currentTarget.getAttribute("data-delete-board"),
        },
        success: (r) => {
          location.href = "bacheca.php";
        },
        error: (r) => {
          console.error(r);
        },
      });
    }
  });

  $("[data-delete-answer]").on("click", function (e) {
    // console.log(e.currentTarget.getAttribute("data-delete-board"));
    if (
      confirm(
        "Sei sicuro di voler eliminare questa risposta?\n\nUna volta eliminata non sarà più visibile e non sarà possibile ripristinarla.\n\nConfermi?"
      )
    ) {
      $.ajax("ajax/board.php", {
        method: "POST",
        data: {
          action: "delete-answer",
          answerId: e.currentTarget.getAttribute("data-delete-answer"),
        },
        success: (r) => {
          console.log(r);
          location.reload();
        },
        error: (r) => {
          console.error(r);
        },
      });
    }
  });
});
