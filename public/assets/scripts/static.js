
fetch('content/navbar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('navbar-placeholder').innerHTML = data; // Fills the placeholder with data (The fetched Navbar)
    });

fetch('content/sidebar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('sidebar-placeholder').innerHTML = data; // Fills the sidebar placeholder

        const script = document.createElement('script');
        script.src = '../assets/scripts/sidebar.js';
        document.body.appendChild(script); // Executes a new script, responsible for everything sidebar-related

        const storedUser = sessionStorage.getItem('loggedInUser'); // If !loggedInUser, it will just show default labels
        if (storedUser) {
            updateSidebarWithUser(JSON.parse(storedUser));
        }
    });

// Set name and role to logged In User's data - TODO: Personal links or description/bio
function updateSidebarWithUser(user)
{
    document.getElementById('usernameSb').innerText = user.username;
    document.getElementById('rolenameSb').innerText = user.rolename;
}