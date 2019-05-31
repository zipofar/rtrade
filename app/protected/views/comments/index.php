<?php
/* @var $this CommentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Comments',
);

$this->menu=array(
    array('label'=>'Manage Comments', 'url'=>array('admin')),
);
?>

<h1>Comments</h1>

<div>
    <?php foreach ($comments as $comment) : ?>
    <i>Film Name: <?= $comment->film->name ?></i>
    <br>
    <a href="<?= $this->createUrl('comments/view', ['id' => $comment->id]) ?>">Edit</a>
    <p><?= $comment->content ?></p>
    <?php endforeach ?>
</div>

<?php $this->widget('CLinkPager', ['pages' => $pages]) ?>
