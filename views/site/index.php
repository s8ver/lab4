<?php

use yii\helpers\Html;
use app\models\Categories;
use app\models\Menu;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this yii\web\View */

$this->title = 'Lab 4';
?>
<div class="site-index">
	
	<?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    
    if ( Menu::viewMenuItemsTop('top-menu') ) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => menu::viewMenuItemsTop('top-menu'),
        ]);
    }
    
    NavBar::end();
    ?>
	
</div>
