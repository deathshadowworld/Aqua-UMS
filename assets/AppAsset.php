<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/styles.css',
        #'assets/styles.css',
        #'https://cdn.discordapp.com/attachments/616833107965771776/1257583325871079555/styles.css?ex=6684ef3d&is=66839dbd&hm=e5b236d68ceba80128f20bf1993fd7413898a0ff2bbcc04bdb727de659b9e95a&',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js',
        #'assets/script.js',
        'css/script.js',
        #'https://cdn.discordapp.com/attachments/617712184553766924/1128138333227327538/script.js?ex=6684abb2&is=66835a32&hm=22659eab1374d71cdf2ceb8a3891c46e786fbfe8e8c426cfb49411457455333f&',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
