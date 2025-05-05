document.addEventListener("DOMContentLoaded", function () {
    // let today = new Date().toISOString().split('T')[0];  Get today's date in YYYY-MM-DD format
    let today = new Date().toLocaleDateString('en-CA');
    document.getElementById("fromdate").value = today; // Set as default value
    document.getElementById("todate").value = today; // Set as default value

});


document.querySelectorAll(".search").forEach(function (btn) {
    btn.addEventListener("click", function () {
        var fromdate = document.getElementById("fromdate").value;
        var todate = document.getElementById("todate").value;

        const queryParams = new URLSearchParams({
            fromdate: fromdate,
            todate: todate,
        });
        fetch(`${incexpFetchUrl}?${queryParams.toString()}`, {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        })
            .then(response => response.json())
            .then(data => {
                // console.log(data.type)
                document.getElementById("income").textContent = `₹${Number(data.incall).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                document.getElementById("expense").textContent = `₹${Number(data.expall).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                document.getElementById("profit").textContent = `₹${Number(data.profit).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

            })
            .catch(error => console.error("Error:", error));

    });
});