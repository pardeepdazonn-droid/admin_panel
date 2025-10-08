function loadCount(type, elementId) {
  fetch("./api/api.php?type=" + type)
    .then(response => response.json())  
    .then(data => {
   
      const key = Object.keys(data)[0];
       
      document.getElementById(elementId).textContent = data[key];
    });
}

loadCount("products", "totalProducts");
loadCount("categories", "totalCategories");
loadCount("revenue","totalRevenue");
loadCount("pending","totalPending");