$(function () {
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
      const map = new google.maps.Map(
        document.getElementById("map-container"),
        {
          zoom: 10,
          center,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
        }
      );

      // Posizione utente
      new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map,
        title: `Lat: ${latitude.toFixed(2)}°, Lon: ${longitude.toFixed(2)}°`,
      });

      const ICONS = {
        Castello: "https://localhost/Master/sito-apuane/imgs/castello.svg",
        Culto: "https://localhost/Master/sito-apuane/imgs/culto.svg",
        Grotta: "https://localhost/Master/sito-apuane/imgs/grotta.svg",
        Località: "https://localhost/Master/sito-apuane/imgs/localita.svg",
        Natura: "https://localhost/Master/sito-apuane/imgs/natura.svg",
        Rifugio: "https://localhost/Master/sito-apuane/imgs/rifugio.svg",
        Vetta: "https://localhost/Master/sito-apuane/imgs/vetta.svg",
      };

      markers.forEach(({ name, latitudine, longitudine, tag }) => {
        new google.maps.Marker({
          position: new google.maps.LatLng(latitudine, longitudine),
          map,
          title: name,
          icon: ICONS[tag] || null,
        });
      });
    });
  } else {
    alert("Localizzazione non consentita");
  }
});
