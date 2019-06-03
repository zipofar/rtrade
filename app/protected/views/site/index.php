<?php
/* @var $this FilmController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Films',
);
?>

<h1>Films</h1>

<ul>
    <?php foreach ($films as $film) : ?>
    <li>
        <a href="<?= $this->createUrl('site/view', ['id' => $film->id]) ?>">
            <?= $film->name ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>

<?php $this->widget('CLinkPager', ['pages' => $pages]) ?>
