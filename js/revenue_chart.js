
async function loadRevenueChart() {
  try {
    const response = await fetch("api/api.php?type=revenue_chart");
    const data = await response.json();

    console.log("API Data:", data); // 👈 check what comes back

    if (!Array.isArray(data) || data.length === 0) {
      console.error("No data received from API");
      return;
    }

    const labels = data.map(item => {
      let d = new Date(item.x);
      return d.toLocaleDateString('en-US', { day: 'numeric', month: 'short' });
    });

    const values = data.map(item => item.y);

    const ctx = document.getElementById("salesChart").getContext("2d");

    new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "Revenue",
          data: values,
          borderColor: "rgba(54, 162, 235, 1)",
          backgroundColor: "rgba(54, 162, 235, 0.2)",
          borderWidth: 2,
          tension: 0.4,
          fill: true,
          pointRadius: 3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: ctx => "₹ " + ctx.formattedValue
            }
          }
        },
        scales: {
          y: {
            ticks: { callback: v => "₹" + v }
          }
        }
      }
    });
  } catch (err) {
    console.error("Chart error:", err);
  }
}

loadRevenueChart();

