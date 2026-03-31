<style>
    .upload-section {
        margin: 20px 0;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
    }

    .preview-container {
        display: none;
        margin-top: 20px;
        padding: 20px;
        border: 2px dashed #ccc;
        border-radius: 5px;
        max-height: 500px;
        overflow-y: auto;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .preview-item {
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: white;
    }

    .preview-item img {
        max-width: 100%;
        max-height: 120px;
        border-radius: 3px;
    }

    .preview-item .filename {
        margin-top: 5px;
        font-size: 12px;
        color: #666;
        word-break: break-word;
    }

    .status-info {
        margin: 10px 0;
        padding: 10px;
        background: #e7f3ff;
        border-left: 4px solid #2196F3;
        border-radius: 3px;
    }

    .option-group {
        margin: 15px 0;
    }

    .option-group label {
        margin-left: 8px;
        font-weight: normal;
    }
</style>

<?php
$this->Form->unlockField('image_name');
$this->Form->unlockField('session_id');
$this->Form->unlockField('shift_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('replace_existing');
$this->Form->unlockField('preview_mode');


$data['session_id'] = isset($data['session_id']) ? $data['session_id'] : $active_session_id;
$shift_id = isset($shift_id) ? $shift_id : '';
$level_id = isset($level_id) ? $level_id : '';
$section_id = isset($section_id) ? $section_id : '';

?>

<div class="container">

    <h3 class="text-center mt-3 mb-4">
        <?= __d('students', 'Upload Student Images (ZIP)') ?>
    </h3>

    <?= $this->Form->create(null, [
        'type' => 'file',
        'id'   => 'uploadForm'
    ]) ?>

    <!-- ================= FILTER SECTION (UNCHANGED) ================= -->
    <section class="bg-light mt-1 p-2 m-auto">
        <fieldset>
            <div class="form_area p-2">

                <!-- ROW 1 -->
                <div class="row mb-3">

                    <!-- SESSION -->
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('students', 'Session') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select name="session_id" id="session_id" class="form-control" required>
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($sessions as $session) { ?>
                                        <option value="<?= $session['session_id'] ?>"
                                            <?= (!empty($data['session_id']) && $data['session_id'] == $session['session_id']) ? 'selected' : '' ?>>
                                            <?= $session['session_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>

                    <!-- SHIFT -->
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('students', 'Shift') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select name="shift_id" id="shift_id" class="form-control" required>
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($shifts as $shift) { ?>
                                        <option value="<?= $shift['shift_id'] ?>"
                                            <?= (!empty($data['shift_id']) && $data['shift_id'] == $shift['shift_id']) ? 'selected' : '' ?>>
                                            <?= $shift['shift_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>

                    <!-- CLASS -->
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('students', 'Class') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select name="level_id" id="level_id" class="form-control" required>
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($levels as $level) { ?>
                                        <option value="<?= $level['level_id'] ?>"
                                            <?= (!empty($data['level_id']) && $data['level_id'] == $level['level_id']) ? 'selected' : '' ?>>
                                            <?= $level['level_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- ROW 2 -->
                <div class="row mb-3">

                    <!-- SECTION -->
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-3">
                                <p class="label-font13"><?= __d('students', 'Section') ?></p>
                            </div>
                            <div class="col-lg-9 row2Field">
                                <select class="form-control" name="section_id" id="section_id" <?php echo $required; ?>>
                                    <?php if (!$required) { ?>
                                        <option value=""><?= __d('students', '-- Choose --') ?></option>
                                    <?php } ?>
                                    <?php foreach ($sections as $section) { ?>
                                        <option value="<?php echo $section['section_id']; ?>"
                                            <?php echo (isset($data['section_id']) && $data['section_id'] == $section['section_id']) ? 'selected' : ''; ?>>
                                            <?php echo $section['section_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </fieldset>
    </section>

    <!-- ================= ZIP UPLOAD ================= -->
    <div class="mt-4 p-3 bg-light border rounded">

        <h5>📦 Upload ZIP File</h5>

        <div class="form-group">
            <label><?= __d('students', 'Student Image ZIP') ?></label>
            <input type="file" name="image_name" id="zipFile"
                class="form-control"
                accept=".zip"
                required>
            <small class="text-muted">
                ZIP must contain images named as <b>sid.jpg</b>
            </small>
        </div>

        <!-- OPTIONS -->
        <div class="mt-2">
            <label>
                <input type="checkbox" name="replace_existing" value="1" checked>
                Replace existing photos
            </label>
        </div>

    </div>

    <!-- ================= PREVIEW ================= -->
    <div id="previewContainer" class="preview-container">
        <h5>Preview Images:</h5>
        <div id="previewStatus" class="status-info"></div>
        <div id="previewGrid" class="preview-grid"></div>
    </div>

    <!-- ================= BUTTONS ================= -->
    <div class="mt-4 text-center">
        <button type="button" id="previewBtn" class="btn btn-info mr-2" style="display:none;">
            🔍 Preview
        </button>
        <button type="submit" class="btn btn-success">
            📤 Upload ZIP
        </button>
    </div>

    <?= $this->Form->end(); ?>

</div>

<script>
    $("#level_id, #shift_id, #session_id").change(function() {
        getSectionAjax();
    });

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        var session_id = $("#session_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
                "shift_id": shift_id,
                "session_id": session_id,
                "type": 'students'
            },
            success: function(data) {
                data = JSON.parse(data);
                var text1 = '';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["section_name"];
                    var id = data[i]["section_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#section_id').html(text1);

            }
        });
    }

    // ZIP preview button
    $('#zipFile').on('change', function() {
        $('#previewBtn').show();
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const zipFile = document.getElementById('zipFile');
        const previewMode = document.getElementById('previewMode');
        const previewBtn = document.getElementById('previewBtn');
        const previewContainer = document.getElementById('previewContainer');
        const previewGrid = document.getElementById('previewGrid');
        const previewStatus = document.getElementById('previewStatus');

        let zipData = null;

        // Show preview button when ZIP is selected
        zipFile.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                previewBtn.style.display = 'inline-block';
                zipData = null; // Reset previous preview
                previewContainer.style.display = 'none';
            }
        });

        // Preview button click handler
        previewBtn.addEventListener('click', function() {
            if (!zipFile.files.length) {
                alert('Please select a ZIP file first');
                return;
            }

            previewStatus.textContent = 'Loading preview...';
            previewContainer.style.display = 'block';
            previewGrid.innerHTML = '';

            const file = zipFile.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                JSZip.loadAsync(e.target.result).then(function(zip) {
                    const images = [];
                    let totalFiles = 0;

                    zip.forEach(function(relativePath, file) {
                        if (!file.dir) {
                            const ext = relativePath.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png'].includes(ext)) {
                                totalFiles++;
                                file.async('base64').then(function(base64) {
                                    images.push({
                                        name: relativePath.split('/').pop(),
                                        src: 'data:image/' + ext + ';base64,' + base64
                                    });

                                    // Update preview when all images loaded
                                    if (images.length === totalFiles) {
                                        updatePreview(images);
                                    }
                                });
                            }
                        }
                    });

                    if (totalFiles === 0) {
                        previewStatus.textContent = 'No image files found in ZIP';
                        previewGrid.innerHTML = '';
                    }
                }).catch(function(err) {
                    previewStatus.textContent = 'Error reading ZIP file: ' + err.message;
                    previewGrid.innerHTML = '';
                });
            };

            reader.readAsArrayBuffer(file);
        });

        function updatePreview(images) {
            previewStatus.textContent = `Found ${images.length} image(s) in ZIP file`;
            previewGrid.innerHTML = '';

            images.forEach(function(img) {
                const item = document.createElement('div');
                item.className = 'preview-item';
                item.innerHTML = `
                <img src="${img.src}" alt="${img.name}">
                <div class="filename">${img.name}</div>
            `;
                previewGrid.appendChild(item);
            });
        }

        // Load JSZip library if not already loaded
        if (typeof JSZip === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js';
            document.head.appendChild(script);
        }
    });
</script>