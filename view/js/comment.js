// JavaScript source code
class Comment {
    constructor(visitor, text, date) {
        this.visitor = visitor;
        this.text = text;
        this.date = date;
    }
    createButton(numPost) {
        var button = document.createElement("button");
        button.textContent = "Commenter";
        var visitor = this.blog.visitor;

        if (visitor) {
            var element = this;
            button.addEventListener("click",
                function (numPost, element) {
                    element.selectVisible("newComment", numPost);
                });
        }
        else {
            button.addEventListener("click",
                function (numPost, element) {
                    this.selectVisible("newVisitor", 0);
                });
        }
        return button;
    }
}