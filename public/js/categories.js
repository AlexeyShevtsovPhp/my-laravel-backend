document.addEventListener("DOMContentLoaded", async function () {

    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const urlParams = new URLSearchParams(window.location.search);
    let page = parseInt(urlParams.get('page')) || 1;
    const categoryId = document.getElementById('category_id').value;
    let totalPages = 0;
    console.log(categoryId);

    async function getCategories() {
        let url = `/api/categories?page=1`;
        const response = await fetch(url);

        if (!response.ok) {
            console.error(`Error: ${response.status}`);
            return;
        }

        const data = await response.json();
        console.log('Ответ с сервера:', data);
        const categories = data.data;
        totalPages = data.current_page;
        console.log(totalPages);

        const tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = '';

        categories.forEach(category => {
            const row = document.createElement('tr');
            const nameCell = document.createElement('td');
            nameCell.textContent = category.name;

            nameCell.style.cursor = 'pointer';
            nameCell.addEventListener('click', function () {
                const targetPage = (page > 1) ? 1 : page;
                window.location.href = `/categories/${category.id}?page=${targetPage}`;
            });
            row.appendChild(nameCell);
            tableBody.appendChild(row);
        });
    }

    async function getComments() {
        let url = `/api/comments?category_id=${categoryId}&page=${page}`;
        const response = await fetch(url);
        if (!response.ok) {
            console.error(`Error: ${response.status}`);
            return;
        }

        const data = await response.json();

        const tableBody = document.querySelector('#comments table tbody');
        tableBody.innerHTML = '';

        data.comments.forEach(comment => {
            const row = document.createElement('tr');

            const nameCell = document.createElement('td');
            nameCell.textContent = comment.username;

            const contentCell = document.createElement('td');
            contentCell.textContent = comment.content;

            const deleteButtonCell = document.createElement('td');
            const deleteButton = document.createElement('button');
            deleteButton.classList.add('small-button');
            deleteButton.textContent = '-';
            deleteButton.setAttribute('data-id', comment.id);

            deleteButtonCell.style.textAlign = 'center';
            deleteButtonCell.style.width = '25px';
            deleteButtonCell.appendChild(deleteButton);

            row.appendChild(nameCell);
            row.appendChild(contentCell);
            row.appendChild(deleteButtonCell);

            tableBody.appendChild(row);
        });

        totalPages = data.meta.total_pages;


        if (page === 1) {
            prevButton.classList.add('disabled-first-page');
        } else {
            prevButton.classList.remove('disabled-first-page');
        }

        if (page === totalPages) {
            nextButton.classList.add('disabled-last-page');
        } else {
            nextButton.classList.remove('disabled-last-page');
        }
    }

    async function addComment(event) {
        event.preventDefault();

        const comment = document.getElementById('message').value;

        if (!comment) {
            console.log("Ошибка: пустые поля");
            const notification = document.createElement('div');
            notification.classList.add('notification-wrong');
            notification.textContent = 'Необходимо заполнить поле сообщения';
            document.body.appendChild(notification);
            return;
        } else {
            console.log("Данные присутствуют");
        }

        const form = document.querySelector('#first-form');
        const formData = new FormData(form);
        formData.append('category_id', categoryId);

        const response = await fetch(`/api/comments?comment=${comment}&category_id=${categoryId}`, {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();
        console.log(data);

        document.getElementById('message').value = '';
        const notification = document.createElement('div');
        notification.classList.add('notification');
        notification.textContent = 'Ваш комментарий был успешно добавлен!';
        document.body.appendChild(notification);

        await getComments();
    }

    const tableBody = document.querySelector('#comments table tbody');

    tableBody.addEventListener('click', async function (event) {
        if (event.target.classList.contains('small-button')) {
            const commentId = event.target.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/api/comments?id=${commentId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const data = await response.json();
            event.target.closest('tr').remove();

            if (data.success) {

                if (tableBody.rows.length === 0 && page > 0) {
                    page--;
                    urlParams.set('page', page);
                    window.history.pushState({}, '', '?' + urlParams.toString());

                    location.reload();
                    console.log(data)
                }
            } else {

            }
        }
    });

    const form = document.querySelector('#first-form');
    form.addEventListener('submit', addComment);

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

    const userList = document.getElementById('userList');
    if (userList) {
        userList.addEventListener('click', function () {
            window.location.href = `/users/`;
        });
    }

    const items = document.querySelectorAll('li');

    items.forEach(item => {
        item.addEventListener('click', function () {
            items.forEach(i => i.classList.remove('selected'));

            this.classList.add('selected');
        });
    });

    await getCategories();
    await getComments();
});
