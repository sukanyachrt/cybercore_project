<?php include("../../include/header.php"); ?>
<link rel="stylesheet" href="../../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
<style>
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
</style>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include("../../include/checkmenu.php"); ?>
            <div class="layout-page">
                <?php include("../../include/navbar.php"); ?>
                <?php
                require_once("../../services/connect_data.php");
                $connect = new Connect_Data();
                $connect->connectData();
                ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="py-3 mb-0">รายงาน</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (!isset($_GET['report']) || $_GET['report'] == "reportsell")
                                            echo "active"; ?>"
                                            href="?report=reportsell">
                                            <img width="30" height="30"
                                                src="../../assets/img/icons/unicons/bestseller.png" alt="bestseller" />
                                            รายงานยอดขาย
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (isset($_GET['report']) && $_GET['report'] == "bestsell")
                                            echo "active"; ?>"
                                            href="?report=bestsell">
                                            <img width="30" height="30" src="../../assets/img/icons/unicons/profit.png"
                                                alt="profit" />
                                            รายงานสินค้าขายดี
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php if (!isset($_GET['report']) || $_GET['report'] == "reportsell") {
                                ?>
                                <div class="col-md-12 mb-4 order-0">
                                    <div class="nav-align-top mb-4">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <button type="button" class="nav-link active" role="tab"
                                                    data-bs-toggle="tab" data-bs-target="#navs-top-year"
                                                    aria-controls="navs-top-year" aria-selected="true">
                                                    รายปี
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#navs-top-month" aria-controls="navs-top-month"
                                                    aria-selected="false">
                                                    รายเดือน
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#navs-top-day" aria-controls="navs-top-day"
                                                    aria-selected="false">
                                                    รายวัน
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="navs-top-year" role="tabpanel">
                                                <div class="row mb-2">
                                                    <div class="col-md-12 text-md-end">
                                                        <a class="btn btn-dark text-end" href="ReportofYear.php">Print</a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive text-nowrap">
                                                    <table class="table table-bordered tbreportsell_year" id="toPrint">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">ปี</th>
                                                                <th class="text-end">ยอดขาย</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbreportsell_year">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="navs-top-month" role="tabpanel">
                                                <div class="input-group mb-4">
                                                    <button class="btn btn-outline-primary" type="button">ค้นหาข้อมูล :
                                                    </button>
                                                    <select class="form-select" id="serachByYear"
                                                        aria-label="Example select with button addon">
                                                        <option selected value="">เลือกปีที่ต้องการ...</option>
                                                        <?php
                                                        $connect->sql = "SELECT YEAR
                                                        ( orders.order_date ) AS yearorder 
                                                        FROM orders WHERE
                                                        order_status > 0 GROUP BY
                                                        YEAR (orders.order_date)";
                                                        $connect->queryData();
                                                        while ($rsconnect = $connect->fetch_AssocData()) {
                                                            $yearorder = $rsconnect['yearorder'];
                                                            ?>
                                                            <option value="<?= $yearorder ?>">
                                                                <?= $yearorder ?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-12 text-md-end">
                                                        <button class="btn btn-dark text-end"
                                                            onclick="printReportofMonth()">Print</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive text-nowrap">
                                                    <table class="table table-bordered tbreportsell_month">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">ปี</th>
                                                                <th class="text-center">เดือน</th>
                                                                <th class="text-end">ยอดขาย</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbreportsell_month">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="navs-top-day" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="start-date form-control"
                                                            placeholder="วันที่เริ่มต้น" value="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="end-date form-control" value=""
                                                                placeholder="วันที่สิ้นสุด">
                                                            <button class="btn btn-outline-primary" onclick="dataDay()"
                                                                type="button">ค้นหาข้อมูล</button>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12 text-md-end mt-4">
                                                        <button class="btn btn-dark text-end"
                                                            onclick="printReportofDay()">Print</button>
                                                    </div>

                                                    <div class="col-12 mt-2">
                                                        <div class="table-responsive text-nowrap">
                                                            <table class="table table-bordered tbreportsell_day">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-end">วันที่</th>
                                                                        <th class="text-end">ยอดขาย</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbreportsell_day">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else if (!isset($_GET['report']) || $_GET['report'] == "bestsell") {

                                ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div id="reportrange" class="pull-left form-control"
                                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                    <span></span> <b class="caret"></b>
                                                </div>
                                                <select id="sortOrder" class="form-select">
                                                    <option value="">เรียงลำดับตาม</option>
                                                    <option value="ยอดขายสินค้า (สูงสุด)">ยอดขายสินค้า (สูงสุด)</option>
                                                    <option value="ยอดขายสินค้า (ต่ำสุด)">ยอดขายสินค้า (ต่ำสุด)</option>
                                                    <option value="จำนวนที่ขายได้ (สูงสุด)">จำนวนที่ขายได้ (สูงสุด)</option>
                                                    <option value="จำนวนที่ขายได้ (ต่ำสุด)">จำนวนที่ขายได้ (ต่ำสุด)</option>
                                                </select>
                                                <button class="btn btn-outline-primary" onclick="dataBestsell()"
                                                    type="button">ค้นหาข้อมูล</button>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-md-end mt-4">
                                            <button class="btn btn-dark text-end"
                                                onclick="printReportofbestsell()">Print</button>
                                        </div>

                                        <div class="col-12 mt-2">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-bordered tbreportbestsell">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-end">วันที่</th>
                                                            <th class="text-end">กลุ่มสินค้า</th>
                                                            <th class="text-end">ชื่อสินค้า</th>
                                                            <th class="text-end">จำนวน</th>
                                                            <th class="text-end">ยอดขาย</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbreportbestsell">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                            <?php } ?>



                        </div>

                    </div>
                    <div class="modal fade" id="modal_show" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-warning ">
                                    <h4 class="modal-title text-white" id="exampleModalLabel2">แจ้งเตือน</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="">เลือกข้อมูลให้ครบถ้วน !</h5>
                                </div>
                                <div class="modal-footer text-center">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        ยกเลิก
                                    </button>
                                    <button type="button" id="btnIdProduct" data-bs-dismiss="modal"
                                        class="btn btn-warning">ตกลง</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include("../../include/footer.php"); ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
</body>
<?php include("../../include/script.php"); ?>
<script src="../../assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../assets/plugins/toastr/toastr.min.js"></script>
<link href="../../assets/datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<script src="../../assets/datepicker/js/bootstrap-datepicker-custom.js"></script>
<script src="../../assets/datepicker/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script src="../../assets/js/moment.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"
    integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css"
    integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    $(document).ready(function () {
        dataYear();
    });

    function dataYear() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbreportsell_year").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "../../services/report/tablereportsell_year.php", true);
        xhttp.send();
    }
    $('#serachByYear').change(function () {
        // รับค่าของ option ที่ถูกเลือก
        var selectedValue = $(this).val();
        dataMonth(selectedValue)
    });

    function dataMonth(year) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbreportsell_month").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "../../services/report/tablereportsell_month.php?year=" + year, true);
        xhttp.send();
    }

    function dataDay() {

        var startdate = $('.start-date').val();
        var enddate = $('.end-date').val();
        console.log(startdate)
        console.log(enddate)
        if (startdate && enddate) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("tbreportsell_day").innerHTML = this.responseText;

                }
            };
            xhttp.open("GET", "../../services/report/tablereportsell_day.php?start=" + startdate + "&end=" + enddate, true);
            xhttp.send();
        } else {
            $('#modal_show').modal('show')
        }

    }


    $('.start-date').datepicker({
        templates: {
            leftArrow: '<i class="fa fa-chevron-left"></i>',
            rightArrow: '<i class="fa fa-chevron-right"></i>'
        },
        format: "dd/mm/yyyy",
        endDate: new Date(),
        keyboardNavigation: false,
        autoclose: true,
        todayHighlight: true,
        disableTouchKeyboard: true,
        orientation: "bottom auto"
    });

    $('.end-date').datepicker({
        templates: {
            leftArrow: '<i class="fa fa-chevron-left"></i>',
            rightArrow: '<i class="fa fa-chevron-right"></i>'
        },
        format: "dd/mm/yyyy",
        endDate: new Date(),
        keyboardNavigation: false,
        autoclose: true,
        todayHighlight: true,
        disableTouchKeyboard: true,
        orientation: "bottom auto"

    });


    $('.start-date').datepicker().on("changeDate", function () {
        var startDate = $('.start-date').datepicker('getDate');
        var oneDayFromStartDate = moment(startDate).add(0, 'days').toDate();
        $('.end-date').datepicker('setStartDate', oneDayFromStartDate);
        //$('.end-date').datepicker('setDate', oneDayFromStartDate);
    });

    $('.end-date').datepicker().on("show", function () {
        var startDate = $('.start-date').datepicker('getDate');
        $('.day.disabled').filter(function (index) {
            return $(this).text() === moment(startDate).format('D');
        }).addClass('active');
    });

    $(function () {

        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'วันนี้': [moment(), moment()],
                'เมื่อวานนี้': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 วันที่ผ่านมา': [moment().subtract(6, 'days'), moment()],
                '30 วันที่ผ่านมา': [moment().subtract(29, 'days'), moment()],
                'เดือนนี้': [moment().startOf('month'), moment().endOf('month')],
                'เดือนที่แล้ว': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],

            }
        }, cb);

        cb(start, end);

    });

    function dataBestsell() {
        console.log($('#reportrange span').html())
        console.log($('#sortOrder').val())
        if ($('#sortOrder').val() != "") {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("tbreportbestsell").innerHTML = this.responseText;

                }
            };
            xhttp.open("GET", "../../services/report/tablereportbestsell.php?sort=" + $('#sortOrder').val() + "&reportrange=" + $('#reportrange span').html(), true);
            xhttp.send();
        } else {
            $('#modal_show').modal('show')
        }
    }
    // print
    function printReportofYear() {

        var tableContents = $('.tbreportsell_year').prop('outerHTML');
        var additionalHeader = '<div class="text-center mt-4" style="font-size:16px;">ร้านบางปะหันบรรจุภัณฑ์</div>';
        var additionalContent = '<div class="text-center mb-3" style="font-size:16px;">รายงานยอดขายสรุปรายปี</div>';
        var contentToPrint = additionalHeader + additionalContent + tableContents;
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html>');
        printWindow.document.write('<link rel="preconnect" href="https://fonts.googleapis.com" />');
        printWindow.document.write('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />');
        printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/css/demo.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />');
        printWindow.document.write('<style>body {        -webkit-print-color-adjust: exact !important;        print-color-adjust: exact !important;    }</style>');
        printWindow.document.write('<head><title>รายงานยอดขายสรุปรายปี</title></head><body>');
        printWindow.document.write(contentToPrint);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();

    }


    function printReportofMonth() {
        var year = $('#serachByYear').val();
        window.open("reportMonth.php?year=" + year, '_blank');

    }



    function printReportofDay() {
        var startdate = $('.start-date').val();
        var enddate = $('.end-date').val();
        window.open("reportDay.php?start=" + startdate + "&end=" + enddate, '_blank');

        /*var tableContents = $('.tbreportsell_day').prop('outerHTML');
        var additionalHeader = '<div class="text-center mt-4" style="font-size:16px;">ร้านบางปะหันบรรจุภัณฑ์</div>';
        var additionalContent = '<div class="text-center mb-3" style="font-size:16px;">รายงานยอดขายสรุปรายวัน</div>';
       
        var contentToPrint = additionalHeader+additionalContent + tableContents;
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html>');
        printWindow.document.write('<link rel="preconnect" href="https://fonts.googleapis.com" />');
        printWindow.document.write('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />');
        printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/css/demo.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />');
        printWindow.document.write('<style>body {        -webkit-print-color-adjust: exact !important;        print-color-adjust: exact !important;    }</style>');
        printWindow.document.write('<head><title>รายงานยอดขายสรุปรายวัน</title></head><body>');
        printWindow.document.write(contentToPrint);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();*/
    }


    function printReportofbestsell() {

        var reportrange=$('#reportrange span').html()
       var sortOrder=$('#sortOrder').val()
        window.open("reportBestofsell.php?sort=" + sortOrder + "&reportrange=" + reportrange, '_blank');

        /*var tableContents = $('.tbreportbestsell').prop('outerHTML');
        var additionalHeader = '<div class="text-center mt-4" style="font-size:16px;">ร้านบางปะหันบรรจุภัณฑ์</div>';
        var additionalContent = '<div class="text-center mb-3" style="font-size:16px;">รายงานสินค้าขายดี</div>';

        var contentToPrint = additionalHeader + additionalContent + tableContents;
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html>');
        printWindow.document.write('<link rel="preconnect" href="https://fonts.googleapis.com" />');
        printWindow.document.write('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />');
        printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/css/demo.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />');
        printWindow.document.write('<link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />');
        printWindow.document.write('<style>body {        -webkit-print-color-adjust: exact !important;        print-color-adjust: exact !important;    }</style>');
        printWindow.document.write('<head><title>รายงานสินค้าขายดี</title></head><body>');
        printWindow.document.write(contentToPrint);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();*/

    }
</script>