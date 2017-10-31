<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $jsOptions = array(
        'position' => \yii\web\View::POS_BEGIN
    );
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?3',
        'css/font-awesome.min.css',
        'css/bootstrap.min.css',
        'css/magnific-popup.css',
        'css/style.css?20',
        'css/responsive.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/jquery.magnific-popup.min.js',
        'js/jquery.scrollUp.min.js',
        'js/main.js?2',
        'js/jquery.animate-colors.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
