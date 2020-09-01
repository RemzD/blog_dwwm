class Form {
    constructor(formId, target) {
        this.form = document.getElementById(formId);
        this.target = target;
        this.button = this.getButton();


        this.button.onclick = () => {
            if (this.isValid()) {
                this.postForm()
                    .then(this.postResolve)
                    .catch(this.postReject);
            }
        }
    }

    getButton() {
        return this.form.querySelector('[type=button]');
    }

    isValid() {
        for (let input of this.form.querySelectorAll('input:not([type=button])')) {
            if (!input.validity.valid) {
                return false;
            }
        }

        return true;
    }


    hide() {
        this.form.style.visibility = 'hidden';
    }

    show() {
        this.form.style.visibility = 'visible';
    }

    postForm() {
        let form = this.form;
        let target = this.target;

        return new Promise(function(resolve, reject) {
            let xhr = new XMLHttpRequest();

            xhr.onload = function() {
                resolve(this);
            };

            xhr.onerror = function() {
                reject(new Error(this.statusText));
            };

            xhr.open('POST', target);
            xhr.send(new FormData(form));
        });
    }

    set onPostResolve(callback) {
        this.postResolve = callback
    }

    get onPostResolve() {
        return this.postResolve;
    }

    set onPostReject(callback) {
        this.postReject = callback
    }

    get onPostReject() {
        return this.postReject;
    }
}