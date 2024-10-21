</div>
<!-- end container -->
</section>
<!-- ========== section end ========== -->
<!-- ========== footer start =========== -->
<footer class="footer">
    <div class="container-fluid">
    </div>
    <!-- end container -->
</footer>
<!-- ========== footer end =========== -->
</main>
<!-- ======== main-wrapper end =========== -->
<!-- ========= All Javascript files linkup ======== -->
<script src="./assets/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/Chart.min.js"></script>
<script src="./assets/js/dynamic-pie-chart.js"></script>
<script src="./assets/js/moment.min.js"></script>
<script src="./assets/js/fullcalendar.js"></script>
<script src="./assets/js/jvectormap.min.js"></script>
<script src="./assets/js/world-merc.js"></script>
<script src="./assets/js/polyfill.js"></script>
<script src="./assets/js/main.js"></script>
<script src="./assets/js/jquery/jquery.min.js" ></script>
<script type="text/javascript" src="./lib/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="./lib/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    $('#mySelect2').select2({
        selectOnClose: false
    });
    // ======== jvectormap activation
    var markers = [{
            name: "Egypt",
            coords: [26.8206, 30.8025]
        },
        {
            name: "Russia",
            coords: [61.524, 105.3188]
        },
        {
            name: "Canada",
            coords: [56.1304, -106.3468]
        },
        {
            name: "Greenland",
            coords: [71.7069, -42.6043]
        },
        {
            name: "Brazil",
            coords: [-14.235, -51.9253]
        },
    ];

    var jvm = new jsVectorMap({
        map: "world_merc",
        selector: "#map",
        zoomButtons: true,

        regionStyle: {
            initial: {
                fill: "#d1d5db",
            },
        },

        labels: {
            markers: {
                render: (marker) => marker.name,
            },
        },

        markersSelectable: true,
        selectedMarkers: markers.map((marker, index) => {
            var name = marker.name;

            if (name === "Russia" || name === "Brazil") {
                return index;
            }
        }),
        markers: markers,
        markerStyle: {
            initial: {
                fill: "#4A6CF7"
            },
            selected: {
                fill: "#ff5050"
            },
        },
        markerLabelStyle: {
            initial: {
                fontWeight: 400,
                fontSize: 14,
            },
        },
    });
    // ====== calendar activation
    document.addEventListener("DOMContentLoaded", function() {
        var calendarMiniEl = document.getElementById("calendar-mini");
        var calendarMini = new FullCalendar.Calendar(calendarMiniEl, {
            initialView: "dayGridMonth",
            headerToolbar: {
                end: "today prev,next",
            },
        });
        calendarMini.render();
    });


    // ================== chart four start
    // const ctx4 = document.getElementById("Chart4").getContext("2d");
    // const chart4 = new Chart(ctx4, {
    //     type: "bar",
    //     data: {
    //         labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
    //         datasets: [{
    //                 label: "",
    //                 backgroundColor: "#365CF5",
    //                 borderColor: "transparent",
    //                 borderRadius: 20,
    //                 borderWidth: 5,
    //                 barThickness: 20,
    //                 maxBarThickness: 20,
    //                 data: [600, 700, 1000, 700, 650, 800],
    //             },
    //             {
    //                 label: "",
    //                 backgroundColor: "#d50100",
    //                 borderColor: "transparent",
    //                 borderRadius: 20,
    //                 borderWidth: 5,
    //                 barThickness: 20,
    //                 maxBarThickness: 20,
    //                 data: [690, 740, 720, 1120, 876, 900],
    //             },
    //         ],
    //     },
    //     options: {
    //         plugins: {
    //             tooltip: {
    //                 backgroundColor: "#F3F6F8",
    //                 titleColor: "#8F92A1",
    //                 titleFontSize: 12,
    //                 bodyColor: "#171717",
    //                 bodyFont: {
    //                     weight: "bold",
    //                     size: 16,
    //                 },
    //                 multiKeyBackground: "transparent",
    //                 displayColors: false,
    //                 padding: {
    //                     x: 30,
    //                     y: 10,
    //                 },
    //                 bodyAlign: "center",
    //                 titleAlign: "center",
    //                 enabled: true,
    //             },
    //             legend: {
    //                 display: false,
    //             },
    //         },
    //         layout: {
    //             padding: {
    //                 top: 0,
    //             },
    //         },
    //         responsive: true,
    //         // maintainAspectRatio: false,
    //         title: {
    //             display: false,
    //         },
    //         scales: {
    //             y: {
    //                 grid: {
    //                     display: false,
    //                     drawTicks: false,
    //                     drawBorder: false,
    //                 },
    //                 ticks: {
    //                     padding: 35,
    //                     max: 1200,
    //                     min: 0,
    //                 },
    //             },
    //             x: {
    //                 grid: {
    //                     display: false,
    //                     drawBorder: false,
    //                     color: "rgba(143, 146, 161, .1)",
    //                     zeroLineColor: "rgba(143, 146, 161, .1)",
    //                 },
    //                 ticks: {
    //                     padding: 20,
    //                 },
    //             },
    //         },
    //     },
    // });
    // =========== chart four end
</script>
</body>

</html>