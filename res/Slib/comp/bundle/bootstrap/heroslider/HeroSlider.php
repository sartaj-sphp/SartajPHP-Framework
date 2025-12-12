<?php
/**
 * For use in .front file of SartajPhp.
 * Example:
 * <header id="slider1" runat="server" 
 *         path="mypath/comp/heroslider/HeroSlider.php" 
 *         funsetStyler="1"
 *         funsetImages='{"temp/images/pic1.jpg":"First caption","temp/images/pic2.jpg":"Second caption"}'
 *         funsetInterval="5000"
 *         funsetTitle="Canada Regional Day Home Agency"></header>
 */
class HeroSlider extends Sphp\tools\Control {
    private $images = array();
    private $interval = 3000;
    private $title = "Default Title";

    // Style variables
    private $overlayClass = "overlay-dark";
    private $captionClass = "text-white text-center animate__animated";
    private $textClass    = "animate__animated animate__fadeInUp";
    private $btnClass     = "btn btn-light btn-lg mt-3";

    public function setTitle($title){
        $this->title = $title;
    }

    public function setImages($images){
        $this->images = json_decode($images,true);
    }

    public function setInterval($interval){
        $this->interval = $interval;
    }


    public function setupjs() {
        // CSS dependencies
        addFileLink($this->myrespath."/heroslider.css",true);
        addFileLink($this->myrespath."/animate.min.css",true);

        // JS hook: bounce effect on slide change
        addHeaderJSFunctionCode("ready", $this->name.'jsready', '
        var effects = ["animate__slideInLeft", "animate__slideInRight", "animate__slideInUp", "animate__slideInDown","animate__bounce","animate__shakeX","animate__shakeY","animate__fadeInUp","animate__fadeInDown","animate_zoomIn","animate__zoomOut"];
            $("#'.$this->name.'").on("slid.bs.carousel", function () {
                var caption = $(this).find(".carousel-item.active .carousel-caption h1, .carousel-item.active .carousel-caption p");
                var effect = effects[Math.floor(Math.random() * effects.length)];
                caption.each(function(){
                    var $el = $(this);
                    $.each(effects, function(i, effect2){
                        $el.removeClass(effect2);
                    });                    
                    void this.offsetWidth; // force reflow
                    $el.addClass(effect);
                });
            });
        ', true);
    }

    private function applyStyler(){
        switch($this->styler){
            case 2: // Gradient overlay + zoom
                $this->overlayClass = "overlay-gradient";
                $this->captionClass = "text-start";
                $this->textClass    = "";
                $this->btnClass     = "btn btn-outline-light btn-lg mt-3 rounded-pill";
                break;

            case 3: // Blur overlay + slide
                $this->overlayClass = "overlay-blur";
                $this->captionClass = "text-end";
                $this->textClass    = "";
                $this->btnClass     = "btn btn-success btn-lg mt-3";
                break;

            default: // Styler 1: dark overlay + fade
                $this->overlayClass = "overlay-dark";
                $this->captionClass = "text-white text-center";
                $this->textClass    = "";
                $this->btnClass     = "btn btn-light btn-lg mt-3";
        }
    }

    public function onrender(){
        if(SphpBase::sphp_router()->getCurrentRequest() != 'index'){
            $key1 = array_key_first($this->images);
            $this->element->setAttribute('class','hero d-flex align-items-center text-center text-white');
            $this->style = "background: linear-gradient(rgba(0, 100, 0, 0.6), rgba(0, 100, 0, 0.6)),url('". $key1 ."') no-repeat center center/cover;height: 30vh;";
            $this->setInnerHTML('<div class="container">
      <h1 class="display-4 fw-bold animate__animated animate__fadeInDown">'. $this->title .'</h1>
      <p class="lead animate__animated animate__fadeInUp">'. $this->images[$key1] .'</p>
      <a href="#apply" class="btn btn-light btn-lg mt-3"><i class="fas fa-child"></i> Learn More</a>
    </div>
');
        }else{
            $this->normalRender();
        } 

    }
    public function normalRender(){
        $this->setupjs();
        $this->element->hasAttribute('class') 
            ? $this->element->appendAttribute('class',' heroCarousel carousel slide') 
            : $this->element->setAttribute('class','heroCarousel carousel slide');

        $this->element->setAttribute('data-bs-ride','carousel');
        $this->element->setAttribute('data-bs-interval',$this->interval);

        $this->applyStyler();

        // Build indicators
        $indicators = '<div class="carousel-indicators">';
        $i = 0;
        foreach($this->images as $image=>$text){
            $activeClass = ($i === 0) ? ' class="active"' : '';
            $indicators .= '<button type="button" data-bs-target="#'.$this->name.'" data-bs-slide-to="'.$i.'"'.$activeClass.' aria-current="true" aria-label="Slide '.($i+1).'"></button>';
            $i++;
        }
        $indicators .= '</div>';

        // Build slides
        $imageshtml = "";
        $i = 0;
        foreach($this->images as $image=>$text){
            $activeClass = ($i === 0) ? " active" : "";
            $i++;
            $imageshtml .= '
            <div class="carousel-item'.$activeClass.'" style="background-image:url(\''.$image.'\');">
                <div class="'.$this->overlayClass.'"></div>
                <div class="carousel-caption '.$this->captionClass.'">
                    <h1 class="display-4 fw-bold">'.$this->title.'</h1>
                    <p class=" '.$this->textClass.'">'.$text.'</p>
                    <a href="#apply" class="'.$this->btnClass.'"><i class="fas fa-child"></i> Learn More</a>
                </div>
            </div>';
        }

        $this->setInnerHTML('
            '.$indicators.'
            <div class="carousel-inner">'.$imageshtml.'</div>
            <button class="carousel-control-prev" type="button" data-bs-target="#'.$this->name.'" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#'.$this->name.'" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        ');
    }
}
