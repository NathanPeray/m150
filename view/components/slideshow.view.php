<div class="slideshow">
    <div class="slider" style="background-image:url(./img/wedding.jpg)">@@partial(wedding.teaser)</div>
    <div class="slider" style="background-image:url(./img/wolf.jpg)">@@partial(portrait.teaser)</div>
    <div class="infobar">
        <div class="previous controll" onclick="s.previous()">
            <i class="fas fa-angle-left"></i>
        </div>
        <div class="clicker-wrapper">
        </div>
        <div class="next controll" onclick="s.next()">
            <i class="fas fa-angle-right"></i>
        </div>
    </div>
</div>
<script>
    function Slideshow(slideshow) {
        this.sliders = slideshow.getElementsByClassName("slider");
        this.clickerWrapper = slideshow.getElementsByClassName("clicker-wrapper")[0];
        this.activeClicker = 0;
        this.clickers = [];
        for (var i = 0; i < this.sliders.length; i++) {
            this.newClicker(i);
        }
        this.show(this.activeClicker);
    }
    Slideshow.prototype.newClicker = function(index) {
        var clicker = document.createElement("div");
        clicker.setAttribute("img-toggle", index);
        clicker.classList.add("clicker");
        this.clickerWrapper.appendChild(clicker);
        this.clickers.push(clicker);
    }
    Slideshow.prototype.next = function() {
        this.hide(this.activeClicker);
        if (this.activeClicker == this.sliders.length - 1) {
            this.activeClicker = 0;
        } else {
            this.activeClicker++;
        }
        this.show(this.activeClicker);
    }
    Slideshow.prototype.previous = function() {
        this.hide(this.activeClicker);
        if (this.activeClicker == 0) {
            this.activeClicker = this.sliders.length - 1;
        } else {
            this.activeClicker--;
        }
        this.show(this.activeClicker);
    }
    Slideshow.prototype.goTo = function(clicker) {
        this.hide(this.activeClicker);
        this.show(clicker.getAttribute("img-toggle"));
    }
    Slideshow.prototype.hide = function(index) {
        this.sliders[index].classList.remove("active");
        this.clickers[index].classList.remove("active");
    }
    Slideshow.prototype.show = function(index) {
        this.sliders[index].classList.add("active");
        this.clickers[index].classList.add("active");
    }
    var s = new Slideshow(document.getElementsByClassName("slideshow")[0]);
    var sliderInterval = setInterval(nextSlide, 3500);
    function nextSlide(){s.next()}
</script>
