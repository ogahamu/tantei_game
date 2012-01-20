<?php
class ArticlesControllerTest extends CakeTestCase {
   function startCase() {
     echo '<h1>テストケースを開始します</h1>';
   }
   function endCase() {
     echo '<h1>テストケースを終了します</h1>';
   }
   function startTest($method) {
     echo '<h3>メソッド「' . $method . '」を開始します</h3>';
   }
   function endTest($method) {
     echo '<hr />';
   }
   function testIndex() {
     $result = $this->testAction('/articles/index');
     debug($result);
   }
   function testIndexShort() {
     $result = $this->testAction('/articles/index/short');
     debug($result);
   }
   function testIndexShortGetRenderedHtml() {
     $result = $this->testAction('/articles/index/short',
     array('return' => 'render'));
     debug(htmlentities($result));
   }
   function testIndexShortGetViewVars() {
     $result = $this->testAction('/articles/index/short',
     array('return' => 'vars'));
     debug($result);
   }
   function testIndexFixturized() {
     $result = $this->testAction('/articles/index/short',
     array('fixturize' => true));
     debug($result);
   }
   function testIndexPostFixturized() {
     $data = array('Article' => array('user_id' => 1, 'published'
          => 1, 'slug'=>'new-article', 'title' => '新しい記事', 'body' => '新しい記事の本文'));
     $result = $this->testAction('/articles/index',
     array('fixturize' => true, 'data' => $data, 'method' => 'post'));
     debug($result);
   }
}
?>