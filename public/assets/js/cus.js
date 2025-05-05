
$(document).ready(function () {


    $('#customerForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: customerSUBMITUrl,  // Laravel route for the form submission
            type: 'POST',
            data: {
                _token: csrfToken,  // CSRF protection
                name: $('#name').val(),
                mobno: $('#phone').val(),
                address: $('#address').val()
            },
            success: function (response) {
                Swal.fire({
                    title: "Success!",
                    text: "Customer added successfully!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    // Handle what happens after the alert
                    window.location.reload();  // Reload the page or update the UI dynamically
                });
            },
            error: function (xhr, status, error) {
                // Handle errors if any
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });

    // Fetch Customer Data
    $('#phone').on('keyup', function () {
        let mobno = $(this).val();

        $.ajax({
            url: customerFetchUrl,
            type: "GET",
            data: {
                mobno: mobno
            },
            success: function (response) {
                let tableBody = $('#customerTable tbody');
                tableBody.empty(); // Clear the table before adding new rows

                if (response.success) {
                    console.log("Fetched data:", response);
                    $('#name').val(response.customer.name);
                    $('#address').val(response.customer.address);

                    tableBody.append(`
                <tr id="row-${response.customer.id}">
                    <td>1</td>  <!-- Single Customer Case -->
                    <td>${response.customer.name}</td>
                    <td>${mobno}</td>
                    <td>${response.customer.address}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn" 
                            data-id="${response.customer.id}" 
                            data-name="${response.customer.name}" 
                            data-mobno="${mobno}" 
                            data-address="${response.customer.address}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${response.customer.id}">Delete</button>
                    </td>
                </tr>
            `);
                } else {
                    $('#name').val('');
                    $('#address').val('');

                    if (response.customers.length > 0) {
                        let serial = 1; // Start serial numbering from 1
                        response.customers.forEach(function (cus) {
                            tableBody.append(`
                        <tr id="row-${cus.id}">
                            <td>${serial}</td>  <!-- Proper Auto Serial Numbering -->
                            <td>${cus.name}</td>
                            <td>${cus.mobno}</td>
                            <td>${cus.address}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" 
                                    data-id="${cus.id}" 
                                    data-name="${cus.name}" 
                                    data-mobno="${cus.mobno}" 
                                    data-address="${cus.address}">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${cus.id}">Delete</button>
                            </td>
                        </tr>
                    `);
                            serial++; // Increment serial number for each row
                        });
                    } else {
                        tableBody.append('<tr><td colspan="5" class="text-center">No Customer Data Available</td></tr>');
                    }
                }
            }
        });
    });


    // Handle Edit Button Click
    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let mobno = $(this).data('mobno');
        let address = $(this).data('address');

        $('#phone').val(mobno);
        $('#name').val(name);
        $('#address').val(address);

        // Ensure the hidden input is added
        if ($('#edit-id').length === 0) {
            $('#customerForm').append(`<input type="hidden" id="edit-id" name="id" value="${id}">`);
        } else {
            $('#edit-id').val(id);
        }

        $('.btn-primary').text('Update').attr('id', 'updateBtn');
    });

    // Handle Update Action
    $(document).on('click', '#updateBtn', function (e) {
        e.preventDefault();
        let id = $('#edit-id').val();
        let name = $('#name').val();
        let mobno = $('#phone').val();
        let address = $('#address').val();

        // Debugging: Check if ID exists
        // console.log("Updating Customer - ID:", id, "Name:", name, "MobNo:", mobno, "Address:", address);
        // alert(id); 
        $.ajax({
            url: customerUpdateUrl,
            type: "POST",
            data: {
                _token: csrfToken,
                id: id,
                name: name,
                mobno: mobno,
                address: address
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: "Updated",
                        text: "Customer data has been Updated.",
                        icon: "success",
                        timer: 10000, // Auto-close after 10 seconds
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Refresh AFTER alert closes
                    });
                } else {
                    Swal.fire("Error!", "Failed to Update Customer.", "error");
                }
            }
        });
    });


    // Handle Delete Button Click
    $(document).on('click', '.delete-btn', function () {
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
                    url: customerDeleteUrl,
                    type: "POST",
                    data: {
                        _token: csrfToken,
                        id: id
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Customer data has been removed.",
                                icon: "success",
                                timer: 10000, // Auto-close after 10 seconds
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload(); // Refresh AFTER alert closes
                            });
                        } else {
                            Swal.fire("Error!", "Failed to delete customer.", "error");
                        }
                    }

                });
            }
        });
    });
});