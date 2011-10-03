<div id="<?php echo $this->id ?>" class="uploader">
    <form action="<?php echo $uploadUrl ?>" method="POST" enctype="multipart/form-data">
        <div class="fileupload-buttonbar">
            <label class="fileinput-button">
                <span>Добавить файлы...</span>
                <input type="file" name="file" multiple>
            </label>
            <button type="submit" class="start">Начать загрузку</button>
        </div>
    </form>
    <div id="<?php echo $this->id ?>-drop-zone" class="drop-zone">
        Перетащите сюда файлы
    </div>
    <div class="fileupload-content">
        <table class="files"><tbody></tbody></table>
        <div class="fileupload-progressbar"></div>
    </div>
</div>

