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
});
