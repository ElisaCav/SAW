document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cartItems');
    const template = document.getElementById('cardTemplate');
    let totalPrice = 0;

    cart.forEach((item, index) => {
        const clone = template.cloneNode(true);
        clone.style.display = 'block';
        clone.classList.remove('d-none');

        // attributes needed for finding data in the DOM
        clone.setAttribute('cart-item-location', item.place);
        const [cartDate, cartTime] = item.bookdatetime.split(" ");
        clone.setAttribute('cart-item-date', cartDate);
        clone.setAttribute('cart-item-time', cartTime);
        clone.setAttribute('cart-item-duration', item.duration);
        clone.setAttribute('cart-item-price', item.totalprice);

        const cardBody = clone.querySelector('.card-body');
        const cardTitle = cardBody.querySelector('.card-title');

        const price = Number(item.totalprice);
        const duration = Number(item.duration);
        const itemTotalPrice = price * duration;
        totalPrice += itemTotalPrice;

        const cardText = cardBody.querySelector('.card-text');
        cardText.querySelector('.cart-item-location').textContent = item.locationname;
        cardText.querySelector('.cart-item-date').textContent = cartDate;
        cardText.querySelector('.cart-item-time').textContent = cartTime;
        cardText.querySelector('.cart-item-duration').textContent = item.duration;
        cardText.querySelector('.cart-item-total-price').textContent = itemTotalPrice.toFixed(2);

        const buyBtn = clone.querySelector("#buyBtn");
        const removeBtn = clone.querySelector("#removeBtn");

        cartItemsContainer.appendChild(clone);

        // Eventi per i pulsanti di acquisto e rimozione
        buyBtn.addEventListener('click', () => 
            {   const confirmPurchase = window.confirm('Sei sicuro di voler acquistare la prenotazione per ' + item.locationname + ' il giorno ' + cartDate + ' alle ore ' + cartTime + '?');
                if (confirmPurchase) { 
                    buy(item.place, item.locationname, item.bookdatetime, item.duration, itemTotalPrice);
                }
            });
        removeBtn.addEventListener('click', () => 
            {   const confirmRemove = window.confirm('Sei sicuro di voler rimuovere l\'elemento dal carrello?');
                if (confirmRemove) {
                    removeFromCart(item.place, item.bookdatetime);
                }
            
            });
        


        });
        if (cart.length === 0) {
            displayEmptyCartMessage();
            hideCartButtons();
        } else {
            showCartButtons(totalPrice);
        }
    });

// Funzione per acquistare un singolo articolo
function buy(cartLocation, cartLocationName, cartDateTime, cartDuration, cartTotalPrice) {
    console.log(`Buying: ${cartLocation}, ${cartDateTime}, ${cartDuration}, ${cartTotalPrice}`);
    $.ajax({
        url: '../php/book.php',
        type: 'POST',
        contentType: "application/json",
        data: JSON.stringify({
            action: 'buy',
            place: cartLocation,
            bookdatetime: cartDateTime,
            duration: cartDuration,
            totalprice: cartTotalPrice
        }),
        dataType: "json",
        success: function(response) {
            if (response) {
                const data = response;
                console.log(data);
                if (data.status === 'success' && data.message === cartLocation) {
                    alert(`La prenotazione per la sala ${cartLocationName} è stata effettuata con successo.`);
                    removeFromCart(cartLocation, cartDateTime);
                    subtractFromTotal(cartTotalPrice);
                } else {
                    alert(`Prenotazione non confermata: ${data.message}`);
                }
            }
        },
        error: function(xhr) {
            alert("Si è verificato un errore durante la prenotazione: " + xhr.responseText.trim());
        }
    });
}

// Funzione per comprare tutti gli articoli
function buyAll(cart) {
    $.ajax({
        url: '../php/book.php',
        type: 'POST',
        contentType: "application/json",
        data: JSON.stringify({
            action: 'buyAll',
            cart: JSON.stringify(cart)
        }),
        dataType: 'json',
        success: function(response) {
            const successMessages = [];

            if (Array.isArray(response)) {
                response.forEach((item, index) => {
                    const cartItem = cart[index];
                    if (item.status === 'success' && item.message === cartItem.place) {
                        successMessages.push(`La prenotazione per la sala:  ${cartItem.locationname} è stata effettuata con successo.`);
                        removeFromCart(cartItem.place, cartItem.bookdatetime);
                    } else {
                        alert(`La prenotazione per la sala:  ${cartItem.locationname} è fallita: ${item.message}`);
                    }
                });

                if (successMessages.length > 0) {
                    alert(successMessages.join("\n"));
                }
            } else {
                console.log("Formato risposta inatteso: ", response);
            }
        },
        error: function(xhr) {
            alert("Si è verificato un errore durante la prenotazione: " + xhr.responseText.trim());
        }
    });
}

// Funzione per rimuovere un articolo dal carrello
function removeFromCart(cartLocation, cartDateTime) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const index = cart.findIndex(item => item.place === cartLocation && item.bookdatetime === cartDateTime);
    console.log("index=" + index + " , item location = " + cartLocation);
    if (index !== -1) {
        const itemTotalPrice = cart[index].totalprice * cart[index].duration;
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        removeCartItemFromDOM(cartLocation, cartDateTime);
        subtractFromTotal(itemTotalPrice);

        if (cart.length === 0) {
            hideCartButtons();
            displayEmptyCartMessage();
        }
    }
}

function removeCartItemFromDOM(cartLocation, cartDateTime) {
    const [cartDate, cartTime] = cartDateTime.split(" ");
    const card = document.querySelector(`[cart-item-location="${cartLocation}"][cart-item-date="${cartDate}"][cart-item-time="${cartTime}"]`);
    console.log(card);
    if (card) card.remove();
}

function subtractFromTotal(itemPrice) {
    const totalPriceElement = document.getElementById("show-total");
    const currentTotal = parseFloat(totalPriceElement.querySelector('#total-price').innerHTML);
    const newTotal = currentTotal - itemPrice;

    if (newTotal > 0) {
        totalPriceElement.querySelector('#total-price').innerHTML = newTotal.toFixed(2);
    } else {
        totalPriceElement.style.display = 'none';
    }
}

// Funzione per svuotare il carrello
function emptyCart() {
    localStorage.removeItem('cart');
    document.querySelectorAll('.card').forEach(card => card.remove());
    hideCartButtons();
    displayEmptyCartMessage();
}


function displayEmptyCartMessage() {
    const cartItemsContainer=document.getElementById("cartItems");
    const p = document.createElement('p');
    p.textContent = "Il carrello è vuoto.";
    cartItemsContainer.append(p);
}

function hideCartButtons() {
    const buyAllBtn = document.getElementById("buyAllBtn");
    const emptyCartBtn = document.getElementById("emptyCartBtn");
    const showTotal = document.getElementById("show-total");
    if (buyAllBtn) buyAllBtn.style.display = "none";
    emptyCartBtn.style.display = "none";
    showTotal.style.display = "none";
}

function showCartButtons(totalPrice) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const buyAllBtn = document.getElementById("buyAllBtn");
    const emptyCartBtn = document.getElementById("emptyCartBtn");
    const showTotal = document.getElementById("show-total");
    emptyCartBtn.style.display = 'block';
    emptyCartBtn.addEventListener('click', emptyCart);

    if (buyAllBtn) {
        buyAllBtn.style.display = 'block';
        buyAllBtn.addEventListener('click', () =>{
            const confirmPurchaseAll = window.confirm('Sei sicuro di voler acquistare tutto il carrello?');
            if (confirmPurchaseAll) {
                buyAll(cart);
            }
        });
    }

    if (showTotal) {
        showTotal.style.display = 'block';
        showTotal.querySelector('#total-price').innerHTML = totalPrice.toFixed(2);
    }
}


