document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Get form data
    const formData = new FormData(this);

    // Send AJAX request
    fetch('../PHP/contact_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const messageStatus = document.getElementById('message-status');
        
        if (data.status === 'success') {
            messageStatus.innerHTML = `
                <div class="alert alert-success">
                    ${data.message}
                </div>
            `;
            // Optional: Reset form
            this.reset();
        } else {
            // Handle errors
            messageStatus.innerHTML = `
                <div class="alert alert-danger">
                    ${data.errors ? data.errors.join('<br>') : data.message}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const messageStatus = document.getElementById('message-status');
        messageStatus.innerHTML = `
            <div class="alert alert-danger">
                An unexpected error occurred. Please try again.
            </div>
        `;
    });
});