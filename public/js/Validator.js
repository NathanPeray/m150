class Validator {
    constructor(form) {
        this.form = form;
        this.fields = form.getElementsByTagName("input");
    }
    removeWarnings() {
        for (var i = 0; i < this.fields.length; i++) {
            this.fields[i].classList.remove("border-danger");
            this.fields[i].parentNode.children[0].classList.remove("text-danger");
        }
    }
    validate() {
        this.removeWarnings();
        this.status = true;
        this.invalidFields = [];
        this.passwords = [];
        for (var i = 0; i < this.fields.length; i++) {
            if (this.fields[i].type == "password") {
                this.passwords.push(this.fields[i]);
            } else if (this.fields[i].type != "submit") {
                this[this.fields[i].type](this.fields[i]);
            }
        }

        if (this.passwords.length == 2) {
            this.validatePasswords(this.passwords[0], this.passwords[1]);
        }
        this.invalid();
        return this.status;
    }
    invalid() {
        for (var i = 0; i < this.invalidFields.length; i++) {
            this.invalidFields[i].classList.add("border-danger");
            this.invalidFields[i].parentNode.getElementsByTagName("label")[0].classList.add("text-danger");
            console.log(this.invalidFields[i]);
        }
    }
    text(field) {
        var status = false;
        var value = field.value;
        if (value == "" || value.length < 2) {
            this.invalidFields.push(field);
            status = false;
        } else {
            status = true;
        }
        this.status = status && this.status;
    }
    email(field) {
        var status = false;
        var value = field.value;
        var regex = /\S+@\S+\.\S+/;
        if (regex.test(value)) {
            status = true;
        } else {
            this.invalidFields.push(field);
            status = false;
        }
        this.status = status && this.status;
    }
    validatePasswords(pw1, pw2) {
        if (this.password(pw1.value)) {
            if (pw1.value != pw2.value) {
                this.invalidFields.push(pw1);
                this.invalidFields.push(pw2);
                this.status = false;
            }
        } else {
            this.invalidFields.push(pw1);
            this.status = false;
        }
    }
    password(value) {
        return value.length > 3;
    }
}
