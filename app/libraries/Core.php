<?php
// App Core class
// Create URL & Loads core controller
// URL format /controller/method/params
class Core {
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct() {
    $url = $this->getUrl();

    // Look in controllers for first value
    // Coreが呼ばれるのはpublic/indexなのでそこからのパスを指定する
    if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
      // If exist, set controller
      $this->currentController = ucwords($url[0]);
      // Unset 0 index
      unset($url[0]);
    }
  
    require_once ('../app/controllers/' . $this->currentController) . '.php';

    // Instantiate contoroller class
    $this->currentController = new $this->currentController;
    // 上記例： $pages = new Pages

    // Check for second part of url
    if(isset($url[1])) {
      // Check to see if method exist in controller
      if(method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
        // Unset 1 index
        unset($url[1]);
      }  
    }
    
    // Get parms
    $this->params = $url ? array_values($url) : [];

    // call a callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getUrl() {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
  }
}
