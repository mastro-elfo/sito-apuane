window.addEventListener("load", function () {
  idListen(
    "logout",
    "click",
    ajax,
    "ajax/login.php",
    "POST",
    { action: "logout" },
    function (ret) {
      // console.log(ret);
      location.href = "./";
    },
    function (e) {
      console.error(e);
    }
  );

  idListen("save", "click", function () {
    ajax(
      "ajax/profilo.php",
      "POST",
      {
        action: "update",
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
      },
      function (data) {
        try {
          let user = JSON.parse(data);
          document.getElementById("header-user-name").innerHTML = user.nome;
          console.log("Update success");
        } catch {
          console.error("Update error");
        }
      },
      function () {
        console.error("Update failed");
      }
    );
  });
});
