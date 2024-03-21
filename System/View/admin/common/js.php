<?
$this->CommonObj->loadScripts(array(
    'ajaxupload',
    'popper.min',
), true);
?>
<script src="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/3.3.1/jquery.min.js" type="application/javascript"></script>
<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/4.6.1/js/bootstrap.min.js" type="application/javascript"></script>
<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/ckeditor5/32.0.0/ckeditor.min.js" type="application/javascript"></script>
<link href="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" type="text/css" rel="stylesheet" />
<script src="<?=URL_BOOT?>js/jasny-bootstrap.min.js"></script>
<script src="<?=URL_BOOT?>js/jquery.slimscroll.js"></script>
<script src="<?=URL_BOOT?>js/bootstrap-colorpicker.min.js"></script>
<script src="<?=URL_BOOT?>js/moment.min.js"></script>
<script src="<?=URL_BOOT?>js/jquery.dataTables.min.js"></script>
<script src="<?=URL_BOOT?>js/jquery.sparkline.min.js"></script>
<script src="<?=URL_BOOT?>js/raphael.min.js"></script>
<script src="<?=URL_BOOT?>js/morris.min.js"></script>
<script src="<?=URL_BOOT?>js/Chart.min.js"></script>
<script src="<?=URL_BOOT?>js/jquery.toast.min.js"></script>
<script src="<?=URL_BOOT?>js/Sortable.min.js"></script>
<script src="<?=URL_BOOT?>js/init.js"></script>
<script src="<?=URL_BOOT?>js/Pagination.js"></script>

<script src="https://www.q-cms.cn/Static/scripts/client.js"></script>
<script src="<?=URL_JS?>user.js"></script>
<script type="text/javascript">
    <?=$this->BuildObj->Js?>
</script>
