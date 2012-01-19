<?php

/*
 * トランザクション用
 *
 */

class TransactionComponent extends Object{
  //static $models;

  public function begin($models) {
    // インスタンス変数へ格納⇒commit,rollback時に利用する
    $this->models = $models;
    //各モデル毎にトランザクションを開始
    foreach ($models as $model) {
      if (!$model->begin()) {
      //トランザクション開始失敗時の処理
        echo '失敗';
        break;
      }
    }
  }

  public function commit() {
    $models = $this->models;
    //各モデル毎にトランザクションを開始
    foreach ($models as $model) {
      if (!$this->commit($model)) {
        //トランザクション開始失敗時の処理
        break;
      }
    }
  }

  public function rollback() {
    $models = $this->models;
    //各モデル毎にトランザクションを開始
    foreach ($models as $model) {
      if (!$this->rollback($model)) {
        //トランザクション開始失敗時の処理
        break;
      }
    }
  }
}