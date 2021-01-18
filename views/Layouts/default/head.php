<?php


echo '<!doctype html>';

if( $this->elem("html")->attr() ){

    $attributes = "";
    foreach ($this->elem("html")->attr() as $key => $value) {
        $attributes .= " {$key}=\"{$value}\"";
    }

    echo '<html'.$attributes.'>';
}
else{
    echo '<html>';
}

echo '<head>';

// Page title
/*if( $this->pageTitle=='Index' ){
    $this->pageTitle = $this->pageSiteName;
}*/

// Page title
echo '<title id="pageTitle">'. $this->getPage('title') .'</title>';
echo '<meta charset="utf-8" />';

/* set Touch Zooming  */
if( $this->fn->check_user_agent('mobile') ){

    $this->elem('body')->addClass('touch');
    echo '<meta name="viewport" content="user-scalable=no,initial-scale=1,maximum-scale=1">';
    echo '<link rel="mask-icon" href="'.$this->getPage('image-128').'">';

}
echo '<link rel="shortcut icon" href="'.$this->getPage('image-128').'">';
$_content = $this->getPage('color');
if( !empty($color) ){
    echo '<meta name="theme-color" content="'.$_content.'">';
}


/* Set Meta SEO */
$og = array(0=>'title','url','site_name', 'description', 'keywords', 'image');
foreach ($og as $i => $val) {
    $_content = $this->getPage($val);
    
    if( !empty($_content) ){
        echo '<meta name="'.$val.'" content="'.$_content.'">';
    }
}


/* Set Meta Twitter SEO */
$og = array(0=>'card','title','site','creator', 'description', 'image', 'domain');
foreach ($og as $i => $val) {
    $_content = $this->getPage($val);
    
    if( !empty($_content) ){
        echo '<meta name="twitter:'.$val.'" content="'.$_content.'">';
    }
}

/* Set Meta Google SEO */
$og = array(0=>'title','site_name', 'url', 'description','type', 'keywords', 'locale', 'image');
foreach ($og as $i => $val) {
    $_content = $this->getPage($val);
    
    if( !empty($_content) ){
        echo '<meta property="og:'.$val.'" content="'.$_content.'">';
    }
}

$og = array(0=>'type','width', 'height');
// Set Meta Image
foreach ($og as $i => $val) {
    $_content = $this->getPage("image_{$val}");
    
    if( !empty($_content) ){
        echo '<meta property="og:image:'.$val.'" content="'.$_content.'">';
    }
}


// Set Meta Facebook
$_content = $this->getPage('facebook_app_id');
if( !empty($_content) ){
    echo '<meta name="fb:app_id" content="'.$_content.'">';
    echo '<meta name="article:author" content="https://www.facebook.com/'.$_content.'">';
    echo '<meta name="article:publisher" content="https://www.facebook.com/'.$_content.'">';

    // fb.me
}


echo $this->head('css');
echo $this->head('js');
echo $this->head('style');

if ( !empty($this->system['google_analytic']) ){
// echo "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', '{$this->system['google_analytic']}', 'auto');ga('send', 'pageview');</script>";
    echo '<script async src="https://www.googletagmanager.com/gtag/js?id='.$this->system['google_analytic'].'"></script>';
    echo "<script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{$this->system['google_analytic']}');
        </script>";
}

// <!--[if lt IE 10]>
// <script>var ie = true;</script>
// <![endif]-->

echo '</head>';

if( $this->elem("body")->attr() ){

    $attributes = "";
    foreach ($this->elem("body")->attr() as $key => $value) {
        $attributes .= " {$key}=\"{$value}\"";
    }

    echo '<body'.$attributes.'>';
	
}
else{
    echo '<body>';
}
?>