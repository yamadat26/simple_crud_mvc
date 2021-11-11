<?php
class Pages extends Controller
{
  public function __construct() {
    
  }

  public function index() {
    if(isLoggedIn()) {
      redirect('posts');
    }
    $data = [
      'title' => 'SharePosts',
      'description' => 'Simple SNS to share post'
    ];
    
    $this->view('pages/index', $data);
  }

  public function about() {
    $data = [
      'title' => 'About US',
      'description' => 'App to share post with other users',
    ];
    $this->view('pages/about', $data);
  }
}
