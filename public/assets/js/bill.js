const tobepayEl = document.getElementById('tobepay');

document.getElementById("endtime").addEventListener("blur", function () {
    let start = parseFloat(document.getElementById("starttime").value) || 0;
    let end = parseFloat(document.getElementById("endtime").value) || 0;

    if (start === 0 || end === 0) {
        document.getElementById("totaltime").value = "";
        return;
    }

    if (end >= start) {
        let total = (end - start).toFixed(2); // Round to 2 decimal places
        document.getElementById("totaltime").value = total;
    } else {
        alert("End Time must be greater than or equal to Start Time!");
        document.getElementById("endtime").value = "";
    }
});



document.getElementById("paid").addEventListener("blur", function () {
    let Totamt = parseInt(document.getElementById("totamt").value) || 0;
    let Paid = parseInt(document.getElementById("paid").value) || 0;


    // if (Totamt === 0 || Paid === 0) {
    if (Totamt === 0) {
        document.getElementById("balamt").value = "";
        return;
    }

    if (Totamt >= Paid) {
        let Balance = Totamt - Paid
        document.getElementById("balamt").value = Balance;
    } else {
        alert("Paid Amount is Greeater than Total Amount!");
        document.getElementById("balamt").value = "";
    }
});


document.getElementById("tobepay").addEventListener("blur", function () {
    // let Paid = parseInt(document.getElementById("paid").value) || 0;
    let Paid = parseInt(document.getElementById("tobeamnt").textContent) || 0;
    let tobepay = parseInt(document.getElementById("tobepay").value) || 0;
    // let labelText = document.getElementById("tobeamnt").textContent;
    // alert(Paid);
    if (Paid === 0 || tobepay === 0) {
        document.getElementById("balamt").value = "";
        return;
    }

    if (Paid >= tobepay) {
        let Balance = Paid - tobepay
        document.getElementById("balamt").value = Balance;
    } else {
        alert("This Amount is Greeater than Balence Amount!");
        document.getElementById("tobepay").value = "";
        tobepayEl.focus();
    }
});





$(document).ready(function () {
    $('#customer_name').change(function () {
        var customerName = $(this).val();
        if (customerName) {
            $.ajax({
                url: getcusmob,
                type: "GET",
                data: {
                    customer_name: customerName
                },
                success: function (response) {
                    if (response) {
                        $('#cusmob').val(response.mobno);
                        $('#cusadd').val(response.address);
                    }
                }
            });
        } else {
            $('#cusmob').val('');
            $('#cusadd').val('');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let today = new Date().toLocaleDateString('en-CA');
    document.getElementById("date").value = today; // Set as default value
    document.getElementById("tobepay").required = false;

    document.getElementById("tobepayDiv").style.display = "none";
    document.getElementById("update").style.display = "none";
});

document.getElementById("searchBtn").addEventListener("click", function () {
    var billNo = document.getElementById("bill_no").value;
    document.getElementById("tobepayDiv").style.display = "block";
    document.getElementById("update").style.display = "block";
    document.getElementById("submit").style.display = "none";
    document.getElementById("paid1").textContent = "Already Paid";
    document.getElementById("tobepay").required = true;


    if (billNo.trim() === "") {
        alert("Please enter a Bill No!");
        return;
    }

    fetch(`${getbilldata}/${billNo}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("customer_name").value = data.CusName;
            document.getElementById("cusmob").value = data.CusMobNo;
            document.getElementById("cusadd").value = data.CusAddress;
            document.getElementById("operator_name").value = data.OprName;
            document.getElementById("vehicle_id").value = data.VehiID;
            document.getElementById("works").value = data.Works;
            document.getElementById("starttime").value = data.StartTime;
            document.getElementById("endtime").value = data.EndTime;
            document.getElementById("totaltime").value = data.TotalTime;
            document.getElementById("totamt").value = data.TotalAmount;
            document.getElementById("paid").value = data.Paid;
            document.getElementById("tobeamnt").textContent = data.Balance;
        })
        .catch(error => console.error("Error:", error));
});

document.getElementById("update").addEventListener("click", function () {


    if (!tobepayEl.checkValidity()) {
        tobepayEl.reportValidity(); // Show the default HTML5 validation popup
        return; // Stop here if invalid
    }

    const tobepay = tobepayEl.value;
    // ✅ Continue with fetch or whatever you want to do

    const billnum = document.getElementById('bill_no').value;
    const curtobeamt = document.getElementById('tobepay').value;
    const curbalamt = document.getElementById('balamt').value;



    fetch(billUpdateUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({
            billnum: billnum,
            curtobeamt: curtobeamt,
            curbalamt: curbalamt
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log("Server says:", data);
            if (data.success) {
                Swal.fire({
                    title: "Updated!",
                    text: "Bill data has been Updated.",
                    icon: "success",
                    timer: 10000, // Auto-close after 10 seconds
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload(); // Refresh AFTER alert closes
                });
            } else {
                Swal.fire("Error!", "Failed to Update Bill.", "error");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });

});


document.getElementById("deleteBtn").addEventListener("click", function () {

    const billnum = document.getElementById('bill_no').value;

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to recover this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(billDeleteUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    billnum: billnum,
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Bill data has been Deleted.",
                            icon: "success",
                            timer: 10000, // Auto-close after 10 seconds
                            confirmButtonText: "OK"
                        }).then(() => {
                            location.reload(); // Refresh AFTER alert closes
                        });
                    } else {
                        Swal.fire("Error!", "Failed to Delete Bill.", "error");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }
    });
});

document.querySelectorAll(".form-check-input").forEach(function (radioBtn) {
    radioBtn.addEventListener("click", function () {

        let TotAmnt = ""
        let tottime = document.getElementById('totaltime').value
        document.getElementById('totamt').value = ""

        if (this.id === "tone") {
            document.getElementById('totamt').value = tottime * 1200;
        } else if (this.id === "ttwo") {
            document.getElementById('totamt').value = tottime * 1100;
        }
    });
});