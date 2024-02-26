@extends('template.app')
@section('page-content')
    <div class="text-center p-4 p-lg-5" style="margin: 100px;">
        <!-- ... Autres éléments ... -->

        <div class="card-body align-content-center">
            <h2>Graphique d'évolution</h2>

            <div class="text-center">
                <label for="chartTypeSelector">Type de Graphique:</label>
                <select id="chartTypeSelector" onchange="updateChart()" class="form-control">
                    <option value="line">Ligne</option>
                    <option value="bar">Barre</option>
                    <option value="radar">Radar</option>
                    <option value="doughnut">Fromage</option>
                </select>
                <a href="{{route('exportCSV')}}">Export CSV</a>
{{--                <button onclick="exportToPDF()">Export PDF</button>--}}
            </div>

            <div class="text-center">
                <canvas id="productionConsommationChart" class="img-fluid" style="width: 50%;"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.5.14/jspdf.umd.min.js"></script>--}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('productionConsommationChart').getContext('2d');
            var hours = @json(range(8, 17));
            var productionData = @json($tabProd);
            var consommationData = @json($listeConso);

            var chart = new Chart(ctx, {
                type: 'line', // Par défaut, vous pouvez également utiliser le type initial de votre choix
                data: {
                    labels: hours.map(hour => hour + 'h'),
                    datasets: [
                        {
                            label: 'Production',
                            data: productionData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false,
                        },
                        {
                            label: 'Consommation',
                            data: consommationData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false,
                        },
                    ],
                },
                options: {
                    scales: {
                        x: {
                            type: 'category',
                            position: 'bottom',
                            grid: {
                                display: false,
                            },
                        },
                        y: {
                            beginAtZero: true,
                        },
                    },
                    maintainAspectRatio: false, // Permet au graphique de ne pas maintenir l'aspect ratio
                    responsive: true, // Permet au graphique de s'ajuster à la taille du conteneur
                    plugins: {
                        legend: {
                            position: 'top', // Modifiez la position de la légende si nécessaire
                        },
                    },
                },
            });

            window.updateChart = function () {
                var selectedChartType = document.getElementById('chartTypeSelector').value;

                // Supprimer le graphique existant
                chart.destroy();

                // Créer un nouveau graphique avec le type sélectionné
                if (selectedChartType === 'doughnut') {
                    chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Production', 'Consommation'],
                            datasets: [
                                {
                                    data: [calculateTotal(productionData), calculateTotal(consommationData)],
                                    backgroundColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                                    borderWidth: 1, // Ajoutez une bordure pour chaque segment
                                },
                            ],
                        },
                        options: {
                            cutout: '70%', // Ajustez la taille du trou central si nécessaire
                            maintainAspectRatio: false,
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            },
                        },
                    });
                } else {
                    chart = new Chart(ctx, {
                        type: selectedChartType,
                        data: {
                            labels: hours.map(hour => hour + 'h'),
                            datasets: [
                                {
                                    label: 'Production',
                                    data: productionData,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 2,
                                    fill: false,
                                },
                                {
                                    label: 'Consommation',
                                    data: consommationData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 2,
                                    fill: false,
                                },
                            ],
                        },
                        options: {
                            scales: {
                                x: {
                                    type: 'category',
                                    position: 'bottom',
                                    grid: {
                                        display: false,
                                    },
                                },
                                y: {
                                    beginAtZero: true,
                                },
                            },
                            maintainAspectRatio: false, // Permet au graphique de ne pas maintenir l'aspect ratio
                            responsive: true, // Permet au graphique de s'ajuster à la taille du conteneur
                            plugins: {
                                legend: {
                                    position: 'top', // Modifiez la position de la légende si nécessaire
                                },
                            },
                        },
                    });
                }
            };
            window.exportToPDF = function () {
                var canvas = document.getElementById('productionConsommationChart');
                var dataURL = canvas.toDataURL('image/png');

                var pdf = new jsPDF();
                pdf.addImage(dataURL, 'PNG', 0, 0);

                pdf.save('graphique.pdf');
            };


            function calculateTotal(data) {
                return data.reduce((total, value) => total + value, 0);
            }

        });

    </script>
@endsection
