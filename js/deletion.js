 

$(document).ready(function() {
    $('.generic-delete-btn').on('click', function(e) {
        e.preventDefault();

        var itemId = $(this).data('id');
        var table = $(this).data('table');
        var rowToRemove = $(this).closest('tr');

        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: 'generic_delete.php', 
                type: 'POST',
                data: { id: itemId, table: table },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        rowToRemove.remove();
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error deleting item.');
                }
            });
        }
    });
})
