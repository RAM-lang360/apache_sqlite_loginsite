document.addEventListener('DOMContentLoaded', (event) => {
    console.log("DOM fully loaded and parsed"); // デバッグ用ログ

    var button = document.getElementById('button');
    if (button) {
        console.log("Login button found"); // デバッグ用ログ
        button.addEventListener('click', async function(event) {
            event.preventDefault();
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            console.log("username", username);
            console.log("password", password);
            var url = "/back_end/login.php";

            fetch(url, {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  "username": username,
                  "password": password,
                })
            })
            .then(response => response.json())
            .then(json => {
                if (json.status == "success") {
                    window.location.href = json.re_url;
                } else if (json.status == "error") {
                    console.log("error");
                    window.location.href = "logout.html";
                } else {
                    console.log("Unauthorized access confirmed");
                }
            })
            .catch(e => {
                console.error(e);
            });
        });
    }
});
