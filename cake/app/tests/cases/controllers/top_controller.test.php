<?php
class TopControllerTest extends CakeTestCase {
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
     $result = $this->testAction('/top/top',array('return'=>'result'));
     debug($result);
   }

   function testTop(){

   }

   function testStatus(){

   }

   function testCheck(){
     $a = 'hoge';
     $b = 'hoge';
     $this->assertEqual($a, $b);
     $a = $b;
     $this->assertEqual($a, $b);
   }

   function testChecked(){
     $result = $this->testAction('/top/top');
     debug($result);
   }

}
?>