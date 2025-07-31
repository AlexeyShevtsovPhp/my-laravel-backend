document.addEventListener("DOMContentLoaded", async function () {
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const urlParams = new URLSearchParams(window.location.search);
    let page = parseInt(urlParams.get('page')) || 1;
    const userId = document.getElementById('user_id').value;

    console.log(userId);
    let totalPages = 0;

    async function getComments() {
        let url = `/api/comments/user/${userId}?page=${page}`;
        const response = await fetch(url);
        if (!response.ok) {
            console.error(`Error: ${response.status}`);
            return;
        }

        const data = await response.json();

        const comments = data.comments;
        totalPages = data.meta.total_pages;

        const tableBody = document.querySelector('#AccountComments table tbody');
        if (!tableBody) {
            console.error('Тело таблицы не найдено');
            return;
        }
        tableBody.innerHTML = '';

        comments.forEach(comment => {
            const row = document.createElement('tr');

            const contentCell = document.createElement('td');
            contentCell.textContent = comment.content;


            row.appendChild(contentCell);
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
        if (page < totalPages) {
            const newPage = page + 1;
            urlParams.set('page', newPage);
            window.history.pushState({}, '', '?' + urlParams.toString());
            location.reload();
        }
    });


    await getComments();
});
