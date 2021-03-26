$(function () {
  // Write new board message
  $("#write").on("click", function () {
    $.ajax("ajax/board.php", {
      method: "POST",
      data: {
        action: "create",
        title: $("#title").val(),
        content: $("#content").val(),
      },
      success: (r) => {
        // console.log("response", r);
        try {
          const id = JSON.parse(r);
          if (id) {
            snackbar("Messaggio inviato", "success");
            setTimeout(() => {
              location.href = `bacheca.php?id=${id}`;
            }, 500);
          } else {
            snackbar("Errore nel database", "error");
          }
        } catch (e) {
          snackbar(`${e.name}, ${e.message}`, "error");
        }
      },

      error: () => {
        snackbar("Errore invio", "error");
      },
    });
  });

  $("#answer").on("click", function () {
    const boardId = location.search
      .substr(1)
      .split("&")
      .map((i) => i.split("="))
      .find((i) => i[0] === "id");
    //
    if (boardId && boardId.length) {
      $.ajax("ajax/board.php", {
        method: "POST",
        data: {
          action: "answer",
          content: $("#content").val(),
          boardId: boardId[1],
        },
        success: (r) => {
          // console.log("response", r);
          try {
            const id = JSON.parse(r);
            if (id) {
              snackbar("Messaggio inviato", "success");
              setTimeout(() => {
                location.href = `bacheca.php?id=${boardId}`;
              }, 500);
            } else {
              snackbar("Errore nel database", "error");
            }
          } catch (e) {
            snackbar(`${e.name}, ${e.message}`, "error");
          }
        },
        error: () => {
          snackbar("Errore invio", "error");
        },
      });
    } else {
      snackbar(`Id bacheca non valido: ${boardId}`, "error");
    }
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
