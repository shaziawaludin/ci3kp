<div class="container">
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Update Post
                </div>
                <div class="card-body">
                    <form action="<?= base_url(); ?>post/update/<?= $post['id_post'] ?>" method="POST">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" name="judul" id="judul" placeholder="Masukkan Judul" value="<?= $post['judul'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="isi">Isi </label>
                            <textarea class="form-control" name="isi" id="isi" placeholder="Masukkan Isi" rows="3" required><?= $post['isi'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= base_url() ?>post" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>