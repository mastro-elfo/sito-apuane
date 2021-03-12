function ajax(
  endpoint,
  method,
  data,
  onSuccess = (m) => {
    console.log(m);
  },
  onError = (m) => {
    console.error(m);
  },
  onStateChange = (m) => {
    // console.log(m);
  }
) {
  // Creo l'oggetto XMLHttpRequest
  let xhttp = new XMLHttpRequest();
  // Imposto l'evento "onreadystatechange"
  xhttp.onreadystatechange = function () {
    onStateChange(this);
    if (this.readyState === 4) {
      if (this.status === 200) {
        try {
          onSuccess(this.responseText);
        } catch (e) {
          onError(e);
        }
      } else {
        onError(this.status);
      }
    }
  };
  // Open
  xhttp.open(method, endpoint, true);
  // Imposto l'header per inviare dati col metodo POST
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  // Codifico parametri
  let encoded = Object.entries(data)
    .map(([key, value]) => `${key}=${encodeURIComponent(value)}`)
    .join("&");
  // Invio la richiesta
  try {
    xhttp.send(encoded);
  } catch (e) {
    console.error(e.name, e.message, e);
  }
}
