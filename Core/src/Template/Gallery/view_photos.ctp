<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">

<body>
    <div class="photo-gallery my-3">
        <div class="container">
            <div class="intro">
                <h2 class="text-center"> <?= $photos[0]['album_title'] ?></h2>
                <p class="text-center"><?= $photos[0]['description'] ?></p>
            </div>
            <div class="row photos">
                <?php foreach ($photos as $photo) {
                    $path = $this->Url->image('/webroot/uploads/gallery/regularSize/' . $photo['regular_size']); ?>
                    <div class="mt-3 col-sm-6 col-md-4 col-lg-3 item"><a href="<?= $path ?>" data-lightbox="photos"><?php echo $this->Html->image('/webroot/uploads/gallery/regularSize/' . $photo['regular_size'], ['alt' => $photo['photos_title'], 'class' => 'img-fluid']); ?></a></div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
</body>

</html>
