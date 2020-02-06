<?php
class SSP_Branch {

    /**
     * 外部からのインスタンス化を防ぐ
     */
    private function __construct() {}

    /**
     * 条件分岐タグの結果を取得
     * Conditional_Tags
     */
    public static $is_ = null;
}