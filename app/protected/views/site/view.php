<h1><?= $film->name ?></h1>

<p><?= $film->description ?></p>
<h2>Comments</h2>
<?php foreach ($film->comments as $comment) : ?>
<div>
    <i><b>User: </b><?= $comment->author->username ?></i>
    <p><?= $comment->content ?></p>
</div>
<?php endforeach ?>

<div class="form">

    <?php
    $actionUrl = CHtml::normalizeUrl(['comments/create']);
    $form = $this->beginWidget('CActiveForm', [
        'id' => 'comment-form',
        'enableClientValidation' => true,
        'clientOptions' => ['validateOnSubmit' => true],
        'action' => $actionUrl,
    ]); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($newComment); ?>

    <div class="row">
        <?php echo $form->labelEx($newComment, 'content'); ?>
        <?php echo $form->textArea($newComment, 'content', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($newComment, 'content'); ?>
    </div>

    <?php echo CHtml::activeHiddenField($newComment, 'film_id', ['value' => $film->id]); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
