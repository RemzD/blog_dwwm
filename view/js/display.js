class Display {
    constructor() {
        this.blog = new Blog();
    }
    selectVisible(formulary, numPost) {
        var forms = document.getElementsByClassName("formulary");
        for (var i = 0; i < forms.length; i++) {
            forms[i].style.visibility = "hidden";
        }
        if (document.getElementById(formulary)) {
            document.getElementById(formulary).style.visibility = "visible";
        }
        document.getElementById("numPost").value = numPost;
    }
    view() {
        this.cleanBlogContent();
        this.createPostBlock();
        this.selectVisible("none", 0);
    }
    displayDate(date) {
        var textDate = date.getDate();
        textDate += "/";
        textDate += date.getMonth() + 1;
        textDate += "/";
        textDate += date.getFullYear();
        return textDate;
    }

    cleanBlogContent() {
        /*
         * Supprime tous les enfants de "blog"
         */
        var blog = document.getElementById("blog");
        while (blog.firstChild) {
            blog.removeChild(blog.firstChild);
        }
    }
}