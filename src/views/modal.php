<?php
/**
 *
 * this html text must be 1 line for javascript content
 *
 */
/** @var $unique string */
/** @var $cropperOptions [] */

$modalLabel = Yii::t('cropper', 'Image Crop Editor');
$browseLabel = $cropperOptions['icons']['browse'] . ' ' . Yii::t('cropper', 'Browse');
$cropLabel = $cropperOptions['icons']['crop'] . ' ' . Yii::t('cropper', 'Crop');
$closeLabel = $cropperOptions['icons']['close'] . ' ' . Yii::t('cropper', 'Crop') . ' & ' . Yii::t('cropper', 'Close');

$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];
?>
<div class="modal fade" tabindex="-1" role="dialog" id="cropper-modal-<?= $unique ?>"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="modalLabel-<?= $unique ?>"><?= $modalLabel ?></h4></div><div class="modal-body"><div><img id="cropper-image-<?= $unique ?>" src="" alt=""></div></div><div class="modal-footer"><div class="row" style="margin-bottom: 10px"><div class="col-sm-3"><div class="input-group input-group-sm width-warning"><label class="input-group-addon" for="dataWidth-<?= $unique ?>"><?= Yii::t('cropper', 'Width') ?> (<?= $cropWidth ?>px)</label><input type="text" class="form-control" id="dataWidth-<?= $unique ?>" placeholder="width"><span class="input-group-addon">px</span></div></div><div class="col-sm-3"><div class="input-group input-group-sm height-warning"><label class="input-group-addon" for="dataHeight-<?= $unique ?>"><?= Yii::t('cropper', 'Height') ?> (<?= $cropHeight ?>px)</label><input type="text" class="form-control" id="dataHeight-<?= $unique ?>" placeholder="height"><span class="input-group-addon">px</span></div></div><div class="col-sm-3"><div class="input-group input-group-sm"><label class="input-group-addon" for="dataX-<?= $unique ?>">X</label><input type="text" class="form-control" id="dataX-<?= $unique ?>" placeholder="x"><span class="input-group-addon">px</span></div></div><div class="col-sm-3"><div class="input-group input-group-sm"><label class="input-group-addon" for="dataY-<?= $unique ?>">Y</label><input type="text" class="form-control" id="dataY-<?= $unique ?>" placeholder="y"><span class="input-group-addon">px</span></div></div></div><div class="pull-left"><span class="btn btn-primary btn-file"><?= $browseLabel ?><input type="file" id="cropper-input-<?= $unique ?>" title="<?= Yii::t('cropper', 'Browse') ?>" accept="image/*"></span>&nbsp;<div class="btn-group"><button type="button" class="btn btn-primary zoom-in"><span class="glyphicon glyphicon-zoom-in"></span></button><button type="button" class="btn btn-primary zoom-out"><span class="glyphicon glyphicon-zoom-out"></span></button></div>&nbsp;</div><button type="button" id="crop-button-<?= $unique ?>" class="btn btn-success"><?= $cropLabel ?></button><button type="button" id="close-button-<?= $unique ?>" class="btn btn-danger" data-dismiss="modal"><?= $closeLabel ?></button></div></div></div></div>