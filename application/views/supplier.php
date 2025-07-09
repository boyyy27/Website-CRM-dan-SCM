    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hapus konfigurasi DataTables
        $(document).ready(function() {
            // Fungsi untuk menampilkan modal edit
            window.showEditModal = function(id, nama, alamat, telepon) {
                $('#edit_id').val(id);
                $('#edit_nama').val(nama);
                $('#edit_alamat').val(alamat);
                $('#edit_telepon').val(telepon);
                $('#editModal').modal('show');
            }

            // Fungsi untuk menampilkan modal hapus
            window.showDeleteModal = function(id, nama) {
                $('#delete_id').val(id);
                $('#delete_nama').text(nama);
                $('#deleteModal').modal('show');
            }
        });
    </script>
</body>
</html> 