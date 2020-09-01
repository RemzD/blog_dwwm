Display.prototype.createPostBlock = function() {
    /*
     * Crée des divisions qui contiendront
     * tous les posts (chacune un des posts)
     */
    var blog = document.getElementById("blog"); // div identifiée par l'id "blog" du DOM
    for (let i = 0; i < this.blog.posts.length; i++) {
        var division = document.createElement("div");
        var title = document.createElement("h1");
        var text = document.createElement("p");
        var date = document.createElement("p");
        var hr = document.createElement("hr");

        var post = this.blog.posts[i]; // Pour simplifier le code

        date.textContent = this.displayDate(post.date);
        title.textContent = post.title;
        text.textContent = post.text;

        var button = this.createCommentButton(i);

        division.appendChild(title);
        division.appendChild(date);
        division.appendChild(text);
        division.appendChild(button);

        division.appendChild(this.createCommentsBlock(post.comments));

        division.appendChild(hr);
        blog.appendChild(division);
    }
}