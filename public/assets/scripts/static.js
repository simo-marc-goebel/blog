
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
    });