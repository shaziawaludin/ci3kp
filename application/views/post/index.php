<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1>Artikel</h1>
        </div>
    </div>
    <!-- <hr> -->
    <div class="row">
        <div class="col">
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
    <div class="row">

        <?php if (isset($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
                <div class="col-md-4 mb-3">
                    <h3 class="text-truncate"><?= $post['judul']; ?></h3>
                    <p class="" style="-webkit-line-clamp:3; overflow:hidden; text-overflow:ellipsis; display: -webkit-box; -webkit-box-orient:vertical;"><?= $post['isi']; ?>
                    </p>
                    <a role="button" href="" class="btn btn-primary">Lihat &raquo;</a>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>


    </div>
</div>