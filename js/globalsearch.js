$('#searchForm').on('submit', function(event) {
    event.preventDefault(); 

    var searchQuery = $('#searchInput').val();
    var url = "../php/searchfunction.php";

    //jQuery's $.post method to send the request
    $.post(url, { query: searchQuery })
        .done(function(data) {
            var mappedData = data.map(function(item) {
                return [
                    item.name,
                    item.address,
                    item.owner,
                    item.phone,
                    item.capacity,
                    item.type,
                    item.price
                ];
            });

            console.log(mappedData);

            // update the DataTable with the search results
            var table = $('#location').DataTable();
            table.clear(); // clear the existing data
            table.rows.add(mappedData); // add new data
            table.draw(); // redraw the DataTable
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Request failed: " + textStatus + ", " + errorThrown);
        });
});
