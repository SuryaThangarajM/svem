let currentFilters = {
    type: '',
    fromdate: '',
    todate: '',
    cusname: ''
};

function formatDate(dateString) {
    const options = {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('en-CA', options);
}

function fetchPaginatedData(page = 1) {
    const params = new URLSearchParams({
        ...currentFilters,
        page: page
    });

    fetch(`${billallnewFetchUrl}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(res => res.json())
        .then(data => {
            // Update totals
            document.getElementById("totalAmount").textContent = `₹${Number(data.totals.TotalAmount).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById("totalPaid").textContent = `₹${Number(data.totals.Paid).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById("totalBalance").textContent = `₹${Number(data.totals.Balance).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

            // Update table
            const tableBody = document.getElementById("billTableBody");
            tableBody.innerHTML = "";

            let serial = data.billall.from;
            data.billall.data.forEach((bill, index) => {
                const row = `
            <tr>
                <td>${serial + index}</td>
                <td>${bill.BillNo}</td>
                <td class="col-bill-date">${formatDate(bill.BillDate)}</td>
                <td>${bill.CusName}</td>
                <td>${bill.CusMobNo}</td>
                <td>${bill.CusAddress}</td>
                <td>${bill.OprName}</td>
                <td>${bill.VehiID}</td>
                <td>${bill.Works}</td>
                <td>${bill.StartTime}</td>
                <td>${bill.EndTime}</td>
                <td>${bill.TotalTime}</td>
                <td>${bill.TotalAmount}</td>
                <td>${bill.Paid}</td>
                <td>${bill.Balance}</td>
            </tr>
        `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });

            // Update pagination links
            document.getElementById("paginationLinksbillall").innerHTML = data.html;

            // Rebind pagination
            document.querySelectorAll('#paginationLinksbillall .pagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    let url = new URL(this.href);
                    let page = url.searchParams.get("page");
                    fetchPaginatedData(page);
                });
            });
        })
        .catch(error => console.error("Error:", error));
}

document.querySelectorAll(".search").forEach(function (btn) {
    btn.addEventListener("click", function () {
        const fromdate = document.getElementById("fromdate").value;
        const todate = document.getElementById("todate").value;
        const cusname = document.getElementById("customer_name").value;

        let type = "";

        if (this.id === "date") {
            type = "DateWise";
        } else if (this.id === "cusname") {
            type = "CusWise";
        } else if (this.id === "allpenamnt") {
            type = "Balencewise";
        }

        // Save filters
        currentFilters = {
            type: type,
            fromdate: fromdate,
            todate: todate,
            cusname: cusname
        };

        // Call page 1 with filters
        fetchPaginatedData(1);
    });
});

// Optional: Auto-set today's date on load
document.addEventListener("DOMContentLoaded", function () {
    let today = new Date().toLocaleDateString('en-CA');
    document.getElementById("fromdate").value = today;
    document.getElementById("todate").value = today;
});