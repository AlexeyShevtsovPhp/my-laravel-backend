document.addEventListener('DOMContentLoaded', function () {

    const rows = document.querySelectorAll('#goods tbody tr');

    rows.forEach(row => {
        const addButton = row.querySelector('.small-button');
        const productId = row.getAttribute('data-id');

        addButton.addEventListener('click', function () {

            const notification = document.createElement('div');
            notification.classList.add('notification');
            notification.textContent = 'Товар был успешно добавлен в корзину';
            document.body.appendChild(notification);

            fetch('/monolit/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({product_id: productId})
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Товар был успешно добавлен в корзину');
                })
                .catch(error => {
                    console.error('Ошибка при добавлении в корзину:', error);
                    alert('Произошла ошибка при добавлении товара');
                });
        });
    });
});
