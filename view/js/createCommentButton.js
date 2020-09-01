Display.prototype.createCommentButton = function(numPost) {
    var button = document.createElement("button");
    button.textContent = "Commenter";
    var visitor = this.blog.visitor;
    if (visitor) {
        button.onclick = () => this.selectVisible("newComment", numPost);
    }
    else {
        button.onclick = () => this.selectVisible("newVisitor", 0);
    }
    return button;
}