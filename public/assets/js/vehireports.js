document.addEventListener("DOMContentLoaded", function () {
    // let today = new Date().toISOString().split('T')[0];  Get today's date in YYYY-MM-DD format
    let today = new Date().toLocaleDateString('en-CA');
    document.getElementById("fromdate").value = today; // Set as default value
    document.getElementById("todate").value = today; // Set as default value

});

let type = "";

document.querySelectorAll(".form-check-input").forEach(function (radioBtn) {
    radioBtn.addEventListener("click", function () {

        if (this.id === "totchk") {
            type = "totchk";
        } else if (this.id === "expchk") {
            type = "expchk";
        }

        loadVehicleReport(1); // Always reset to first page
    });
});

function loadVehicleReport(page = 1) {
    const fromdate = document.getElementById("fromdate").value;
    const todate = document.getElementById("todate").value;
    const vehiid = document.getElementById("vehicle_id").value;


    const queryParams = new URLSearchParams({
        type,
        fromdate,
        todate,
        vehiid,
        page
    });

    fetch(`${vehichkFetchUrl}?${queryParams.toString()}`, {
        headers: {
            "Accept": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            document.getElementById("tablevehi").style.display = "block";
            document.getElementById("billTableBody").innerHTML = data.tableHtml;
            document.getElementById("paginationLinks").innerHTML = data.paginationHtml;

            // Re-bind click events to the pagination links
            document.querySelectorAll("#paginationLinks .pagination a").forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get("page");
                    loadVehicleReport(page);
                });
            });
        });
}


// Helper function to format date from "YYYY-MM-DD" to "DD-MM-YYYY"
function formatDate(isoDateStr) {
    const date = new Date(isoDateStr);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}