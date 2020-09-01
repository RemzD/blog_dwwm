let display = new Display();
let user = User.getFromSessionStorage();

if (user.authorisations > 2) {
    document.querySelector('header>button').disabled = false;
}

let postForm = new Form('newPost', 'post.php');

postForm.onPostResolve = function(request) {
    let parsedResponse = JSON.parse(request.responseText);

    switch (parsedResponse["status"]) {
        case "created":
            display.createPost(
                parsedResponse["post"].title,
                parsedResponse["post"].content,
                new Date(parsedResponse["post"].creationDate)
            )
            break;

        case 'failure':
            console.log(parsedResponse);
            break;

        default:
            throw new Error('Unexpected status received');

    }
}

postForm.onPostReject = function() {
    console.log(new Error(this.statusText));
};
