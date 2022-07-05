<h1>Liste des annonces</h1>

<?php foreach ($annonces as $annonce) : ?>
    <article>
        <h2> <a href="/annonces/lire/<?php echo $annonce->id ?>"><?php echo $annonce->titre ?></a></h2>
        <div><?php echo $annonce->description ?></div>
    </article>
<?php endforeach; ?>