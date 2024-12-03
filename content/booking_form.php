<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <?php
    include "common/common_head.php";
    ?>
    <title>Prenotazione Sala</title>
    <style>
        * {
            box-sizing: border-box;
        }

        .form-container {
            width: 90%;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            align-self: center;
        }

        .btn-container {
            width: 90%;
            align-self: center;
        }

        .input-container {
            width: 50%;
            float: left;
            padding: 30px;
        }

        .calendar-image-container {
            width: 50%;
            float: right;
        }

        .calendar-image-container img {
            width: 100%;
            height: auto;
            object-fit: contain;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Media query for small screens */
        @media (max-width: 768px) {

            .input-container,
            .calendar-image-container {
                width: 100%;
                float: none;
                /* Remove floating */
                border-top-right-radius: 0px;
                border-bottom-left-radius: 8px;
            }

            .calendar-image-container {
                order: 2;
                /* Place image after the form */
            }

            .input-container {
                order: 1;
                /* Place form before the image */
            }
        }
    </style>
</head>

<body>
    <?php
    require_once '../php/auth.php';
    include 'common/navbar.php';

    $location_id = htmlspecialchars($_GET["id"], ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
    $location_name = htmlspecialchars($_GET["name"], ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
    $price = htmlspecialchars($_GET["price"], ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
    ?>

    <h3 class="text-center" id="locationname" value="<?php echo ($location_name) ?>">Verifica la disponibilità della
        sala: <?php echo ($location_name) ?> </h3>
    <div class="form-container">
        <form method="post" id="bookingform" name="bookingform" onsubmit="return checkBeforeSubmit();">
            <div class="input-container">
                <div class="mb-3">
                    <label for="date" class="form-label">Data</label>
                    <input type="date" class="form-control" id="bookdate" name="bookdate" required>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">Ora inizio:</label>
                    <input type="time" class="form-control" id="booktime" name="booktime" required>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Durata in ore:</label>
                    <input type="number" class="form-control" id="duration" name="duration" required>
                    <input type="hidden" id="locationid" name="locationid" value="<?php echo $location_id; ?>">
                    <input type="hidden" id="price" name="price" value="<?php echo $price; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Aggiungi al carrello</button>
            </div>
        </form>

        <div class="calendar-image-container">
            <!--<img src="../images/calendar_lg.png" alt="calendar image">-->
            <div id="calendar"></div>
        </div>
    </div>

    <div class="btn-container">
        <button class="btn btn-primary" onclick="location.href='show_cart.php'">Visualizza il carrello</button>
        <button class="btn btn-primary m-3" onclick="location.href='show_locations.php'">Mostra sale</button>
    </div>

    <?php
    include 'common/footer.php';
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Fetch booking/availability data
                    fetch('../php/show_dates.php?location_id=<?= $location_id; ?>')
                        .then(response => response.json())
                        .then(data => {
                        // Map the database response to FullCalendar event format
                        const events = data.map(item => ({
                            title: 'Booked', 
                            start: item.starttime, // Use starttime from the database
                            end: item.endtime, // Use endtime from the database
                            color: 'red', 
                            allDay: false // Explicitly set to false for time-based events
                        }));
                        successCallback(events); // Pass the events to FullCalendar
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        failureCallback(error); 
                    });
                }
            });

            calendar.render();
        });
    </script>

    <script src="../js/add_to_cart.js"></script>
    <script src="../js/validate_booking_fields.js"></script>
    <script>
        function checkBeforeSubmit() {
            // Prevent from sending the form
            event.preventDefault();
            if (validate_booking_fields()) {
                addToCart();
            }
        }
    </script>



<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
  
</body>
</html>