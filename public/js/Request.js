class Request {
    constructor(form) {
        this.form = form;
        var callback = form.getAttribute("callback");
        var req = new XMLHttpRequest();
        req.sender = this;
        req.open("POST", form.getAttribute("reciever") , true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //var resp = JSON.parse(this.responseText);
                app[callback]();
            }
        }
        req.send(this.formatData(form));
    }
    formatData(form) {
        var data = "";
        var dataArr = [];
        var inputs = Array.from(form.getElementsByTagName("input"));
        inputs.push(form.getElementsByTagName("select")[0]);
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type != "submit") {
                data += inputs[i].name + "=" + inputs[i].value + "&";
                dataArr[inputs[i].name] = inputs[i].value;
            }
        }
        data = data.substring(0, data.length - 1);
        return data ;
    }
}
