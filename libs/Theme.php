<?php 

class Theme extends View{
    
    public function __construct() {
        parent::__construct();
    }

    public function init( $theme_name, $path_name ) {

        $path = 'Theme/' .$theme_name.'_theme.php';

        $_path = $this->getPage('path');
        if( !empty($_path)  ){
           $_path = rtrim($_path, '/').'/'.$path_name;
        }
        else{
            $_path = "Themes/{$this->getPage('theme')}/pages/{$path_name}";
        }

        $this->options = $this->page['theme_options'];

        if( file_exists(WWW_LIBS. $path) ){

            $themeName = $theme_name . '_Theme';

            require $path;
            $this->theme = new $themeName();
            $this->theme->page = $this->page;
            $this->theme->init();
            $this->theme->render($_path, $this->options);
        }
        else{
            $this->_setPage();
            $this->_render($_path);
        }
    }

    public function _setPage() {

        if( !empty($this->page['data']) ){
            foreach ($this->page['data'] as $key => $value) {
                $this->{$key} = $value;
            }
        }

        // has font
        if( !empty($this->system['font']) && $this->getPage('theme') != 'manage' ){
            $this->css('https://fonts.googleapis.com/css?family='.$this->system['font']['name'], true);
            $this->style('body, input, textarea, select, button,.editor-text{'.$this->system['font']['specify'].'}');
        }

        // has Left Menu
        if( !empty($this->options['has_menu']) ){
            $hasPushedLeft = 1;
            $this->elem('body') -> addClass('has_menu');

            $cls = $this->elem('body')->attr('class');
            
            if( !empty($cls) ){
                if( in_array('is-overlay-left', explode(' ', $cls)) ) {
                    $hasPushedLeft = 0;
                }
            }

            if( $hasPushedLeft==1 ){

                Session::init();
                $isPushedLeft = Session::get('isPushedLeft');

                if( isset($isPushedLeft) ){
                    if( $isPushedLeft==1 ) {
                        $this->elem('body')->addClass('is-pushed-left');
                    }
                }
                else{
                    $this->elem('body')->addClass('is-pushed-left');
                }
            }
        }
        
        $mode = 'light';
        if( !empty($this->me['mode']) ){

            switch ($this->me['mode']) {
                case 'dark': $mode = 'drak'; break;
                case 'blue': $mode = 'blue'; break;
                case 'green': $mode = 'green'; break;
            }
        }
        $this->elem('body')->addClass( $mode );

        if( !empty($this->options['has_topbar']) ){
            $this->elem('body')->addClass( 'hasTopbar' );
        }

        # Bootstrap Frontend Settings
       /*  if( $this->page["theme"] == "default" ){
            $this   ->css( VIEW ."Themes/default/assets/css/footer.css", true )
                    ->css( VIEW ."Themes/default/assets/css/bootstrap.css", true )

                    ->js( VIEW ."Themes/default/assets/js/bootstrap.js", true )
                    ->js( VIEW ."Themes/default/assets/js/popper.min.js", true )
                    ->js( VIEW ."Themes/default/assets/js/feather.min.js", true );
        } */

        if( $this->page["theme"] == "default" ){
            $this  ->css( VIEW."Themes/{$this->getPage('theme')}/assets/js/bootstrap/main.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/js/daygrid/main.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/js/core/main.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/css/simple-line-icons.min.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/css/owl.carousel.min.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/fontawesome/css/all.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/css/style_gray_light.min.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/css/animate.min.css", true )
                    ->css( VIEW."Themes/{$this->getPage('theme')}/assets/css/bootstrap.min.css", true )

                    ->js( VIEW."Themes/{$this->getPage('theme')}/assets/js/bootstrap/main.js", true )
                    ->js( VIEW."Themes/{$this->getPage('theme')}/assets/js/daygrid/main.js", true )
                    ->js( VIEW."Themes/{$this->getPage('theme')}/assets/js/core/main.js", true )
                    ->js( VIEW."Themes/{$this->getPage('theme')}/assets/js/script.min.js", true )
                    ->js( VIEW."Themes/{$this->getPage('theme')}/assets/js/owl.carousel.min.js", true )
                    ->js( VIEW."Themes/{$this->getPage('theme')}/assets/js/jquery.dcjqaccordion.min.js", true )
                    ->js( VIEW."Themes/{$this->getPage('theme')}/assets/js/bootstrap.min.js", true );
                    
        }

        # Framework Settings
        $this   ->css( VIEW ."Themes/{$this->getPage('theme')}/assets/css/main.css", true )
                ->css( FONTS . 'font-awesome/css/font-awesome.min.css', true)
                ->css('select2.min')
                ->css('sweetalert2')
                ->css('style')

                ->js( VIEW ."Themes/{$this->getPage('theme')}/assets/js/main.js", true )
                ->js('select2.min')
                ->js('sweetalert2')
                ->js('custom')
                ->js('plugins/dialog')
                ->js('plugins/default')
                ->js('jquery/jquery');
    }
    public function _render($name, $options=array()) {

        # head
        if( empty($this->options['has_head']) ){
            require 'views/Layouts/default/head.php';
        }
        else{
            require "views/Themes/{$this->getPage('theme')}/Layouts/head.php";
        }

        # start: doc
        echo '<div id="doc">';

        if( !empty($this->options["has_nav"]) ){
            require "views/Themes/{$this->getPage('theme')}/Layouts/navbar.php";
        }

        # topbar
        if( !empty($this->options['has_topbar']) ){
            require "views/Themes/{$this->getPage('theme')}/Layouts/topbar.php";
        }

        # menu
        if( !empty($this->options['has_menu']) ){

            require "views/Themes/{$this->getPage('theme')}/Layouts/navigation-main.php";
        }

        # content
        echo '<main id="page-container" class="main">';
            require "views/{$name}.php";
        echo '</main>';

        # footer
        if( !empty($this->options['has_footer']) ){
            require "views/Themes/{$this->getPage('theme')}/Layouts/footer.php";
        }

        # end: doc
        echo '</div>';

        # footer
        require 'views/Layouts/default/footer.php';
    }
}