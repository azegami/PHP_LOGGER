<?php
//http://qiita.com/Hiraku/items/71e385b56dcaa37629feより

abstract class Enum
{
    private $scalar;

    function __construct($value)
    {
        $ref = new ReflectionObject($this);

        //定数の連想配列を取得
        $consts = $ref->getConstants();

        //$valueが$constsの値にあるかチェック
        //型チェックをする
        if (! in_array($value, $consts, true)) {
            throw new InvalidArgumentException;
        }

        $this->scalar = $value;
    }

    final static function __callStatic($label, $args)
    {
        //呼び出したクラス名を取得
        $class = get_called_class();

        //定数値を取得
        $const = constant("$class::$label");

        //クラスを作成し渡す
        return new $class($const);
    }

    //元の値を取り出すメソッド。
    final function valueOf()
    {
        return $this->scalar;
    }

    final function __toString()
    {
        return (string)$this->scalar;
    }
}