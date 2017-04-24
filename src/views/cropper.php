<?php

use yii\bootstrap\Html;
use yii\web\View;

/** @var $this View */
/** @var $cropperOptions mixed */
/** @var $inputOptions  mixed */
//imagecroplv\CropperAsset::register($this);
rklandesverband\imagecropmassenupload\CroppermassenuploadAsset::register($this);


$unique = uniqid('cropper_');


$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];
$aspectRatio = $cropWidth / $cropHeight;

$browseLabel = $cropperOptions['icons']['browse'] . ' ' . Yii::t('cropper', 'Browse');
$cropLabel = $cropperOptions['icons']['crop'] . ' ' . Yii::t('cropper', 'Crop');
$closeLabel = $cropperOptions['icons']['close'] . ' ' . Yii::t('cropper', 'Crop') . ' & ' . Yii::t('cropper', 'Close');

$label = $inputOptions['label'];
if ($label !== false) {
    $browseLabel = $cropperOptions['icons']['browse'] . ' ' . $label;
}
?>

<input type="hidden" id="<?= $inputOptions['id'] ?>_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>]" title="" >
<input type="hidden" id="preview_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>][preview]" title="" value="<?= $cropperOptions['preview']['image'] ?>">
<input type="hidden" id="basename_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>][basename]" title="" value="<?= $cropperOptions['preview']['basename'] ?>">
<input type="hidden" id="x_<?= $inputOptions['id'] ?>_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>][x]" />
<input type="hidden" id="y_<?= $inputOptions['id'] ?>_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>][y]" />
<input type="hidden" id="w_<?= $inputOptions['id'] ?>_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>][w]" />
<input type="hidden" id="h_<?= $inputOptions['id'] ?>_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>][h]" />

<div class="cropper-container ">



<?=
Html::button($browseLabel, [
    'class' => 'btn btn-primary',
    'data-toggle' => 'modal',
    'data-target' => '#cropper-modal-' . $unique,
    //'data-keyboard' => 'false',
    'data-backdrop' => 'static',
])
?>

    <?php if ($cropperOptions['preview'] !== false) : ?>
        <?php $preview = $cropperOptions['preview']; ?>
        <div class="cropper-result <?php if ($cropperOptions['preview']['error'] == 1): ?>error<?php endif; ?>" id="cropper-result-<?= $unique ?>" style="margin-top: 10px; width: <?= $preview['width'] ?>px; height: <?= $preview['height'] ?>px; border: 1px dotted #bfbfbf">
        <?php
        if (isset($preview['url'])) {
            echo Html::img($preview['url'], ['width' => $preview['width'], 'height' => $preview['height']]);
        }
        ?>
        </div>

        <?php endif; ?>

</div>
<div class="form-group">
<label class="control-label">Personalnummer </label>
<input type="number" class="form-control" id="pnr_<?= $inputOptions['id'] ?>_<?= $unique ?>" name="<?= $inputOptions['name'] ?>[<?= $unique ?>][pnr]" value="<?= $cropperOptions['preview']['pnr'] ?>" />
</div>

<?php $this->registerCss('

     .field-personalfoto-image{
        float: left;
        margin: 10px;
         }
    label[for=' . $inputOptions['id'] . '] {
        display: none;
    }
    #cropper-modal-' . $unique . ' img{
        max-width: 100%;
    }
    #cropper-modal-' . $unique . ' .btn-file {
        position: relative;
        overflow: hidden;
    }
    #cropper-modal-' . $unique . ' .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    #cropper-modal-' . $unique . ' .input-group .input-group-addon {
        border-radius: 0;
        border-color: #d2d6de;
        background-color: #efefef;
        color: #555;
    }
    #cropper-modal-' . $unique . ' .height-warning.has-success .input-group-addon,
    #cropper-modal-' . $unique . ' .width-warning.has-success .input-group-addon{
        background-color: #00a65a;
        border-color: #00a65a;
        color: #fff;
    }
    #cropper-modal-' . $unique . ' .height-warning.has-error .input-group-addon,
    #cropper-modal-' . $unique . ' .width-warning.has-error .input-group-addon{
        background-color: #dd4b39;
        border-color: #dd4b39;
        color: #fff;
    }
') ?>


<?php
$inputId = $inputOptions['id'] . '_' . $unique;

$modal = $this->render('modal', [
    'unique' => $unique,
    'cropperOptions' => $cropperOptions,
        ]);



$this->registerJs(<<<JS
    
    $('body').prepend('$modal');

    var options_$unique = {
        croppable: false,
        croppedCanvas: '',
        
        element: {
            modal: $('#cropper-modal-$unique'),
            image: $('#cropper-image-$unique'),
            _image: document.getElementById('cropper-image-$unique'),
           
            result: $('#cropper-result-$unique')        
        },
        
        input: {
            model: $('#$inputId'),
            preview: $('#preview_$unique'),
            crop: $('#cropper-input-$unique')
        },
        
        button: {
            crop: $('#crop-button-$unique'),
            close: $('#close-button-$unique'),
        },
        
        data: {
            cropWidth: $cropWidth,
            cropHeight: $cropHeight,
            scaleX: 1,
            scaleY: 1,
            width: '',
            height: '',
            X: '',
            Y: ''
        },
     
        inputData: {
            width: $('#dataWidth-$unique'),
            height: $('#dataHeight-$unique'),
            X: $('#dataX-$unique'),
            Y: $('#dataY-$unique')
        }
    };
    
    function processfile$unique(imageURL) {
        
        var image = new Image();
       
        var onload = function () {
            
            var canvas = document.createElement("canvas");
            canvas.width = this.width;
            canvas.height = this.height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(this, 0, 0);
          
            canvas.toBlob(function(blob) {
                $('#cropper-modal-$unique').find('.modal-body').find('img').attr('src',URL.createObjectURL(blob));
            });
        };

        image.onload = onload;
        image.src = imageURL;
    }

    
    
   
    options_$unique.input.crop.change(function(event) {
        // cropper reset
        options_$unique.croppable = false;
        options_$unique.element.image.cropper('destroy');        
        options_$unique.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');
        
        
        // image loading        
        
        if (typeof event.target.files[0] === 'undefined') {
            options_$unique.element._image.src = "";
            return;
        }       
             
        options_$unique.element._image.src = URL.createObjectURL(event.target.files[0]);
        
       //$('#hidden_personalfoto-image').val(event.target.files[0]);
        var xhr = new XMLHttpRequest;
        xhr.open('GET', options_$unique.element._image.src);
        xhr.responseType = 'blob';

        xhr.onload = function() {
        var recoveredBlob = xhr.response;

        var reader = new FileReader;

        reader.onload = function() {
            var blobAsDataUrl = reader.result;
            // window.location = blobAsDataUrl;
            $('#hidden_personalfoto-image_$unique').val(blobAsDataUrl);
        };

        reader.readAsDataURL(recoveredBlob);
            
        };
        xhr.send();

        // cropper start
        options_$unique.element.image.cropper({
            aspectRatio: $aspectRatio,
            viewMode: 2,
            autoCropArea: 0.5,     
            crop: function (e) {
                
                options_$unique.data.width = Math.round(e.width);
                options_$unique.data.height = Math.round(e.height);
                options_$unique.data.X = e.scaleX;
                options_$unique.data.Y = e.scaleY;                                               
                
                options_$unique.inputData.width.val(Math.round(e.width));
                options_$unique.inputData.height.val(Math.round(e.height));
                options_$unique.inputData.X.val(Math.round(e.x));
                options_$unique.inputData.Y.val(Math.round(e.y));      

                $('#x_personalfoto-image_$unique').val(Math.round(e.x));
                $('#y_personalfoto-image_$unique').val(Math.round(e.y));
                
                $('#w_personalfoto-image_$unique').val(Math.round(e.width));
                $('#h_personalfoto-image_$unique').val(Math.round(e.height));
                
                if (options_$unique.data.width < options_$unique.data.cropWidth) {
                    options_$unique.element.modal.find('.width-warning').removeClass('has-success').addClass('has-error');
                } else {
                    options_$unique.element.modal.find('.width-warning').removeClass('has-error').addClass('has-success');
                }
                
                if (options_$unique.data.height < options_$unique.data.cropHeight) {
                    options_$unique.element.modal.find('.height-warning').removeClass('has-success').addClass('has-error');                   
                } else {
                    options_$unique.element.modal.find('.height-warning').removeClass('has-error').addClass('has-success');                     
                }
            }, 
            
            built: function () {
                options_$unique.croppable = true;               
            }
        });        
    });
    
    
    
    
    function setCrop$unique() {        
        if (!options_$unique.croppable) {
            return;
        }        
        options_$unique.croppedCanvas = options_$unique.element.image.cropper('getCroppedCanvas', {
            width: options_$unique.data.cropWidth,
            height: options_$unique.data.cropHeight
        });
        
        options_$unique.element.result.html('<img src="' + options_$unique.croppedCanvas.toDataURL() + '">');
        
        //options_$unique.input.model.attr('type', 'text');
        options_$unique.input.model.val(options_$unique.croppedCanvas.toDataURL());
    }
    
    
    options_$unique.button.crop.click(function() { setCrop$unique(); });
    options_$unique.button.close.click(function() { setCrop$unique(); });
    processfile$unique(options_$unique.input.preview.val());  
    $('[data-target="#cropper-modal-$unique"]').click(function() {
         
        var src_$unique = $('#cropper-modal-$unique').find('.modal-body').find('img').attr('src'); 
        
        if (src_$unique === '') {
              options_$unique.input.crop.click();
        }else{
           // cropper reset
        options_$unique.croppable = false;
        options_$unique.element.image.cropper('destroy');  
        options_$unique.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');
        options_$unique.element._image.src = src_$unique; 
        
        // cropper start
        options_$unique.element.image.cropper({
            
            aspectRatio: $aspectRatio,
            viewMode: 2,
            autoCropArea: 0.5,     
            crop: function (e) {
                
                options_$unique.data.width = Math.round(e.width);
                options_$unique.data.height = Math.round(e.height);
                options_$unique.data.X = e.scaleX;
                options_$unique.data.Y = e.scaleY;                                               
                 
                options_$unique.inputData.width.val(Math.round(e.width));
                options_$unique.inputData.height.val(Math.round(e.height));
                options_$unique.inputData.X.val(Math.round(e.x));
                options_$unique.inputData.Y.val(Math.round(e.y));      

                $('#x_personalfoto-image_$unique').val(Math.round(e.x));
                $('#y_personalfoto-image_$unique').val(Math.round(e.y));
                
                $('#w_personalfoto-image_$unique').val(Math.round(e.width));
                $('#h_personalfoto-image_$unique').val(Math.round(e.height));
                
                if (options_$unique.data.width < options_$unique.data.cropWidth) {
                    options_$unique.element.modal.find('.width-warning').removeClass('has-success').addClass('has-error');
                } else {
                    options_$unique.element.modal.find('.width-warning').removeClass('has-error').addClass('has-success');
                }
                
                if (options_$unique.data.height < options_$unique.data.cropHeight) {
                    options_$unique.element.modal.find('.height-warning').removeClass('has-success').addClass('has-error');                   
                } else {
                    options_$unique.element.modal.find('.height-warning').removeClass('has-error').addClass('has-success');                     
                }
            }, 
            
            built: function () {
                options_$unique.croppable = true;               
            }
               
    });
           }
    });
    
    
    options_$unique.element.modal.find('.move-left').click(function() { 
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('move', -10, 0);
    });
    options_$unique.element.modal.find('.move-right').click(function() {
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('move', 10, 0);     
    });
    options_$unique.element.modal.find('.move-up').click(function() { 
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('move', 0, -10);      
    });
    options_$unique.element.modal.find('.move-down').click(function() { 
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('move', 0, 10);
    });
    options_$unique.element.modal.find('.zoom-in').click(function() {
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('zoom', 0.1); 
    });
    options_$unique.element.modal.find('.zoom-out').click(function() {
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('zoom', -0.1);         
    });
    options_$unique.element.modal.find('.rotate-left').click(function() { 
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('rotate', -15);
    });
    options_$unique.element.modal.find('.rotate-right').click(function() { 
        if (!options_$unique.croppable) return;
        options_$unique.element.image.cropper('rotate', 15); 
    });
    
    
JS
        , View::POS_END)
?>
