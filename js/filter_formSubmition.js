 document.addEventListener("DOMContentLoaded", () => {
  const filterForm = document.getElementById('filterForm');
  const responseDiv = document.getElementById('response');
  const backupHTML = document.getElementById('allProductsBackup').innerHTML;
  const heading = document.getElementById('productHeading');
  const priceRange = document.getElementById('priceRange');

  // 🧭 Update live price display
  if (priceRange) {
    priceRange.addEventListener('input', function() {
      document.getElementById('selectedPrice').textContent = this.value;
    });
  }

  // 🧩 Handle filter form submission
  filterForm.addEventListener('submit', e => {
    e.preventDefault();

    const formData = new FormData(filterForm);
    responseDiv.innerHTML = `
      <div class="text-center py-4 w-100">
        <div class="spinner-border text-primary mb-2"></div>
        <p class="text-muted m-0">Loading products...</p>
      </div>
    `;

    fetch('./handler/handle_filters.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      const clean = data.trim();

      if (clean === '' || clean.includes('No products found')) {
        heading.textContent = 'All Products';
        responseDiv.innerHTML = backupHTML;
      } else {
        heading.textContent = 'Filtered Products';
        responseDiv.innerHTML = clean;
      }
    })
    .catch(err => {
      responseDiv.innerHTML = `
        <div class="text-danger text-center py-4">
          <i class="bi bi-exclamation-circle"></i> Error: ${err.message}
        </div>
      `;
    });
  });
});
 
