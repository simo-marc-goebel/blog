const params = new URLSearchParams(window.location.search);
const postId = params.get('id');

console.log('At least it´s working');

// Check if post ID is present
if (!postId) {
    console.log('No post ID');
    alert('No post ID specified in the URL.');
} else {
    fetch(`postDetails.php?id=${postId}`)
        .then(response => {
            console.log('response');
            if (!response.ok) {
                throw new Error('Failed to fetch post data.');
            }
            return response.json();
        })
        .then(data => {
            console.log('post content');

            // Update post content
            if (data.post) {
                document.getElementById('post-title').textContent = data.post.headline;
                document.getElementById('post-content').textContent = data.post.postContent;
                document.getElementById('post-author').textContent = data.post.name;
                document.getElementById('post-date').textContent = data.post.createdAt;
                document.getElementById('post-role').textContent = data.post.rolename;
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
                    commentList.appendChild(li);
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
    document.getElementById('commentForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const comment = document.getElementById('commentInput').value.trim();
        if (!comment) {
            alert("Please enter a comment.");
            return;
        }

        fetch('postDetails.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ comment: comment, post_id: postId })
        })
            .then(response => response.text())
            .then(data => {
                console.log('Server response:', data);

                // Optionally show success message or alert
                alert("Comment submitted successfully!");

                // Hide modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('commentModal'));
                modal.hide();

                // Clear form
                document.getElementById('commentForm').reset();
                window.location.reload();
            })

        // Close the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('commentModal'));
        modal.hide();

        // Optional: Clear the textarea
        this.reset();
    });
}
