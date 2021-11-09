class App {
    constructor() {
        this.forms = [];
        var forms = document.getElementsByTagName("form");
        for (var i = 0; i < forms.length; i++) {
            this.forms.push(new Form(forms[i], this.forms.length));
        }
    }
    reload() {
        window.location.reload();
    }
}
