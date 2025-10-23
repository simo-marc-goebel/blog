
fetch('content/navbar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('navbar-placeholder').innerHTML = data;
        console.log('navbar was fetched');
    });

fetch('content/sidebar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('sidebar-placeholder').innerHTML = data;
        console.log('sidebar was fetched');

        const script = document.createElement('script');
        script.src = '../assets/scripts/sidebar.js';
        document.body.appendChild(script);

        const storedUser = sessionStorage.getItem('loggedInUser');
        console.log("dom loaded, should get storedUser now");
        if (storedUser) {
            updateSidebarWithUser(JSON.parse(storedUser));
        }
    });


function updateSidebarWithUser(user)
{
    document.getElementById('usernameSb').innerText = user.username;
    document.getElementById('rolenameSb').innerText = user.rolename;
}