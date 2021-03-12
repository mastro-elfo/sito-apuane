// Ottiene la lista degli utenti escluso se stesso
function get_users(onSuccess) {
  ajax("ajax/chat.php", "POST", { action: "users" }, onSuccess);
}

// Invia un messaggio al destinatario
function send(receiverId, message, onSent) {
  ajax(
    "ajax/chat.php",
    "POST",
    { action: "send", receiverId, message },
    onSent
  );
}

// Callback quando un messaggio e' stato inviato
function onSent(message) {
  let chat = document.getElementById("chat");
  let messageObj = JSON.parse(message);
  chat.appendChild(
    create_cloud(
      null,
      messageObj.own,
      messageObj.messaggio,
      messageObj.nomeMittente,
      messageObj.dataora
    )
  );
  document.getElementById("message").value = "";
  document.getElementById("message").focus();
}

// Legge i messaggi inviati o ricevuti da otherId
function read(otherId, onSuccess) {
  ajax("ajax/chat.php", "POST", { action: "read", otherId }, onSuccess);
}

// Aggiorna la lista degli utenti nel select
function update_users_select(users) {
  let usersList = JSON.parse(users);
  let select = document.getElementById("receiverId");
  usersList.forEach(function ({ id, nome }) {
    let option = document.createElement("option");
    option.value = id;
    let content = document.createTextNode(nome);
    option.appendChild(content);
    select.appendChild(option);
  });
}

// Crea una nuvoletta con il messaggio inviato o ricevuto
function create_cloud(id, own, message, senderName, datetime) {
  // Creo un nuovo li
  let li = document.createElement("li");
  // Imposto l'id del messaggio
  if (id != null) {
    li.setAttribute("data-id", id);
  }
  // Se ho inviato io questo messaggio aggiungo la classe own
  if (own) li.classList.add("own");
  // Apendo il contenuto del messaggio
  li.appendChild(document.createTextNode(message));
  // Creo un nodo footer
  let footer = document.createElement("footer");
  // Creo un nodo span per il nome del mittente
  let name = document.createElement("span");
  name.classList.add("name");
  name.appendChild(document.createTextNode(`${senderName}, `));
  // Appendo il nome al footer
  footer.appendChild(name);
  // Appendo la data e l'ora al footer
  footer.appendChild(document.createTextNode(datetime));
  // Appendo il footer
  li.appendChild(footer);
  return li;
}

// Aggiorna la lista dei messaggi
function update_chat(messages) {
  if (!messages) return;
  // console.log(messages);
  let messagesList = JSON.parse(messages);
  let chat = document.getElementById("chat");
  // Scorre la lista dei messaggi
  messagesList.forEach(function ({
    id,
    idMittente,
    dataora,
    messaggio,
    nomeMittente = "",
    own,
  }) {
    // Cerca un messaggio con attributo data-id
    if (!document.querySelector(`#chat li[data-id="${id}"]`)) {
      // Se non esiste, crea una nuova nuvoletta
      chat.appendChild(
        create_cloud(id, own == 1, messaggio, nomeMittente, dataora)
      );
    }
  });
  // Elimino i messaggi che non hanno un attributo `data-id`
  document.querySelectorAll("#chat li").forEach((item) => {
    if (!item.getAttribute("data-id")) {
      item.remove();
    }
  });
}

// Legge i messaggi dal server
function ask_server() {
  let otherId = document.getElementById("receiverId").value;
  if (otherId) {
    read(otherId, update_chat);
  }
}

// Quando e' cliccato il bottone "invia"
function click_send() {
  let otherId = document.getElementById("receiverId").value;
  let message = document.getElementById("message").value;
  if (!message.trim()) {
    return alert("Inserisci il testo del messaggio");
  }
  send(otherId, message, onSent);
}

window.addEventListener("load", function () {
  // Intercetto l'evento submit
  idListen("send", "submit", click_send);
  // Chiedo la lista utenti
  get_users(update_users_select);
  // Interrogo il server periodicamente
  let iv = setInterval(ask_server, 3000);
});
