$(document).ready(function() {
    // Fetch Customer Data
    $('#VehiNo').on('keyup', function() {
        let vehino = $(this).val();

        $.ajax({
            url: vehiFetchUrl,
            type: "GET",
            data: {
                vehino: vehino
            },
            success: function(response) {
                let tableBody = $('#vehicleTable tbody');
                tableBody.empty();

                if (response.success) {

                    $('#Vehiname').val(response.vehicle.VehiName);

                    tableBody.append(`
            <tr id="row-${response.vehicle.id}">
                <td>1</td>  <!-- Single Customer Case -->
                <td>${vehino}</td>
                <td>${response.vehicle.VehiName}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-btn" 
                        data-id="${response.vehicle.id}" 
                        data-vehiid="${vehino}" 
                        data-vehiname="${response.vehicle.VehiName}">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${response.vehicle.id}">Delete</button>
                </td>
            </tr>
        `);
                } else {
                    $('#Vehiname').val('');
                    if (response.vehicles.length > 0) {
                        let serial = 1; // Start serial numbering from 1
                        response.vehicles.forEach(function(vehi) {
                            tableBody.append(`
                    <tr id="row-${vehi.id}">
                        <td>${serial}</td>  <!-- Proper Auto Serial Numbering -->
                       <td>${vehi.VehiID}</td>
                       <td>${vehi.VehiName}</td>
                            
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" 
                                data-id="${vehi.id}" 
                                data-vehiid="${vehi.VehiID}" 
                                data-vehiname="${vehi.VehiName}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${vehi.id}">Delete</button>
                        </td>
                    </tr>
                `);
                            serial++; // Increment serial number for each row
                        });
                    } else {
                        tableBody.append('<tr><td colspan="4" class="text-center">No Vehicle Data Available</td></tr>');
                    }
                }
            }
        });
    });

    // Handle Edit Button Click
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        let vehino = $(this).data('vehiid');
        let vehiname = $(this).data('vehiname');

        // alert(vehino);

        $('#VehiNo').val(vehino);
        $('#Vehiname').val(vehiname);

        // Ensure the hidden input is added
        if ($('#edit-id').length === 0) {
            $('#VehicleForm').append(`<input type="hidden" id="edit-id" name="id" value="${id}">`);
        } else {
            $('#edit-id').val(id);
        }

        $('.btn-primary').text('Update').attr('id', 'updateBtn');
    });

    // Handle Update Action
    $(document).on('click', '#updateBtn', function(e) {
        e.preventDefault();
        let id = $('#edit-id').val();
        let vehiid = $('#VehiNo').val();
        let vehiname = $('#Vehiname').val();


        // Debugging: Check if ID exists
        // console.log("Updating Customer - ID:", id, "Name:", name, "MobNo:", mobno, "Address:", address);
        // alert(id); 
        $.ajax({
            url: vehiUpdateUrl,
            type: "POST",
            data: {
                _token: csrfToken,
                id: id,
                vehiid: vehiid,
                vehiname: vehiname
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "Updated",
                        text: "Vehicle data has been Updated.",
                        icon: "success",
                        timer: 10000, // Auto-close after 10 seconds
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Refresh AFTER alert closes
                    });
                } else {
                    Swal.fire("Error!", "Failed to Update Vehicle.", "error");
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
                    url: vehiDeleteUrl,
                    type: "POST",
                    data: {
                        _token: csrfToken,
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Vehicle data has been removed.",
                                icon: "success",
                                timer: 10000, // Auto-close after 10 seconds
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload(); // Refresh AFTER alert closes
                            });
                        } else {
                            Swal.fire("Error!", "Failed to delete Vehicle.", "error");
                        }
                    }

                });
            }
        });
    });

});


function formatVehiNo(input) {
    input.value = input.id === "VehiNo" ?
        input.value.toUpperCase().replace(/\s+/g, '') // Convert to uppercase and remove spaces for others
        :
        input.value.toUpperCase(); // Only convert to uppercase for VehiNo
}