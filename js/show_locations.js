$(document).ready(function () {
  $.ajax({
    url: "../php/get_locations.php",
    type: 'GET',
    success: function (data) {
      console.log(data);
      // var locations = JSON.parse(data);
      data.forEach(function (location) {
        var shortDescription = location.description.substring(0, 100); //show only first 100 characters
        if (location.description.length > 100) {
          shortDescription += '... <a href="#" onclick="alert(\'' + $('<div/>').text(location.description).html() + '\')">Leggi tutto</a>';
        }
        var type = location.type || "non noto"; // if location.type is null, the value is set to "non noto"
        var price = location.price || "non noto";
        var photo = location.photo || "../images/location.png";
        var card = $('<div/>').addClass('col').append(
          $('<div/>').addClass('card h-100').append(
            $('<img/>').addClass('card-img-top').attr('src', photo).attr('alt', 'Foto di ' + $('<div/>').text(location.name).html()).css({
              'height': '300px',
              'object-fit': 'cover'
            }),
            $('<div/>').addClass('card-body').append(
              $('<h5/>').addClass('card-title').text(location.name).html(),
              $('<p/>').addClass('card-text').text('Indirizzo: ' + $('<div/>').text(location.address).html()),
              $('<p/>').addClass('card-text').text('Proprietario: ' + $('<div/>').text(location.owner).html()),
              $('<p/>').addClass('card-text').text('Telefono: ' + $('<div/>').text(location.phone).html()),
              $('<p/>').addClass('card-text').text('Tipo: ' + $('<div/>').text(type).html()),
              $('<p/>').addClass('card-text').html('Descrizione: ' + shortDescription),
              $('<p/>').addClass('card-text').text('Prezzo: ' + $('<div/>').text(price).html())
            ),
            $('<div/>').addClass('container card-footer bg-transparent').append(

              $('<form/>').attr('method', 'GET').append(
                $('<a/>').addClass('btn btn-primary mt-3').attr('href', '../content/booking_form.php?id=' + encodeURIComponent(location.locationid) + '&name=' + encodeURIComponent(location.name) + '&price=' + encodeURIComponent(location.price)).text('Aggiungi al carrello')
              ),

              $('<a/>').addClass('btn btn-primary mt-3').attr('href', '#').attr('data-location-id', location.locationid).text('Dettagli').css({'justify-self': 'right'}).click(function () {
                // clear old selected location from local storage
                localStorage.removeItem('selectedLocation');
                // add data of selected location to local storage
                localStorage.setItem('selectedLocation', JSON.stringify(location));
                window.location.href = '../content/location.php?locationid=' +  encodeURIComponent(location.locationid);
              })
            )
            .css(
              {
                'display': 'flex',
                'justify-content': 'space-between'
              }
            )
          )
        )
        $("#locations").append(card);
      }  
    )
  },
  error: function (error) {
    console.log('Errore:', error);
  }
});
});





     