<?php
session_start();
require_once('../php/auth.php');
denyUnauthenticatedAccess($con);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/booking_history.log');
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <?php
    include "common/common_head.php";
    ?>
    <title>Archive</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        table.dataTable tbody td {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    include 'common/navbar.php';
    ?>

    <div class="container mt-3">
        <div class="table-responsive">
            <table id="booking" name="booking" class="display">
                <thead>
                    <tr>
                        <th>Id prenotazione</th>
                        <th>Luogo</th>
                        <th>Data inizio</th>
                        <th>Data fine</th>
                        <th>Durata</th>
                        <th>Data prenotazione</th>
                        <th>Stato prenotazione</th>
                        <th>Prezzo totale</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'common/footer.php'; ?>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '../php/get_bookings.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Populate table with data
                    var table = $('#booking').DataTable({searching: false,

                        data: data,
                        columns: [{
                            data: 'bookingid'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'starttime'
                        },
                        {
                            data: 'endtime'
                        },
                        {
                            data: 'duration'
                        },
                        {
                            data: 'requesttime'
                        },
                        {
                            data: 'cancellation',
                            render: function (data, type, row) {
                                    if (data === 0) {
                                        return '<span> confermata &#10004;</span>';  //tick
                                    } else if (data === 1) {
                                        return '<span">annullata &#10060;</span>'; //cross
                                    } else {
                                        return ''; // Empty if data is invalid
                                    }
                                }
                        },
                        {
                            data: 'totalprice'
                        }
                        ],
                        responsive: true,
                    });
                },
                error: function (xhr, status, error) {
                    console.log('Error fetching data:', error);
                }
            });
        });
    </script>
</body>

</html>

<?php
