<h1>List Of Films</h1>

<ul>
    <?php foreach ($films as $film) : ?>
    <li>
        <a href="<?= $this->createUrl('film/show', ['id' => $film->id]) ?>">
            <?= $film->name ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>
