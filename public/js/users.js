// console.log('users.js загружен');
// document.addEventListener("DOMContentLoaded", async function () {
//     const prevButton = document.getElementById('prevButton');
//     const nextButton = document.getElementById('nextButton');
//     const urlParams = new URLSearchParams(window.location.search);
//     let page = parseInt(urlParams.get('page')) || 0;
//     const categoryId = parseInt(urlParams.get('category_id')) || 0;
//
//     let totalPages = 0;
//
//     async function getComments() {
//         let url = `/comments?page=${page}&category_id=${categoryId}`;
//         console.log('Запрос к серверу:', url);
//         const response = await fetch(url);
//         if (!response.ok) {
//             console.error(`Error: ${response.status}`);
//             return;
//         }
//
//         const data = await response.json();
//         console.log('Ответ с сервера:', data);
//
//         const tableBody = document.querySelector('table tbody');
//         tableBody.innerHTML = '';
//
//         data.comments.forEach(comment => {
//             const row = document.createElement('tr');
//
//             const nameCell = document.createElement('td');
//             nameCell.textContent = comment.username;
//
//             const contentCell = document.createElement('td');
//             contentCell.textContent = comment.content;
//
//             const deleteButtonCell = document.createElement('td');
//             const deleteButton = document.createElement('button');
//             deleteButton.classList.add('small-button');
//             deleteButton.textContent = '-';
//             deleteButton.setAttribute('data-id', comment.id);
//
//             deleteButtonCell.style.textAlign = 'center';
//             deleteButtonCell.style.width = '25px';
//             deleteButtonCell.appendChild(deleteButton);
//
//             row.appendChild(nameCell);
//             row.appendChild(contentCell);
//             row.appendChild(deleteButtonCell);
//
//             tableBody.appendChild(row);
//         });
//
//         totalPages = data.meta.total_pages;
//
//         if (page === 0) {
//             prevButton.classList.add('disabled-first-page');
//         } else {
//             prevButton.classList.remove('disabled-first-page');
//         }
//
//         if (page >= totalPages - 1) {
//             nextButton.classList.add('disabled-last-page');
//         } else {
//             nextButton.classList.remove('disabled-last-page');
//         }
//     }
//
//     async function addComment(event) {
//         event.preventDefault();
//
//         const user = document.getElementById('name').value;
//         const comment = document.getElementById('message').value;
//         const categoryId = new URLSearchParams(window.location.search).get('category_id');
//         console.log(comment);
//
//
//         if (!comment) {
//             console.log("Ошибка: пустые поля");
//             const notification = document.createElement('div');
//             notification.classList.add('notification-wrong');
//             notification.textContent = 'Необходимо заполнить поле сообщения';
//             document.body.appendChild(notification);
//             return;
//         } else {
//             console.log("Данные присутствуют");
//         }
//
//         const form = document.querySelector('#form');
//         const formData = new FormData(form);
//         formData.append('category_id', categoryId);
//
//         const response = await fetch('/comments', {
//             method: 'POST',
//             body: formData,
//         });
//
//         const data = await response.json();
//         console.log(data);
//
//         document.getElementById('message').value = '';
//         const notification = document.createElement('div');
//         notification.classList.add('notification');
//         notification.textContent = 'Ваш комментарий был успешно добавлен!';
//         document.body.appendChild(notification);
//
//         await getComments();
//     }
//
//     const tableBody = document.querySelector('table tbody');
//
//     tableBody.addEventListener('click', async function (event) {
//         if (event.target.classList.contains('small-button')) {
//             const commentId = event.target.getAttribute('data-id');
//             const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//
//             const response = await fetch(`/comments?id=${commentId}`, {
//                 method: 'DELETE',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': csrfToken
//                 }
//             });
//
//             const data = await response.json();
//             event.target.closest('tr').remove();
//
//             if (data.success) {
//
//                 if (tableBody.rows.length === 0 && page > 0) {
//                     page--;
//                     urlParams.set('page', page);
//                     window.history.pushState({}, '', '?' + urlParams.toString());
//
//                     location.reload();
//                     console.log(data)
//                 }
//             } else {
//
//             }
//         }
//     });
//
//     const form = document.querySelector('#form');
//     form.addEventListener('submit', addComment);
//
//     await getComments();
//
//
//     prevButton.addEventListener('click', function () {
//         if (page > 0) {
//             const newPage = page - 1;
//             urlParams.set('page', newPage);
//             window.history.pushState({}, '', '?' + urlParams.toString());
//             location.reload();
//         }
//     });
//
//     nextButton.addEventListener('click', function () {
//         if (page < totalPages - 1) {
//             const newPage = page + 1;
//             urlParams.set('page', newPage);
//             window.history.pushState({}, '', '?' + urlParams.toString());
//             location.reload();
//         }
//     });
// });
