<?php

class Post {
  public function __construct($year, $month, $day, $slug, $ext='textile') {
    $ext = self::get_extension("$year-$month-$day-$slug");
    $file = @file_get_contents(POSTS_DIR."/$year-$month-$day-$slug.$ext");
    if (!$file) return false;
    $split_post_file = explode("\n\n", $file, 2);
    if (count($split_post_file) != 2) return false;
    $this->post_settings = $this->parse_settings($split_post_file[0]);
    if (!isset($this->post_settings['title'])) return false;

    $this->year = $year;
    $this->month = $month;
    $this->day = $day;
    $this->slug = $slug;
    $this->title = trim($this->post_settings['title']);
    $this->content = self::get_html($split_post_file[1], $ext);
  }
  // getters
  public function get_url() {
    global $config;
    return "{$config['base_url']}/{$this->year}/{$this->month}/{$this->day}/{$this->slug}";
  }
  public function get_excerpt() {
    global $config;
    return truncate_html(strip_tags($this->content, '<p><br>'), $config['max']);
  }
  private function parse_settings($post_header) {
    $lines = explode("\n", $post_header);
    $settings = array();
    foreach ($lines as $line) {
      $split_line = explode(":", $line, 2);
      if (count($split_line) == 2) {
        $settings[$split_line[0]] = $split_line[1];
      }
    }
    return $settings;
  }
  // get html from (markdown|textile|html) string
  public static function get_html($string, $ext) {
    if ($ext == 'html') return $string;
    // set function to be called to compile in HTML:
    if ($ext == 'md' || $ext == 'markdown') { $func = 'Markdown'; }
    elseif ($ext == 'textile') { $func = $ext; }
    return isset($func) ? $func($string) : $string;
  }
  // takes a file's basename and return it's extension if it exists
  public static function get_extension($basename, $is_page=false) {
    $base_dir = $is_page ? PAGES_DIR : POSTS_DIR;
    if       (file_exists($base_dir."/$basename.textile")) {
      return 'textile';
    } elseif (file_exists($base_dir."/$basename.md")) {
      return 'md';
    } elseif (file_exists($base_dir."/$basename.markdown")) {
      return 'markdown';
    } elseif (file_exists($base_dir."/$basename.html")) {
      return 'html';
    } else { // file not found
      return false;
    }
  }
}
