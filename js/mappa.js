$(function () {
  let map = null;

  // Ask geolocation permission
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position) => {
      const {
        coords: { latitude, longitude },
      } = position;
      const point = new google.maps.LatLng(latitude, longitude);
      const center = new google.maps.LatLng(
        44.07868721388755,
        10.280850401209221
      );
      map = new google.maps.Map(document.getElementById("map-container"), {
        zoom: 11,
        center,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      });

      // Posizione utente
      new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map,
        title: `Lat: ${latitude.toFixed(2)}°, Lon: ${longitude.toFixed(2)}°`,
      });

      const ICONS = {
        Arte: "imgs/art.svg",
        Castello: "imgs/castello.svg",
        Culto: "imgs/culto.svg",
        Grotta: "imgs/grotta.svg",
        Località: "imgs/localita.svg",
        Marker: "imgs/marker.svg",
        Natura: "imgs/natura.svg",
        Rifugio: "imgs/rifugio.svg",
        Vetta: "imgs/vetta.svg",
      };

      markers.forEach(({ name, latitudine, longitudine, tag }) => {
        new google.maps.Marker({
          position: new google.maps.LatLng(latitudine, longitudine),
          map,
          title: name,
          icon: ICONS[tag] || ICONS["Marker"],
        });
      });
    });
  } else {
    alert("Localizzazione non consentita");
  }

  $("#center").on("click", function () {
    if (map) {
      // console.log(map);
      map.setCenter(
        new google.maps.LatLng(44.07868721388755, 10.280850401209221)
      );
      map.setZoom(11);
    }
  });
});
