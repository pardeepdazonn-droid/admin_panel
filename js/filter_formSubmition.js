document.getElementById('priceRange').addEventListener('input', function() {
  document.getElementById('selectedPrice').textContent = this.value;
});

document.getElementById('filterForm').addEventListener('submit', function(e) {
  e.preventDefault(); // stop page reload

  const formData = new FormData(this);

  fetch('./handler/handle_filters.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    document.getElementById('response').innerHTML = data;
  })
  .catch(err => {
    document.getElementById('response').innerHTML = '<span style="color:red;">Error: ' + err.message + '</span>';
  });
});