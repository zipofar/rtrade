<?php
/* @var $this FilmController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Films',
);

if (!Yii::app()->user->isGuest) {
    $this->menu = [
        array('label'=>'Create Film', 'url'=>array('create')),
        array('label'=>'Manage Film', 'url'=>array('admin')),
    ];
}
?>

<h1>Films</h1>

<ul>
    <?php foreach ($films as $film) : ?>
    <li>
        <a href="<?= $this->createUrl('film/view', ['id' => $film->id]) ?>">
            <?= $film->name ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>

<?php $this->widget('CLinkPager', ['pages' => $pages]) ?>
