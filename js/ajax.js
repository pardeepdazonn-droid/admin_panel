document.getElementById('productform').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    const responseMessage = document.getElementById('responseMessage');
    const formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        responseMessage.innerHTML = '';

        if (data.success) {
            responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            form.reset();  
            
            
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000); 
            }
        } else {
             
            responseMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        
        console.error('Fetch error:', error);
        responseMessage.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
    });
});