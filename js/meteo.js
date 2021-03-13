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
        icon: "favicon.png",
      });

      const markers = [
        {
          lat: 44.040824153838685,
          lon: 10.293670649480177,
          title: "Corchia",
        },
      ];
      markers.forEach(({ lat, lon, title }) => {
        new google.maps.Marker({
          position: new google.maps.LatLng(lat, lon),
          map,
          title,
          // icon: "favicon.png",
        });
      });
    });
  } else {
    alert("Localizzazione non consentita");
  }
});
