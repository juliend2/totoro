<?php

class Response {
  public function __construct($outer_vars) {
    $this->status_code = 200;
    $this->content_type = 'text/html';
    $this->view = 'index.php';
    $this->outer_vars = $outer_vars;
  }
  public function add_vars($outer_vars) {
    // previous variables will be overriden by new with same name
    $this->outer_vars = array_merge($this->outer_vars, $outer_vars);
    return $this;
  }
  // setters
  public function set_view($path) {
    $this->view = $path;
    return $this;
  }
  public function set_status($code) {
    $this->status_code = $code;
    return $this;
  }
  public function set_content_type($type) {
    $this->content_type = $type;
    return $this;
  }
  // response methods
  public function send() {
    $this->respond_with_header();
    $this->respond_with_body();
  }
  private function respond_with_header() {
    if ($this->status_code == 404) {
      header("HTTP/1.0 404 Not Found");
    } else {
      // 200 assumed
      if ($this->content_type == 'application/rss+xml') {
        header("Content-Type: application/rss+xml; charset=utf-8");
      } else {
        // text/html assumed
      }
    }
  }
  private function respond_with_layout() {
    extract($this->outer_vars);
    $view = $this->view;
    include "./themes/{$config['theme']}/layout.php";
  }
  private function respond_with_body() {
    extract($this->outer_vars);
    if ($this->status_code == 404) {
      $this->view = '404.php';
      $this->respond_with_layout();
    } else {
      if ($this->content_type == 'application/rss+xml') {
        include $this->view;
      } else {
        // text/html assumed
        $this->respond_with_layout();
      }
    } 
  }
}
