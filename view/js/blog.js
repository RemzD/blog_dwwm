// JavaScript source code
class Blog {
    posts = [];
    visitor = false;
    constructor() {}
    createPost(title, content, date) {
        this.posts.push(new Post(title, content, new Date(date)));
    }
    createVisitor() {
        var textPseudo = document.getElementById("textPseudo").value;
        var textMail = document.getElementById("textMail").value;
        this.visitor = new Visitor(textPseudo, textMail);
        document.getElementById("textPseudo").value = "";
        document.getElementById("textMail").value = "";
    }
    createComment() {
        var numPost = document.getElementById("numPost").value;
        this.posts[numPost].createComment(this.visitor);
    }
}