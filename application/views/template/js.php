<!-- jQuery  -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="<?= base_url() ?>assets/template/assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/template/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/template/assets/js/jquery.slimscroll.js"></script>
<script src="<?= base_url() ?>assets/template/assets/js/waves.min.js"></script>

<script src="<?= base_url()  ?>assets/template/plugins/moment/moment.js"></script>
<script src="<?= base_url()  ?>assets/template/plugins/moment/locale/id.js"></script>

<!-- chartjs js -->
<script src="<?= base_url() ?>assets/template/plugins/chartjs/chart.min.js"></script>

<script src="<?= base_url(); ?>assets/input_spinner/dist/js/jquery.input-counter.min.js"></script>

<!--Summernote js-->
<script src="<?= base_url() ?>assets/summernote/summernote-bs4.min.js"></script>

<!-- Sweet Alerts js -->
<script src="<?= base_url() ?>assets/swa/sweetalert2.all.min.js"></script>

<!-- select2 -->
<script src="<?= base_url() ?>assets/select2/select2.min.js"></script>

<!-- numeric -->
<script src="<?= base_url(); ?>assets/numeric/jquery.numeric-only.js"></script>
<!-- number separator -->
<script src="<?= base_url(); ?>assets/number_divider/dist/number-divider.min.js"></script>

<script src="<?= base_url() ?>assets/template/plugins/tinymce/tinymce.min.js"></script>

<!-- Required datatable js -->
<script src="<?= base_url() ?>assets/template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url() ?>assets/template/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url() ?>assets/template/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Plugins js -->
<script src="<?= base_url() ?>assets/template/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="<?= base_url() ?>assets/template/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
<!-- Plugins Init js -->
<script src="<?= base_url() ?>assets/template/assets/pages/form-advanced.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>

<!-- tinymce -->
<script src="<?= base_url() ?>assets/tinymce/tinymce.min.js" type="text/javascript"></script>

 <!-- Parsley js -->
 <script src="<?= base_url() ?>assets/template/plugins/parsleyjs/parsley.min.js"></script>
 <script src="<?= base_url() ?>assets/bootstrap4_toggle/js/bootstrap4-toggle.min.js"></script>

 <script src="<?= base_url() ?>assets/template/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- App js -->
<script src="<?= base_url() ?>assets/template/assets/js/app.js"></script>



<script>

    
    // var unloadHandler = function(e){
    //     //here ajax request to close session
    //     $.ajax({
    //         url             : "<?= base_url('Auth/out_js') ?>",
    //         method          : "POST",
    //         dataType        : "JSON",
    //         success         : function (data) {
                
                
    //         }

    //     })

    //     return false;
    // };
    // window.unload = unloadHandler;

    $(document).ready(function () {

        $('.dataTables_wrapper').removeClass('container-fluid');

        var interval = setInterval(function() {
        var momentNow = moment();
            $('.date-part').html(momentNow.format('dddd')
                                .toUpperCase() + ', ' +
                                momentNow.format('DD MMMM YYYY')
                                );
            $('.tgl-part').html(momentNow.format('dddd')
                                .toUpperCase() + '<br>' +
                                momentNow.format('DD MMMM YYYY')
                                );
            $('.time-part').html(momentNow.format('HH:mm:ss'));
        }, 100);

        $('.numeric').numericOnly();

        $('.number_separator').divide({
            delimiter:'.',
            divideThousand: true, // 1,000..9,999
            delimiterRegExp: /[\.\,\s]/g
        });

        $('.number_separator2').divide({
            delimiter:'.',
            divideThousand: true, // 1,000..9,999
            delimiterRegExp: /[\.\,\s]/g
        });

        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: false,
            format: "dd-mm-yyyy",
            clearBtn: true,
            orientation: 'auto'
        });

        $('.datepicker_bulan').datepicker( {
            format: "MM yyyy",
            minViewMode: 1,
            autoclose: true,
            clearBtn: true,
            orientation: 'bottom'
        });

        $(".datepicker_bulan").datepicker("setDate", new Date());

        var options = {
            selectors: {
                addButtonSelector		: '.btn-add',
                subtractButtonSelector	: '.btn-subtract',
                inputSelector			: '.counter',
            },
            settings: {
                checkValue: true,
                isReadOnly: false,
            },
        };

        $(".input-counter").inputCounter(options);

        // $('select').each(function () {
        //     $(this).select2({
        //         theme       : 'bootstrap4',
        //         width       : 'style',
        //         placeholder : $(this).attr('placeholder'),
        //         allowClear  : true
        //     });
        // });

        $('.select2').select2({
            theme       : 'bootstrap4',
            width       : 'style',
            placeholder : $(this).attr('placeholder'),
            allowClear  : false
        });

        $('body').tooltip({
            selector: '.ttip',
            trigger : 'hover'
        });

        $('[data-toggle="tooltip"]').click(function () {
            $('[data-toggle="tooltip"]').tooltip("hide");
        });

        $('.summernote').summernote({
            height: 300,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true                // set focus to editable area after initializing summernote
        });

        tinymce.init({
            selector: "textarea.tiny",
            theme: "modern",
            height:300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ],
            // setup: function (editor) {
            //     editor.on('change', function () {
            //         tinymce.triggerSave();
            //     });
            // }
            setup: function(editor) {
                editor.on('init', function(e) {
                console.log('The Editor has initialized.');
                });
            }
        });

    })
</script>
