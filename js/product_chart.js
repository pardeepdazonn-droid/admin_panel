async function loadProductsChart() {
  // 👇 API should return [{x: timestamp, y: product_count}, ...]
  const response = await fetch("api/api.php?type=products_chart");
  const data = await response.json();

  console.log("Products API Data:", data);

  if (!Array.isArray(data) || data.length === 0) {
    console.error("No product data found");
    return;
  }

  const labels = data.map(item => {
    let d = new Date(item.x);
    return d.toLocaleDateString('en-US', { day: 'numeric', month: 'short' });
  });

  const values = data.map(item => item.y);

  const ctx = document.getElementById("productsChart").getContext("2d");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [{
        label: "Orders",
        data: values,
        borderColor: "rgba(75, 192, 192, 1)",
        backgroundColor: "rgba(75, 192, 192, 0.2)",
        borderWidth: 2,
        tension: 0.4,
        fill: true,
        pointRadius: 3,
        pointBackgroundColor: "#fff"
      }]
    },
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => ctx.formattedValue + " products"
          }
        }
      },
      scales: {
        y: {
          ticks: {
            callback: v => v + " pcs"
          }
        }
      }
    }
  });
}

loadProductsChart();

