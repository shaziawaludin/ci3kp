<div class="container">
    <form action="<?= base_url(); ?>post/prosesTambah" method="POST">
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Masukkan Judul" required>
        </div>
        <div class="form-group">
            <label for="isi">Isi </label>
            <textarea class="form-control" name="isi" id="isi" placeholder="Masukkan Isi" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>