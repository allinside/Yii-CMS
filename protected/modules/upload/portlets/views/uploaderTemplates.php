<script id="template-upload" type="text/x-jquery-tmpl">
    <tr class="template-upload{{if error}} ui-state-error{{/if}}">
        <td class="preview"></td>
        <td class="name">${name}</td>
        <td class="size">${sizef}</td>
        {{if error}}
            <td class="error" colspan="2">Error:
                {{if error === 'maxFileSize'}}<?php echo Yii::t('UploadModule.interface', 'Файл слишком велик') ?>
                {{else error === 'minFileSize'}}<?php echo Yii::t('UploadModule.interface', 'Файл слишком мал') ?>
                {{else error === 'acceptFileTypes'}}<?php echo Yii::t('UploadModule.interface', 'Запрещенный тип файла') ?>
                {{else error === 'maxNumberOfFiles'}}<?php echo Yii::t('UploadModule.interface', 'Превышено колличество файлов') ?>
                {{else}}${error}
                {{/if}}
            </td>
        {{else}}
            <td class="progress"><div></div></td>
            <td class="start"><button>Start</button></td>
        {{/if}}
        <td class="cancel"><button>Cancel</button></td>
    </tr>
</script>
<script id="template-download" type="text/x-jquery-tmpl">
    <tr id="${id}" class="template-download{{if error}} ui-state-error{{/if}}">
        {{if error}}
            <td></td>
            <td class="name">${name}</td>
            <td class="size">${sizef}</td>
            <td class="error" colspan="2">Error:
                {{if error === 1}}  <?php echo Yii::t('UploadModule.interface', 'Файл превышает размер допустимый сервером (php.ini директива)') ?>
                {{else error === 2}}<?php echo Yii::t('UploadModule.interface', 'файл слишком велик (HTML директива)') ?>
                {{else error === 3}}<?php echo Yii::t('UploadModule.interface', 'Только часть файла была загружена') ?>
                {{else error === 4}}<?php echo Yii::t('UploadModule.interface', 'Файл не был загружен') ?>
                {{else error === 5}}<?php echo Yii::t('UploadModule.interface', 'Пропущена временная директория') ?>
                {{else error === 6}}<?php echo Yii::t('UploadModule.interface', 'Ошибка при записи файла на диск') ?>
                {{else error === 7}}<?php echo Yii::t('UploadModule.interface', 'Неверное расширение файла') ?>
                {{else error === 'maxFileSize'}}<?php echo Yii::t('UploadModule.interface', 'Файл слишком велик') ?>
                {{else error === 'minFileSize'}}<?php echo Yii::t('UploadModule.interface', 'Файл слишком мал') ?>
                {{else error === 'acceptFileTypes'}}<?php echo Yii::t('UploadModule.interface', 'Запрещенный тип файла') ?>
                {{else error === 'maxNumberOfFiles'}}<?php echo Yii::t('UploadModule.interface', 'Превышено колличество файлов') ?>
                {{else error === 'uploadedBytes'}}<?php echo Yii::t('UploadModule.interface', 'Загружаемый файлы превысил допустимые размеры') ?>
                {{else error === 'emptyResult'}}<?php echo Yii::t('UploadModule.interface', 'Файл пуст') ?>
                {{else}}${error}
                {{/if}}
            </td>
        {{else}}
            <td class="preview">
                {{if thumbnail_url}}
                    <img height="48" src="${thumbnail_url}">
                {{/if}}
            </td>
            <td class="name">${name}</td>
            <td class="size">${sizef}</td>
            {{if has_watermark}}
                <td class="watermark-ready">
                    <span>Установлен</span>
                </td>
            {{else}}
                <td>
                    <div class="watermark">
                        <a href="/upload/files/setWatermark/position/LT" style="background: url(<?php echo $this->assets.'/img/lt.png'?>); left:0px;top:0px"></a>
                        <a href="/upload/files/setWatermark/position/RT" style="background: url(<?php echo $this->assets.'/img/rt.png'?>); left:22px;top:0px"></a>
                        <br/>
                        <a href="/upload/files/setWatermark/position/center" style="background: url(<?php echo $this->assets.'/img/ltbr.png'?>) no-repeat; left:13px;top:18px" ></a>
                        <br/>
                        <a href="/upload/files/setWatermark/position/LB" style="background: url(<?php echo $this->assets.'/img/lb.png'?>); left:0px;top:32px" ></a>
                        <a href="/upload/files/setWatermark/position/RB" style="background: url(<?php echo $this->assets.'/img/rb.png'?>); left:22px;top:32px" ></a>
                    </div>

                </td>
            {{/if}}
            <td class="dnd-handler"><img height="20" src="<?php echo $this->assets?>/img/hand.png" /></td>
            <td>{{html edit_link}}</td>
        {{/if}}
        <td class="delete">
            <button data-type="${delete_type}" data-url="${delete_url}">Delete</button>
        </td>
    </tr>
</script>
