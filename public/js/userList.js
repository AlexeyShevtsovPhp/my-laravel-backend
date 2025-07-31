document.addEventListener("DOMContentLoaded", async function () {
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const urlParams = new URLSearchParams(window.location.search);
    let page = parseInt(urlParams.get('page')) || 1;
    let totalPages = 0;

    async function getUsers() {
        let url = `/api/users?page=${page}`;
        const response = await fetch(url);
        if (!response.ok) {
            console.error(`Error: ${response.status}`);
            return;
        }

        const data = await response.json();

        const users = data.users;
        totalPages = data.meta.total_pages;


        const tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = '';

        users.forEach(user => {
            const row = document.createElement('tr');
            const nameCell = document.createElement('td');
            nameCell.textContent = user.name;

            nameCell.style.cursor = 'pointer';
            nameCell.addEventListener('click', function () {
                window.location.href = `/users/${user.id}?page=1`;
            });

            row.appendChild(nameCell);
            tableBody.appendChild(row);
        });

        if (page === 1) {
            prevButton.classList.add('disabled-first-page');
        } else {
            prevButton.classList.remove('disabled-first-page');
        }
        if (page >= totalPages) {
            nextButton.classList.add('disabled-last-page');
        } else {
            nextButton.classList.remove('disabled-last-page');
        }
    }

    prevButton.addEventListener('click', function () {
        if (page > 0) {
            const newPage = page - 1;
            urlParams.set('page', newPage);
            window.history.pushState({}, '', '?' + urlParams.toString());
            location.reload();
        }
    });
    nextButton.addEventListener('click', function () {
        if (page < totalPages + 1) {
            const newPage = page + 1;
            urlParams.set('page', newPage);
            window.history.pushState({}, '', '?' + urlParams.toString());
            location.reload();
        }
    });

    const userList = document.getElementById('userList');
    if (userList) {
        userList.addEventListener('click', function () {
            window.location.href = `/categories/1?page=1`;
        });
    }
    await getUsers();
});
