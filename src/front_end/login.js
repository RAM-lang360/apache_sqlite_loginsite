document.addEventListener('DOMContentLoaded', (event) => {
    var button = document.getElementById('button');
    if (button) {
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
                  "username":username,
                  "password": password,
                })
              })
                .then(response => {
                  return response.json();
                })
                .then(json => {
                  console.log(json);
                  window.location.href = json.response_url;
                })
                .catch(e => {
                  console.error(e);
                });
        });
    }
});
