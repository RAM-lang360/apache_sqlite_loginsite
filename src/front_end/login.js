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

    var logout_button = document.getElementById('logout_button');
    if (logout_button) {
        console.log("Logout button found"); // デバッグ用ログ
        logout_button.addEventListener('click', async function(event) {
            event.preventDefault();
            console.log("Logout button clicked"); // デバッグ用ログ
            var url = "/back_end/logout.php";
            fetch(url, {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
            })
            .then(response => response.json())
            .then(json => {
                window.location.href = "/front_end/login.html";
            })
            .catch(e => {
                console.error(e);
            });
        });
    } else {
        console.log("Logout button not found"); // デバッグ用ログ
    }
});
