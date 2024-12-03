function validate_booking_fields() {
    const bookDateInput = document.getElementById('bookdate');
    const bookTimeInput = document.getElementById('booktime');
    const durationInput = document.getElementById('duration');
    
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1); // Sottrae un giorno dalla data attuale
    
    bookDateInput.setAttribute('min', yesterday.toISOString().split('T')[0]);
    
    const maxDate = '2026-12-31';
    bookDateInput.setAttribute('max', maxDate);
    
    bookTimeInput.setAttribute('step', '3600');
    
    durationInput.setAttribute('min', '1');
    durationInput.setAttribute('max', '12');

    const selectedDate = new Date(bookDateInput.value);
    selectedDate.setHours(0,0,0,0);
    const now = new Date();
    now.setHours(0, 0, 0, 0);
    const selectedDuration = parseInt(durationInput.value, 10);

    console.log("Selected Date:", selectedDate);
    console.log("Current Date:", now);

    if (selectedDate < now) {
        alert('La data non può essere nel passato.');
        console.log("La data non può essere nel passato.");
        return false;
    }

    if (selectedDate > new Date(2026, 11, 31)) {
        alert('La data deve essere entro il 2026.');
        console.log("La data deve essere entro il 2026.");
        return false;
    }

    const selectedTime = new Date(bookDateInput.value);
        // Estraiamo ore e minuti da bookTimeInput
    const [hours, minutes] = bookTimeInput.value.split(':').map(Number);

    // Impostiamo le ore e i minuti sulla data selezionata
    selectedTime.setHours(hours);
    selectedTime.setMinutes(minutes);
    const currentTime = new Date();
    //const selectedTime.setHours(${bookTimeInput.value});

    console.log("Selected Time:", selectedTime);
    console.log("Current Time:", currentTime);

    if (selectedTime < currentTime) {
        alert('L\'ora non può essere nel passato.');
        console.log("L'ora non può essere nel passato.");
        return false;
    }

    console.log("Selected Duration:", selectedDuration);

    if (isNaN(selectedDuration) || selectedDuration < 1 || selectedDuration > 12) {
        alert('La durata deve essere tra 1 e 12 ore');
        console.log("La durata deve essere tra 1 e 12 ore.");
        return false;
    }

    return true;
}

