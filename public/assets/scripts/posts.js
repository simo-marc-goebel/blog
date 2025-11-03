// API call from restcountries to fetch common name ("Germany") and CCA2-Codes ("DE") -
// I COULD build a db table with it, but I wanted to try and see how APIs work.
fetch("https://restcountries.com/v3.1/all?fields=name,cca2")
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById("country");
        select.innerHTML = '<option value="">Select a country</option>';
        const sorted = data.sort((a, b) => a.name.common.localeCompare(b.name.common));
        sorted.forEach(country => {
            const option = document.createElement("option");
            option.value = country.cca2; // Value = Country Code f.e. DE, AZ
            option.textContent = country.cca2 + " | " + country.name.common; // TODO: Find out how to use a tab here
            select.appendChild(option);
        });
    })
    .catch(error => {
        console.error("Error loading countries:", error);
    });

// Create a new post
document.getElementById('postForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const headline = document.getElementById('postHeadline').value.trim();
    const post = document.getElementById('postInput').value.trim();
    const fileInput = document.getElementById('imageInput');
    const file = fileInput.files[0];
    const location = document.getElementById('country').value;

    if (!headline || !post) { // Most handled by JS, spaces could come through.
        alert("Please fill in both the headline and the post content.");
        return;
    }

    // Object to pass to backend
    const formData = new FormData();
    formData.append('headline', headline);
    formData.append('postContent', post);
    formData.append('location', location);

    if (file) { // Saves the file to assets/images/postPics/ TODO: Safer storage variant
        const customFileName = 'post_' + Date.now() + '.' + file.name.split('.').pop(); // returns post_[timestamp].ext
        const newFile = new File([file], customFileName, { type: file.type });
        formData.append('postImage', newFile);
    }
    // Pass previously instanced object formData to backend
    fetch('/posts.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide and reset the modal and reload the page
                alert("Post submitted successfully!");
                const modal = bootstrap.Modal.getInstance(document.getElementById('postModal'));
                modal.hide();
                document.getElementById('postForm').reset();
                window.location.reload();
            } else {
                alert("Error: " + (data.error || "Unknown error"));
            }
        })
        .catch(err => {
            console.error('Upload failed:', err);
            alert("Something went wrong.");
        });
});