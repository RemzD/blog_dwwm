Display.prototype.createPost = function(title, content, date) {
    this.blog.createPost(title, content, date);
    this.view();
}
