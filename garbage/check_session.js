document.addEventListener('DOMContentLoaded', async function() {
    const response = await fetch('/var/www/html/back_end/check_session.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'include' // クッキーを自動的に送信する
    });

    const data = await response.json();
    if (!data.status=="") {
        window.location.href = 'index.html';
    }
});
