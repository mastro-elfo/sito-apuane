// Gestisco la chiamata AJAX per effettuare il login
function login(username, password, onLogin, onError) {
  // Creo l'oggetto XMLHttpRequest
  let xhttp = new XMLHttpRequest();
  // Imposto l'evento "onreadystatechange"
  xhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);
      // Controllo la risposta
      if (response) {
        // Chiamo la funzione `onLogin`
        onLogin(response);
      } else {
        // Chiamo la funzione `onError`
        onError();
      }
    }
    // Cosa succede se non arrivo a readyState === 4 e status === 200?
  };
  // Open
  xhttp.open("POST", "ajax/login.php", true);
  // Imposto l'header per inviare dati col metodo POST
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  // Invio la richiesta
  xhttp.send(`action=login&username=${username}&password=${password}`);
}

// Chiamo questa funzione quando il login e' stato effettuato con successo
function loginSuccess(response) {
  feedback(null, "Login effettuato");
  // Imposto il cookie per ricordare chi sono
  setCookie("myid", response.id, 1);
  location.href = "./";
}

// Chiamo questa funzione quando c'e' un errore di login
function loginError(response) {
  feedback(null, null, "Errore durante il login");
}

window.addEventListener("load", function () {
  // Prendo il tag `form`
  let form = document.getElementById("login");
  // Intercetto l'evento `submit`
  form.addEventListener("submit", function (event) {
    event.preventDefault();
    // Scrivo il feedback per l'utente
    feedback("Effettuo il login...");
    // Faccio la richiesta AJAX
    login(
      document.getElementById("username").value,
      document.getElementById("password").value,
      loginSuccess,
      loginError
    );
  });
});

// Scrivo il feedback per l'utente
function feedback(info, success, error) {
  displayFeedback(document.getElementById("info"), info);
  displayFeedback(document.getElementById("success"), success);
  displayFeedback(document.getElementById("error"), error);
}

function displayFeedback(container, text) {
  if (text) {
    container.innerHTML = text;
  } else {
    container.innerHTML = "";
  }
}
