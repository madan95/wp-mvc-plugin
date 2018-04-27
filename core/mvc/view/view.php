<?php
class View{

  public static function loadTwig(){
    $loader = new Twig_Loader_Filesystem(
        array(
          TWIG_TEMPLATE_CORE
        )
      );
    $twig = new Twig_Environment($loader);
    console('inside loadTwig');
    return $twig;
  }
}
