class Form {
    constructor(form, index) {
        this.validator = form.classList.contains("validate") ? new Validator(form) : false;
        this.form = form;
        this.form.setAttribute("form-array-index", index);
        this.form.onsubmit = (e) => {
            e.preventDefault();
            app.forms[e.target.getAttribute("form-array-index")].prepare();
        }
    }
    prepare() {
        if (this.validator) {
            this.validate();
        } else {
            this.submit();
        }
    }
    submit() {
        var pw = this.form.password;
        var confirm = this.form.confirmpassword;
        if (pw) {
            var hash = document.createElement("input");
            hash.type = "hidden";
            hash.value = sha512(pw.value);
            hash.name = "hash";
            this.form.appendChild(hash);
            pw.parentNode.removeChild(pw);
            pw.name = "";
        }
        if (confirm) {
            confirm.parentNode.removeChild(confirm);
            confirm.name = "";
        }
        this.request = new Request(this.form);
    }
    validate() {
        if (this.validator.validate()) {
            this.submit();
        }
    }
}
