function load(method, endpoint, callbacks = {}) {
  xhttp = new XMLHttpRequest();
  xhttp = onreadystatechange = function () {
    callbacks.statechange && callbacks.statechange();
    if (this.readyState === 4 && this.status === 200) {
      // Success
      callbacks.success && callbacks.success(this.responseText);
    }
  };
  xhttp.open(method, endpoint, true);
  xhttp.send();
}
