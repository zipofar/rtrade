<h1>List Of Films</h1>

<ul>
    <?php foreach ($films as $film) : ?>
    <li>
        <a href="<?= $this->createUrl('adminfilm/show', ['id' => $film->id]) ?>">
            <?= $film->name ?>
        </a>
        <div class="form">
        <?php $form = $this->beginWidget('CActiveForm'); ?>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Delete'); ?>
            </div>

        <?php $this->endWidget(); ?>
        </div><!-- form -->
    </li>
    <?php endforeach ?>
</ul>

<?php $this->widget('CLinkPager', ['pages' => $pages]) ?>
