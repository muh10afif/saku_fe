<!-- jquery, popper and bootstrap js -->
<script src="<?= base_url('assets/template_fe/') ?>js/popper.min.js"></script>
<script src="<?= base_url('assets/template_fe/') ?>vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

<!-- cookie js -->
<script src="<?= base_url('assets/template_fe/') ?>vendor/cookie/jquery.cookie.js"></script>

<!-- swiper js -->
<script src="<?= base_url('assets/template_fe/') ?>vendor/swiper/js/swiper.min.js"></script>

<!-- swiper js -->
<script src="<?= base_url('assets/template_fe/') ?>vendor/sparklines/jquery.sparkline.min.js"></script>

<!-- template custom js -->
<script src="<?= base_url('assets/template_fe/') ?>js/main.js"></script>

<!-- page level script -->
<script>
    $(window).on('load', function() {
        $(".sparklinechart").sparkline([5, 6, -7, 2, 0, -4, -2, 4], {
            type: 'bar',
            zeroAxis: false,
            barColor: '#00bf00',
            height: '30',
        });
        $(".sparklinechart2").sparkline([-5, -6, 4, -2, 0, 4, 2, -4], {
            type: 'bar',
            zeroAxis: false,
            barColor: '#00bf00',
            height: '30',
        });

        /* Swiper slider */
        var swiper = new Swiper('.swiper-prices', {
            slidesPerView: 'auto',
            spaceBetween: 0,
            pagination: false,
        });
        var swiper = new Swiper('.swiper-categories', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            pagination: false,
        });
        var swiper = new Swiper('.swiper-shares', {
            slidesPerView: 5,
            spaceBetween: 0,
            pagination: false,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });

        /* status */
        function start() {
            var duration = 4000; // it should finish in 3 seconds !
            $(".statusbar").stop().css("width", 0).animate({
                width: '100%'
            }, {
                duration: duration,
            });

            setTimeout(function() {
                $('#statusmodal').modal('hide');
                $(".statusbar").stop()
                $(".statusbar").css("width", '0');
            }, duration)
        }
        $('#statusmodal').on('shown.bs.modal', function(e) {
            start()
        });
        $('#statusmodal').on('hide.bs.modal', function(e) {
            $(".statusbar").stop().css("width", '0');
        });
    })

</script>