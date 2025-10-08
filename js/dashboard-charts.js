 
document.addEventListener('DOMContentLoaded', async () => {

   
    async function fetchAPI(type) {
        try {
            const res = await fetch(`api/api.php?type=${type}`);
            return await res.json();
        } catch (err) {
            console.error(`Error fetching ${type}:`, err);
            return null;
        }
    }

 
    async function loadStats() {
        const stats = ['products', 'categories', 'revenue', 'pending'];
        for (let type of stats) {
            const data = await fetchAPI(type);
            if (!data) continue;

            switch (type) {
                case 'products':
                    document.getElementById('totalProducts').innerText = data.totalProducts ?? 0;
                    break;
                case 'categories':
                    document.getElementById('totalCategories').innerText = data.totalCategories ?? 0;
                    break;
                case 'revenue':
                    document.getElementById('totalRevenue').innerText = '$' + (data.totalRevenue ?? 0);
                    break;
                case 'pending':
                    document.getElementById('totalPending').innerText = data.totalPending ?? 0;
                    break;
            }
        }
    }

    
    async function loadRevenueChart() {
        const data = await fetchAPI('revenue_chart');
        if (!data || data.length === 0) return;

        const labels = data.map(item => {
            const d = new Date(item.x);
            return d.toLocaleDateString('en-US', { day: 'numeric', month: 'short' });
        });
        const values = data.map(item => item.y);

        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Revenue',
                    data: values,
                    borderColor: 'rgba(75,192,192,1)',
                    backgroundColor: 'rgba(75,192,192,0.2)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: { tooltip: { callbacks: { label: ctx => '$' + ctx.formattedValue } } },
                scales: { y: { ticks: { callback: v => '$' + v } } }
            }
        });
    }

    
    async function loadProductsChart() {
        const data = await fetchAPI('products_chart');
        if (!data || data.length === 0) return;

        const labels = data.map(item => {
            const d = new Date(item.x);
            return d.toLocaleDateString('en-US', { day: 'numeric', month: 'short' });
        });
        const values = data.map(item => item.y);

        const ctx = document.getElementById('productsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Orders',
                    data: values,
                    borderColor: 'rgba(255,159,64,1)',
                    backgroundColor: 'rgba(255,159,64,0.2)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: { tooltip: { callbacks: { label: ctx => ctx.formattedValue + ' orders' } } },
                scales: { y: { ticks: { callback: v => v + ' pcs' } } }
            }
        });
    }

   
    await loadStats();
    await loadRevenueChart();
    await loadProductsChart();
});
