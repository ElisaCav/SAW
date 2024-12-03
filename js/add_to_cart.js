/* 
If the location is available, it's added to the cart in the local storage.
*/

function addToCart() {

    // Get the cart from Local Storage
    var cart = JSON.parse(localStorage.getItem('cart')) || [];

    console.log("LOCAL STORAGE:" + localStorage.getItem('cart'));

    var locTime = $('#booktime').val();
    var locDate = $('#bookdate').val();
    var price = $('#price').val();
    var placeName = $('#locationname').text().split(':')[1].trim();;

    console.log(placeName);
    // Add second if not set
    if (locTime.length === 5) {
        locTime += ':00';
    }
    // create string for datetime
    var locDateTime = locDate + ' ' + locTime;
    locDateTime = locDateTime.replace('+', ' ');
    console.log("datetime costruito: " + locDateTime);

    var booking = {
        place: $('#locationid').val(),
        bookdatetime: locDateTime,
        duration: $('#duration').val(),
        totalprice: price,
        locationname: placeName
    };

    //check if element is already saved in the local storage:
    for (var i = 0; i < cart.length; i++) {
        if (cart[i].place === booking.place && cart[i].bookdatetime === booking.bookdatetime) {
            alert("Elemento già presente nel tuo carrello");
            return;
        }
    }

    // Add a booking to the cart (local storage) after checking availability on server database
    fetch('../php/book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'check',
            place: booking.place,
            bookdatetime: booking.bookdatetime,
            duration: booking.duration,
            price: booking.totalprice,
            locationname: booking.locationname
        })
    })
        .then(response => response.text())
        .then(text => {
            console.log("RAW response text: " + text);
            return JSON.parse(text);  
        }) 
        .then(data => {
            console.log("ROW data: " + JSON.stringify(data));
            var res = data;
            console.log(res);
            if (res.available) {
                // If the room is available, add the booking to the cart
                cart.push(booking);

                // Save the cart in Local Storage
                localStorage.setItem('cart', JSON.stringify(cart));

                alert("La tua prenotazione è stata aggiunta al carrello. Vai al carrello per visualizzare le tue prenotazioni e procedere");

            } else {
                alert("Lo spazio non è disponibile nella data e ora richieste");
            }
        })
        .catch(error => {
            alert("Errore durante la prenotazione: " + error);
        });

}

