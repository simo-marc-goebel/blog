console.log("sidebar script loaded");
let loggedInUser = null;

// document.getElementById('loginForm').addEventListener('submit', function (e){
//     e.preventDefault();
//     console.log("Login form submit");
//     const lgnEmail = document.getElementById('emailInput').value.trim();
//     const lgnPassword = document.getElementById('passwordInput').value.trim();
//
//     if (!lgnEmail || !lgnPassword) {
//         alert("Please fill in both the headline and the post content.");
//         return;
//     }
//     const formData = new FormData();
//     formData.append('email', lgnEmail);
//     formData.append('password', lgnPassword);
//
//     fetch('/login.php', {
//         method: 'POST',
//         body: formData
//
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 loggedInUser = {
//                     username: data.name || 'Max Mustermann',
//                     rolename: data.rolename || 'User'
//                 };
//                 updateSidebarWithUser(loggedInUser);
//                 alert("Login successful!");
//                 const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
//                 modal.hide();
//                 document.getElementById('loginForm').reset();
//                 sessionStorage.setItem('loggedInUser', JSON.stringify(loggedInUser));
//                 window.location.reload();
//
//             } else {
//                 alert("Error: " + (data.error || "Unknown error"));
//             }
//         })
//         .catch(err => {
//             console.error('Login failed:', err);
//             alert("Something went wrong.");
//         });
// });