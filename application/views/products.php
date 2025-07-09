    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                "pageLength": 10,
                "order": [[0, "asc"]],
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "columns": [
                    null, // ID
                    null, // Name
                    null, // Category
                    { "type": "num-fmt" }, // Buy Price
                    { "type": "num-fmt" }, // Sell Price
                    { "type": "num" }, // Stock
                    null, // Status
                    null  // Actions
                ],
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries per page",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });
    </script> 