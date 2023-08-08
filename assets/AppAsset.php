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
        #'https://cdn.discordapp.com/attachments/616833107965771776/1097357861010546798/styles.css',
        '/home/ec2-user/Aqua-UMS/web/assets/styles.css',
        #'https://cdn.discordapp.com/attachments/617712184553766924/1136522776845496360/styles.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js',
        '/home/ec2-user/Aqua-UMS/web/assets/script.js',
        #'https://cdn.discordapp.com/attachments/617712184553766924/1128138333227327538/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
