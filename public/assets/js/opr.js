$(document).ready(function() {
    // Fetch Customer Data
    $('#phone').on('keyup', function() {
        let mobno = $(this).val();

        $.ajax({
            url: oprFetchUrl,
            type: "GET",
            data: {
                mobno: mobno
            },
            success: function(response) {
                let tableBody = $('#operatorTable tbody');
                tableBody.empty();

                if (response.success) {
                    $('#name').val(response.operator.name);
                    $('#address').val(response.operator.address);

                    tableBody.append(`
            <tr id="row-${response.operator.id}">
                <td>1</td>  <!-- Single Customer Case -->
                <td>${response.operator.name}</td>
                <td>${mobno}</td>
                <td>${response.operator.address}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-btn" 
                        data-id="${response.operator.id}" 
                        data-name="${response.operator.name}" 
                        data-mobno="${mobno}" 
                        data-address="${response.operator.address}">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${response.operator.id}">Delete</button>
                </td>
            </tr>
        `);
                } else {
                    $('#name').val('');
                    $('#address').val('');

                    if (response.operators.length > 0) {
                        let serial = 1;
                        response.operators.forEach(function(opr) {
                            tableBody.append(`
                    <tr id="row-${opr.id}">
                    <td>${serial}</td>  <!-- Proper Auto Serial Numbering -->
                        <td>${opr.name}</td>
                        <td>${opr.mobno}</td>
                        <td>${opr.address}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" 
                                data-id="${opr.id}" 
                                data-name="${opr.name}" 
                                data-mobno="${opr.mobno}" 
                                data-address="${opr.address}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${opr.id}">Delete</button>
                        </td>
                    </tr>
                `);
                serial++; // Increment serial number for each row
                        });
                    } else {
                        tableBody.append('<tr><td colspan="4" class="text-center">No Operator Data Available</td></tr>');
                    }
                }
            }
        });
    });

    // Handle Edit Button Click
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let mobno = $(this).data('mobno');
        let address = $(this).data('address');

        $('#phone').val(mobno);
        $('#name').val(name);
        $('#address').val(address);

        // Ensure the hidden input is added
        if ($('#edit-id').length === 0) {
            $('#operatorForm').append(`<input type="hidden" id="edit-id" name="id" value="${id}">`);
        } else {
            $('#edit-id').val(id);
        }

        $('.btn-primary').text('Update').attr('id', 'updateBtn');
    });

    // Handle Update Action
    $(document).on('click', '#updateBtn', function(e) {
        e.preventDefault();
        let id = $('#edit-id').val();
        let name = $('#name').val();
        let mobno = $('#phone').val();
        let address = $('#address').val();

        // Debugging: Check if ID exists
        // console.log("Updating Customer - ID:", id, "Name:", name, "MobNo:", mobno, "Address:", address);
        // alert(id); 
        $.ajax({
            url: oprUpdateUrl,
            type: "POST",
            data: {
                _token: csrfToken,
                id: id,
                name: name,
                mobno: mobno,
                address: address
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "Updated",
                        text: "Operator data has been Updated.",
                        icon: "success",
                        timer: 10000, // Auto-close after 10 seconds
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Refresh AFTER alert closes
                    });
                } else {
                    Swal.fire("Error!", "Failed to Update operator.", "error");
                }
            }
        });
    });

    // Handle Delete Button Click
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to recover this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: oprDeleteUrl,
                    type: "POST",
                    data: {
                        _token: csrfToken,
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Operator data has been removed.",
                                icon: "success",
                                timer: 10000, // Auto-close after 10 seconds
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload(); // Refresh AFTER alert closes
                            });
                        } else {
                            Swal.fire("Error!", "Failed to delete Operator.", "error");
                        }
                    }

                });
            }
        });
    });

});