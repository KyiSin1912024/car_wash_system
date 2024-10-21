<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables Example</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="./lib/DataTables/datatables.min.css"/>
    <!-- DataTables JS -->
    <script type="text/javascript" src="./lib/DataTables/datatables.min.js"></script>
    <!-- <script type="text/javascript" src="./lib/DataTables/js/dataTables.bootstrap5.min.js"></script> -->
</head>
<body>
    <div class="container">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <!-- Your data goes here -->
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>
</body>
</html>
