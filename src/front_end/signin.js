document.addEventListener('DOMContentLoaded', (event) => {
    var button = document.getElementById('button');
    if (button) {
        button.addEventListener('click', async function(event) {
            event.preventDefault();
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
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
                    document.getElementById('result').innerHTML = "Success sign in";
                    document.getElementById('result').style.color = "green";
                    window.location.href = "login.html";
                } else if (json.status == "error") {
                    document.getElementById('result').innerHTML = json.error;
                    document.getElementById('result').style.color = "red";
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
