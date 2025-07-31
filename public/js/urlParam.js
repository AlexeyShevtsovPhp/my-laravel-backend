const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('registered') && urlParams.get('registered') === 'true') {
    const notification = document.getElementById('notification');
    notification.style.display = 'block';
    setTimeout(function () {
        notification.style.display = 'none';
    }, 5000);
} else if (urlParams.has('registered') && urlParams.get('registered') === 'false') {
    const wr_notification = document.getElementById('notification-wrong');
    wr_notification.style.display = 'block';
    setTimeout(function () {
        wr_notification.style.display = 'none';
    }, 5000);
} else if (urlParams.has('error') && urlParams.get('error') === 'taken') {
    const taken_notification = document.getElementById('notification-taken-name');
    taken_notification.style.display = 'block';
    setTimeout(function () {
        taken_notification.style.display = 'none';
    }, 5000);
}
