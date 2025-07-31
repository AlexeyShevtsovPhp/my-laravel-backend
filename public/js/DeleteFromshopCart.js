document.addEventListener('DOMContentLoaded', function () {

    const rows = document.querySelectorAll('#cart tbody tr');
    const cartItems = {};

    if (rows.length === 0) {
        const tbody = document.querySelector('#cart tbody');
        const emptyRow = document.createElement('tr');
        const emptyCell = document.createElement('td');
        emptyCell.colSpan = 3;
        emptyCell.textContent = 'Пусто';
        emptyRow.appendChild(emptyCell);
        tbody.appendChild(emptyRow);

    } else {
        rows.forEach(row => {
            const addButton = row.querySelector('.small-button');
            const productId = row.getAttribute('data-id');
            const quantityCell = row.querySelector('.quantity');
            const quantity = parseInt(quantityCell.textContent, 10);

            if (cartItems[productId]) {
                cartItems[productId].quantity += quantity;
                row.remove();
            } else {
                cartItems[productId] = {
                    rowElement: row,
                    quantity: quantity
                };
            }
            const tbody = document.querySelector('#cart tbody');
            Object.values(cartItems).forEach(item => {
                const row = item.rowElement;
                const quantityCell = row.querySelector('.quantity');
                quantityCell.textContent = item.quantity;
                tbody.appendChild(row);
            });

            addButton.addEventListener('click', function () {

                fetch('/monolit/cart/delete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Товар был успешно удалён');
                        window.location.reload();
                        const updatedRows = document.querySelectorAll('#cart tbody tr');
                        if (updatedRows.length === 0) {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при попытке удаления товара:', error);
                        alert('Произошла ошибка при попытке удаления товара');
                    });
            });
        });
    }
});
