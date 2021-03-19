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
        Castello: "http://maps.google.com/mapfiles/kml/shapes/schools.png",
        Culto: "http://maps.google.com/mapfiles/kml/shapes/church.png",
        Grotta: "http://maps.google.com/mapfiles/kml/shapes/shaded_dot.png",
        Località: "http://maps.google.com/mapfiles/kml/shapes/realestate.png",
        Natura: "http://maps.google.com/mapfiles/kml/shapes/parks.png",
        Rifugio:
          "http://maps.google.com/mapfiles/kml/shapes/homegardenbusiness.png",
        Vetta: "http://maps.google.com/mapfiles/kml/shapes/mountains.png",
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
