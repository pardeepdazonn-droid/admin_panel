console.log('hello');
function loadCount(type, elementId) {
  fetch("./api/api.php?type=" + type)   // make AJAX call to API
    .then(response => response.json()) // parse JSON result
    .then(data => {
      // get the key name (e.g., "total_products", "total_categories")
      const key = Object.keys(data)[0];
      // update HTML span with the value
      document.getElementById(elementId).textContent = data[key];
    });
}

loadCount("products", "totalProducts");
loadCount("categories", "totalCategories");
loadCount("revenue","totalRevenue");
loadCount("pending","totalPending");