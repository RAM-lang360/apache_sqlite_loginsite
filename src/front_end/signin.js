document.addEventListener('DOMContentLoaded', (event) => {
    console.log("DOM fully loaded and parsed"); // デバッグ用ログ
z
    var button = document.getElementById('button');
    if (button) {
        console.log("Login button found"); // デバッグ用ログ
        button.addEventListener('click', async function(event) {
            event.preventDefault();
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            console.log("username", username);
            console.log("password", password);
            var url = "/back_end/signin.php";

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
                    
                } else if (json.status == "error") {
                    console.log(json.error);
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
