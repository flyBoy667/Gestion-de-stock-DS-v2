<?php
include('includes/db_connexion.php');

// Récupération de l'année et du mois actuel par défaut
$currentYear = date("Y");
$currentMonth = date("m");

// Vérification et traitement du filtre par année et mois
if (isset($_GET['year'])) {
    $selectedYear = $_GET['year'];
} else {
    $selectedYear = $currentYear;
}

if (isset($_GET['month'])) {
    $selectedMonth = $_GET['month'];
} else {
    $selectedMonth = $currentMonth;
}

// Requête pour les ventes
$query = "SELECT SUM(Detail_qte) AS qvente FROM detail WHERE type = 1 AND YEAR(date_commande) = :year AND MONTH(date_commande) = :month";
$statement = $connect->prepare($query);
$statement->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result = $statement->fetch(PDO::FETCH_OBJ);
$qvendue = $result->qvente;

// Requête pour le montant des ventes
$query2 = "SELECT SUM(montant_paye) AS mt FROM transaction WHERE type = 1 AND YEAR(transaction_date) = :year AND MONTH(transaction_date) = :month";
$statement2 = $connect->prepare($query2);
$statement2->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result2 = $statement2->fetch(PDO::FETCH_OBJ);
$sum = $result2->mt;

// Requête pour les achats
$query_achat = "SELECT SUM(Detail_qte) AS qachat FROM detail WHERE type = 2 AND YEAR(date_commande) = :year AND MONTH(date_commande) = :month";
$statement_achat = $connect->prepare($query_achat);
$statement_achat->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result_achat = $statement_achat->fetch(PDO::FETCH_OBJ);
$qacheter = $result_achat->qachat;

// Requête pour le montant des achats
$query_achat2 = "SELECT SUM(montant_paye) AS mt_achat FROM transaction WHERE type = 2 AND YEAR(transaction_date) = :year AND MONTH(transaction_date) = :month";
$statement_achat2 = $connect->prepare($query_achat2);
$statement_achat2->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result_achat2 = $statement_achat2->fetch(PDO::FETCH_OBJ);
$sum_achat = $result_achat2->mt_achat;

// Requête pour les dépenses
$query_expenses = "SELECT SUM(montant) AS total_expenses FROM depense WHERE YEAR(depense_date) = :year AND MONTH(depense_date) = :month";
$statement_expenses = $connect->prepare($query_expenses);
$statement_expenses->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$result_expenses = $statement_expenses->fetch(PDO::FETCH_OBJ);
$total_expenses = $result_expenses->total_expenses;

// Récupération des années et mois disponibles pour le filtre
$query_years = "SELECT DISTINCT YEAR(date_commande) AS annee FROM detail";
$statement_years = $connect->prepare($query_years);
$statement_years->execute();
$years = $statement_years->fetchAll(PDO::FETCH_COLUMN);

$query_months = "SELECT DISTINCT MONTH(date_commande) AS mois FROM detail";
$statement_months = $connect->prepare($query_months);
$statement_months->execute();
$months = $statement_months->fetchAll(PDO::FETCH_COLUMN);

// Requête pour les produits les plus vendus
$query_top_products = "
SELECT p.nom_produit, SUM(d.Detail_qte) AS total_vendu
FROM produit p
JOIN detail d ON p.id_produit = d.Detail_ref
WHERE d.type = 1
AND YEAR(d.date_commande) = :year
AND MONTH(d.date_commande) = :month
GROUP BY p.nom_produit
ORDER BY total_vendu DESC
LIMIT 10
";
$statement_top_products = $connect->prepare($query_top_products);
$statement_top_products->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$top_products = $statement_top_products->fetchAll(PDO::FETCH_OBJ);

// Requête pour les produits les plus achetés
$query_top_products_achat = "
SELECT p.nom_produit, SUM(d.Detail_qte) AS total_achete
FROM produit p
JOIN detail d ON p.id_produit = d.Detail_ref
WHERE d.type = 2
AND YEAR(d.date_commande) = :year
AND MONTH(d.date_commande) = :month
GROUP BY p.nom_produit
ORDER BY total_achete DESC
LIMIT 10
";
$statement_top_products_achat = $connect->prepare($query_top_products_achat);
$statement_top_products_achat->execute(array(':year' => $selectedYear, ':month' => $selectedMonth));
$top_products_achat = $statement_top_products_achat->fetchAll(PDO::FETCH_OBJ);

// Calcul du bénéfice
$benefice = ($sum - $sum_achat - $total_expenses);

include('includes/header.php');

?>
<div class="row">
    <div class="col-md-12">
        <form action="" method="get" class="form-inline mb-3">
            <label for="year" class="mr-2">Sélectionner une année :</label>
            <select name="year" id="year" class="form-control mr-2" onchange="this.form.submit()">
                <?php foreach ($years as $year) : ?>
                    <option value="<?php echo $year; ?>" <?php if ($year == $selectedYear) echo 'selected'; ?>>
                        <?php echo $year; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="month" class="mr-2">Sélectionner un mois :</label>
            <select name="month" id="month" class="form-control mr-2" onchange="this.form.submit()">
                <?php foreach ($months as $month) : ?>
                    <option value="<?php echo $month; ?>" <?php if ($month == $selectedMonth) echo 'selected'; ?>>
                        <?php echo date("F", mktime(0, 0, 0, $month, 1)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <noscript><input type="submit" value="Appliquer" class="btn btn-primary"></noscript>
            <a href="export_excel.php?year=<?php echo $selectedYear; ?>&month=<?php echo $selectedMonth; ?>" class="btn btn-primary">Exporter vers Excel</a>
        </form>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total ventes (<?php echo date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " " . $selectedYear; ?>)</span>
                <span class="info-box-number">
                    <?php echo ($qvendue) ? $qvendue : 0; ?>
                    <small>Produit(s)</small>
                    <small><?php echo "(" . number_format($sum, 2, ',', ' ') . " CFA)"; ?></small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ship"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total achats (<?php echo date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " " . $selectedYear; ?>)</span>
                <span class="info-box-number">
                    <?php echo ($qacheter) ? $qacheter : 0; ?>
                    <small>Produit(s)</small>
                    <small><?php echo "(" . number_format($sum_achat, 2, ',', ' ') . " CFA)"; ?></small>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total dépenses (<?php echo date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " " . $selectedYear; ?>)</span>
                <span class="info-box-number">
                    <?php echo ($total_expenses) ? number_format($total_expenses, 2, ',', ' ') : 0; ?> CFA
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total transactions (<?php echo date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " " . $selectedYear; ?>)</span>
                <span class="info-box-number">
                    <?php $total_transaction = $sum + $sum_achat;
                    echo number_format($total_transaction, 2, ',', ' ') . " CFA"; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- BAR CHART -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Ventes VS Achats (Quantités)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="barChart" style="height:230px; min-height:230px"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- PIE CHART -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Valeur du stock (Montants)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="pieChart" style="height:230px; min-height:230px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- GRAPH DES PRODUITS LES PLUS VENDUS -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Produits les plus vendus</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="topProductsChart" style="height:230px; min-height:230px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- GRAPH DES PRODUITS LES PLUS ACHETÉS -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Produits les plus achetés</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="topProductsAchatChart" style="height:230px; min-height:230px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-primary">
            <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Bénéfice Mensuel (<?php echo date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " " . $selectedYear; ?>)</span>
                <span class="info-box-number"><?php echo number_format($benefice, 2, ',', ' '); ?> CFA</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

</div>
<script>
    $(function () {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: ['<?php echo date("F", mktime(0, 0, 0, $selectedMonth, 1)); ?>'],
            datasets: [
                {
                    label: 'Ventes',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [<?php echo $qvendue ? $qvendue : 0; ?>]
                },
                {
                    label: 'Achats',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [<?php echo $qacheter ? $qacheter : 0; ?>]
                },
            ]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });

        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieData = {
            labels: [
                'Ventes',
                'Achats',
                'Dépenses'
            ],
            datasets: [
                {
                    data: [
                        <?php echo $sum ? $sum : 0; ?>,
                        <?php echo $sum_achat ? $sum_achat : 0; ?>,
                        <?php echo $total_expenses ? $total_expenses : 0; ?>
                    ],
                    backgroundColor: [
                        '#f56954',
                        '#00a65a',
                        '#f39c12'
                    ]
                }
            ]
        };

        var pieOptions = {
            legend: {
                display: true,
            },
            maintainAspectRatio: false,
            responsive: true
        };

        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        });
        // Données pour le graphique des produits les plus vendus
        var topProductsCanvas = $('#topProductsChart').get(0).getContext('2d');
        var topProductsData = {
            labels: [<?php foreach ($top_products as $product) {
                echo '"' . $product->nom_produit . '",';
            } ?>],
            datasets: [{
                label: 'Quantité Vendue',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [<?php foreach ($top_products as $product) {
                    echo $product->total_vendu . ',';
                } ?>]
            }]
        };

        var topProductsOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };

        new Chart(topProductsCanvas, {
            type: 'bar',
            data: topProductsData,
            options: topProductsOptions
        });
        // Données pour le graphique des produits les plus achetés
        var topProductsAchatCanvas = $('#topProductsAchatChart').get(0).getContext('2d');
        var topProductsAchatData = {
            labels: [<?php foreach ($top_products_achat as $product) {
                echo '"' . $product->nom_produit . '",';
            } ?>],
            datasets: [{
                label: 'Quantité Achétée',
                backgroundColor: 'rgba(246,0,54,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [<?php foreach ($top_products_achat as $product) {
                    echo $product->total_achete . ',';
                } ?>]
            }]
        };

        var topProductsAchatOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };

        new Chart(topProductsAchatCanvas, {
            type: 'bar',
            data: topProductsAchatData,
            options: topProductsAchatOptions
        });
        var salesChartCanvas = $('#dailySalesChart').get(0).getContext('2d');

        var salesChartData = {
            labels: ['Ventes'],
            datasets: [
                {
                    label: 'Quantité Vendue',
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    borderWidth: 1,
                    data: [<?php echo $qvendue_daily ? $qvendue_daily : 0; ?>]
                },
                {
                    label: 'Montant Ventes',
                    backgroundColor: '#28a745',
                    borderColor: '#28a745',
                    borderWidth: 1,
                    data: [<?php echo $sum_daily_sales ? $sum_daily_sales : 0; ?>]
                }
            ]
        };

        var salesChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                    barPercentage: 0.4,
                    categoryPercentage: 0.5
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        new Chart(salesChartCanvas, {
            type: 'bar',
            data: salesChartData,
            options: salesChartOptions
        });

    });
</script>

<?php include('includes/footer.php'); ?>
