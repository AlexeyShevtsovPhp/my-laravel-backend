document.addEventListener('DOMContentLoaded', function () {

    const rows = document.querySelectorAll('#usersComments tbody tr');
    const url = new URL(window.location.href);
    const params = url.searchParams;
    let currentPage = parseInt(params.get('page')) || 1;

    rows.forEach(row => {
        const deleteButton = row.querySelector('.small-comment-button');
        const commentId = row.getAttribute('data-id');

        deleteButton.addEventListener('click', function () {
            fetch('/monolit/comments/delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: commentId
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Комментарий был успешно удалён');
                    row.remove();

                    const updatedRows = document.querySelectorAll('#usersComments tbody tr');

                    if (currentPage > 1 && updatedRows.length === 0) {
                        params.set('page', String(currentPage - 1));
                        url.search = params.toString();
                        window.location.href = url.toString();
                    } else {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Ошибка при попытке удаления товара:', error);
                    alert('Произошла ошибка при попытке удаления комментария');
                });
        });
    });

});
