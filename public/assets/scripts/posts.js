document.getElementById('postForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('js is running');
    const headline = document.getElementById('postHeadline').value.trim();
    const post = document.getElementById('postInput').value.trim();
    if (!post) {
        alert("Please enter some text.");
        return;
    }
    if (!headline) {
        alert("Please enter a headline.");
        return;
    }

    fetch('/posts.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({headline: headline, postContent: post})
    })
        .then(response => response.text())
        .then(data => {
            console.log('Server response:', data);

            // Optionally show success message or alert
            alert("Post submitted successfully!");

            // Hide modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('postModal'));
            modal.hide();

            // Clear form
            document.getElementById('postForm').reset();
            window.location.reload();
        })


    // Optional: Clear the textarea
    this.reset();
});