let form = new Form('login-form', 'login.php');

form.onPostResolve = function(request) {
    let userInfos = JSON.parse(request.responseText);

    if (userInfos["pseudo"]) {
        sessionStorage.setItem('user', request.responseText);
        window.location = '../index.html';

    } else {
        document.getElementById("bad-password").style.display = "block";
    }
}
