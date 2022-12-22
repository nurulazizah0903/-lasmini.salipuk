<?php

namespace PHPMaker2022\pubinamarga;

// Dashboard Page object
$Dashboard2 = $Page; ?>
<script>
    loadjs.ready("head", function () {
        // Write your table-specific client script here, no need to add script tags.
    });
</script>
<!-- Content Container -->
<div id="ew-report" class="ew-report">
<!-- //content -->
    <?php
        // query jumlah penanya
        $jmlPenanya = ExecuteScalar("SELECT COUNT(*) FROM pelapor");
        // query jumlah pertanyaan
        $jmlPertanyaan = ExecuteScalar("SELECT COUNT(*) FROM pertanyaan");
        // query jumlah penanya in this day
        $jmlPenanyaInThisDay = ExecuteScalar("SELECT COUNT(DISTINCT pelapor_id) FROM log_user_chat WHERE DAY(`tanggal`) = DAY(NOW())");    
        // query penanya dalam 1 minggu
        $jmlPenanyaInWeek = ExecuteRows("SELECT CONCAT('Tanggal : ',DAY(tanggal)) AS label, COUNT(DISTINCT pelapor_id) AS value FROM log_user_chat WHERE tanggal >= DATE(NOW()) - INTERVAL 7 DAY GROUP BY 1 ORDER BY 1 ASC");    
        // query pertanyaan paling banyak di tanyakan
        $jmlPertayaanMostAsked = ExecuteRows("SELECT p.nama AS kode_pertanyaan, COUNT(*) AS jumlah FROM pertanyaan p JOIN log_user_chat logc ON logc.pesan = p.code WHERE p.pid IS NULL GROUP BY 1");
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3>
                            <?= $jmlPenanya; ?>
                        </h3>
                        <p>Jumlah Penanya</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3>
                            <?= $jmlPertanyaan; ?>
                        </h3>
                        <p>Jumlah Pertanyaan</p>
                    </div>
                </div>
            </div>    
            <div class="col-sm-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3>
                            <?= $jmlPenanyaInThisDay ?? 0; ?>
                        </h3>
                        <p>Jumlah Penanya Hari ini</p>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">                    
                        <h5>
                            Grafik Tentang Jumlah Penanya Dalam 7 hari terakhir
                        </h5>
                        <div id="main1" style="width: 100%;height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">                        
                        <h5>
                            Grafik Tentang Jumlah Pertanyaan Induk Paling Banyak Di tanyakan
                        </h5>
                        <div id="main2" style="width: 100%;height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.0/dist/echarts.min.js"></script>

    <script>
        // Initialize the echarts instance based on the prepared dom
        var myChart2 = echarts.init(document.getElementById('main2'));
        var main2 = <?= json_encode($jmlPertayaanMostAsked); ?>;
        var option2 = {
            title: {
                text: ''
            },
            tooltip: {},
            legend: {
                data: ['Nama Pertanyaan']
            },
            xAxis: {
                data: main2.map((row) => row.kode_pertanyaan)
            },
            yAxis: {},
            series: [
                {
                    name: 'Nama Pertanyaan',
                    type: 'bar',
                    data: main2.map((row) => row.jumlah)
                }
            ]
        };
        myChart2.setOption(option2);
    </script>
    <script>
        // Initialize the echarts instance based on the prepared dom
        var myChart1 = echarts.init(document.getElementById('main1'));
        var main1 = <?= json_encode($jmlPenanyaInWeek); ?>;
        var option1 = {
            title: {
                text: ''
            },
            tooltip: {},
            legend: {
                data: ['Data Perhari']
            },
            xAxis: {
                data: main1.map((row) => row.label)
            },
            yAxis: {},
            series: [
                {
                    name: 'Data Perhari',
                    type: 'bar',
                    data: main1.map((row) => row.value)
                }
            ]
        };
        myChart1.setOption(option1);
    </script>
</div>