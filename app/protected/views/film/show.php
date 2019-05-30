<h1><?= $film->name ?></h1>

<p><?= $film->description ?></p>
<h2>Comments</h2>
<?php foreach ($film->comments as $comment) : ?>
<div>
    <i><b>User: </b><?= $comment->author->username ?></i>
    <p><?= $comment->content ?></p>
</div>
<?php endforeach ?>
<?php var_dump(Yii::app()->user); ?>
