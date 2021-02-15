<div class="container">
    <?php if ($this->session->flashdata('notif')) : ?>
        <div class="row mt-3">
            <div class="col-md-4 alert alert-<?= $this->session->flashdata('alert') ?> alert-dismissible fade show">
                Post <strong><?= $this->session->flashdata('tipe') ?></strong> <?= $this->session->flashdata('notif') ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-4 d-flex justify-content-between">
            <h1>Artikel</h1>
            <?php if (logged_in()) : ?>
                <a href="<?= base_url() ?>post/tambah" class="btn btn-primary align-self-center">Tambah Post</a>
            <?php endif; ?>
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
                    <?php if (logged_in()) : ?>
                        <a role="button" href="" class="btn btn-primary">Lihat &raquo;</a>
                        <a role="button" href="<?= base_url() ?>post/update/<?= $post['id_post'] ?>" class="btn btn-success">Update</a>
                        <a href="<?= base_url() ?>post/hapus/<?= $post['id_post'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus Post?')">Hapus</a>
                    <?php endif; ?>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>


    </div>
</div>