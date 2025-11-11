const params = new URLSearchParams(window.location.search); // Get the URL Params ( ?id=5 )
const postId = params.get('postID');

if (!postId) { // Check if post ID is present, should never happen but just in case
    console.log('No post ID - just update your JS finally you dumdum');
    //alert('No post ID specified in the URL.');
} else {
    fetch(`postDetails?id=${postId}`) // Gets the postID from the specified URL param
        .then(response => { // Prevent DB errors or similar
            console.log('response');
            if (!response.ok) {
                throw new Error('Failed to fetch post data.');
            }
            return response.json();
        })
        .then(data => {
            console.log('Image path:', data.post.imgPath);
            // Fill placeholders with post content if there is a post with the corresponding postID
            if (data.post) {
                document.getElementById('post-title').textContent = data.post.headline;
                document.getElementById('post-content').textContent = data.post.postContent;
                document.getElementById('post-author').textContent = data.post.name;
                document.getElementById('post-date').textContent = data.post.createdAt;
                document.getElementById('post-role').textContent = data.post.rolename;
                document.getElementById('post-image').src = "/assets/images/postPics/" + data.post.imgPath; // hardcoded path - might need to restructure here
                getCountryByCCA(); // Update the Country's shown name
            } else {
                document.getElementById('post-title').textContent = 'Post not found';
                document.getElementById('post-content').textContent = '';
            }

            // Update comments
            const commentList = document.getElementById('comment-list');
            commentList.innerHTML = ''; // Clear existing content

            if (data.comments && data.comments.length > 0) {
                data.comments.forEach(comment => {
                    const li = document.createElement('li');
                        // I literally had no other idea than to insert html here - create a div foreach comment TODO: Clean up using real JS
                    li.innerHTML = `
                        <div class="row g-4 align-items-start">
                            <!-- Left: Author Info -->
                            <div class="col-md-2">
                                <div class="text-muted small">Author: ${comment.name || 'Unknown'}</div>
                                <div class="text-muted small">Created: ${comment.createdAt || 'Unknown'}</div>
                                <div class="text-muted small">Role: ${comment.rolename || 'Unknown'}</div>
                                <p></p>
                            </div>

                            <!-- Center: Comment Content -->
                            <div class="col-md-6">
                                <p>${comment.commentContent || ''}</p>
                            </div>
                            <div class="col-md-2">
                                <img src="/assets/images/profPics/${comment.profilePic}" class="commentProfileImg" alt="Missing profile picture">
                            </div>
                        </div>
                    `;
                    commentList.appendChild(li); // Actually get the content into the commentList
                });
            } else {
                commentList.innerHTML = '<li>No comments yet.</li>';
            }
        })
        .catch(error => {
            console.log('Error');
            console.error('Error:', error);
            document.getElementById('post-title').textContent = 'Error loading post';
            document.getElementById('post-content').textContent = '';
        });

    // Insert own comment into database
    document.getElementById('commentForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Provided by chatgpt: form doesn’t reload the page, and doesn’t navigate away. Own logic can handle everything

        const comment = document.getElementById('commentInput').value.trim();
        if (!comment) { // Handled by Comment form, just for safety (f.e. a space can circumvent the form handler)
            alert("Please enter a comment.");
            return;
        }

        fetch('insertComment.php', { // or the endpoint handling insert
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                comment: comment,
                post_id: postId,
                user_id: CURRENT_USER_ID // you'll need this value from session or JS
            })
        })
            .then(response => response.text())
            .then(data => {
                console.log('Server response:', data);
                alert("Comment submitted successfully!");
                const modal = bootstrap.Modal.getInstance(document.getElementById('commentModal'));
                modal.hide();
                document.getElementById('commentForm').reset();
                window.location.reload();
            });

        // Clear the textarea
        this.reset();
    });
}

function getCountryByCCA(){
    fetch("https://restcountries.com/v3.1/all?fields=name,cca2")
        .then(response => response.json())
        .then(data => {
            // Build a lookup dictionary using CCA and commons: { "DE": "Germany", "US": "United States", ... }
            const countryMap = {};
            data.forEach(country => {
                countryMap[country.cca2] = country.name.common;
            });
            console.log('Country map filled');
            fillCountryNames(countryMap);
        })
        .catch(error => console.error("Error fetching country data:", error));
}

function fillCountryNames(countryMap) { // Fill the country placeholder with the corresponding common country name using the saved cca2
    fetch(`postDetails.php?id=${postId}`)
        .then(response => {
            if (!response.ok) throw new Error("Failed to load post details");
            return response.json();
        })
        .then(data => {
            const countryCode = data.post.country; // Gets the saved CCA ("DE")
            document.getElementById('pdCountry').textContent = countryMap[countryCode];
        })
        .catch(err => console.error("Error loading country name:", err));
}