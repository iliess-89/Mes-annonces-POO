<h1>Liste des annonces</h1>
<a href="/annonces/ajouter">Ajouter des annonces</a>

<?php foreach ($annonces as $annonce) : ?>
    <article>
        <h2> <a href="/annonces/lire/<?php echo $annonce->id ?>"><?php echo $annonce->titre ?></a></h2>
        <div><?php echo $annonce->description ?></div>
    </article>
<a href="/annonces/modifier/<?= $annonce->id ?>">Modifier des annonces</a>
<?php endforeach; ?>
