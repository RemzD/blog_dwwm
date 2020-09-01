// JavaScript source code
class Post {
    comments = [];
    constructor(title, text, date) {
        this.title = title;
        this.text = text;
        this.date = date;
    }
    createComment(visitor) {
        var textNewComment = document.getElementById("textNewComment").value;
        var newComment = new Comment(visitor, textNewComment, new Date());
        document.getElementById("textNewComment").value = "";
        this.comments.push(newComment);
    }
}