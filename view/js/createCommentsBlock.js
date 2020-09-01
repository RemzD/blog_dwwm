Display.prototype.createCommentsBlock = function(comments) {
    var commentsList = document.createElement("div");
    for (let i = 0; i < comments.length; i++) {
        var pseudoVisitor = document.createElement("h2");
        var mailVisitor = document.createElement("h2");
        var textNewComment = document.createElement("p");
        var date = document.createElement("p");

        pseudoVisitor.textContent = comments[i].visitor.pseudo;
        mailVisitor.textContent = comments[i].visitor.mail;
        textNewComment.textContent = comments[i].text;
        date.textContent = this.displayDate(comments[i].date);

        commentsList.appendChild(pseudoVisitor);
        commentsList.appendChild(mailVisitor);
        commentsList.appendChild(textNewComment);
        commentsList.appendChild(date);
    }
    return commentsList;
}