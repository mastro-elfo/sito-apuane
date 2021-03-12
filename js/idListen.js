function idListen(id, event, callback, ...params) {
  let element = document.getElementById(id);
  if (element) {
    element.addEventListener(event, function (e) {
      e.preventDefault();
      callback(...params);
    });
  }
}
