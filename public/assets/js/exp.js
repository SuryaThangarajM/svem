document.addEventListener("DOMContentLoaded", function () {
    let today = new Date().toLocaleDateString('en-CA');
    document.getElementById("date1").value = today; // Set as default value
});

const deleteButtons = document.querySelectorAll(".delete-btn");

deleteButtons.forEach(button => {
    button.addEventListener("click", function () {
        const expenseId = this.getAttribute("data-id"); // Get expenseId from button
        const row = this.closest("tr"); // Get the table row to remove on successful delete

        // Create the delete URL dynamically
        const expDeleteUrl = `/expenses/${expenseId}`;

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to delete this record?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Send DELETE request
                fetch(expDeleteUrl, {
                    method: "DELETE",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Dynamically fetch CSRF token
                    }
                })
                .then(response => {
                    if (response.ok) {
                        row.remove(); // Remove the row from the table
                        Swal.fire(
                            "Deleted!",
                            "Record has been deleted.",
                            "success"
                        );
                    } else {
                        Swal.fire(
                            "Failed!",
                            "Could not delete the record.",
                            "error"
                        );
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire(
                        "Oops!",
                        "Something went wrong while deleting.",
                        "error"
                    );
                });
            }
        });
    });
});
