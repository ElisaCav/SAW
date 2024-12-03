
function addRow(key, value, tableBody) {
    const row = document.createElement('tr');
    const keyCell = document.createElement('td');
    const valueCell = document.createElement('td');
    
    keyCell.textContent = key;
    row.appendChild(keyCell);

    if (value === null || value === undefined) value = 'Non noto';
  
    if (key === 'Impianto Audio' || key === 'Servizio Catering' || key === 'Disponibile') {
      valueCell.textContent = (value === 1 || value === true) ? 'sì' : 'no';
    } else {
      valueCell.textContent = value;
    }
  
    row.appendChild(valueCell);
    tableBody.appendChild(row);
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    const location = JSON.parse(localStorage.getItem('selectedLocation'));
  
    if (!location) {
      console.log('Location details not found in localStorage');
      return;
    }
  
    const locationImage = document.getElementById('location-image');
    locationImage.src = location.photo ?? '../images/location.png';
  
    const tableBody = document.querySelector('#location-table tbody');
    tableBody.innerHTML = '';
  
    const keysToRemove = ['photo', 'locationid'];
    const filteredLocation = {};
    
    for (const key in location) {
      if (!keysToRemove.includes(key)) {
        filteredLocation[key] = location[key];
      }
    }
  
    const keyMap = {
      name: 'Nome',
      address: 'Indirizzo',
      owner: 'Proprietario',
      phone: 'Telefono',
      capacity: 'Capienza sala',
      audio: 'Impianto Audio',
      catering: 'Servizio Catering',
      price: 'Tariffa oraria',
      type: 'Tipo',
      availability: 'Disponibile'
    };
  
    for (const key in filteredLocation) {
      if (key in keyMap) {
        addRow(keyMap[key], filteredLocation[key], tableBody);
      }
    }
  });