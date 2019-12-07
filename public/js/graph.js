jQuery(document).ready(function($) {
    var getSites = function() {
        var ctx = $("#bubble-chart");
        $.ajax({

            url: 'http://127.0.0.1/projets/Multi_Evaluation_Tool/api/data.php',
            type: 'GET',
            dataType: 'JSON',
            success: function(results) {
                var dynamicColors = function() {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);

                    return "rgb(" + r + "," + g + "," + b + ")";
                };

                var sites = [];
                for (var i = 0; i < results.length; i++) {
                    var site = {
                        label: results[i].libelle_site.toString(),
                        backgroundColor: dynamicColors(), //"rgba(220, 91, 48, 0.8)",
                        borderColor: "rgb(69,70,72)",
                        radius: 10,
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                        hoverRadius: 5,
                        data: [{
                            x: Number(results[i].score_pagespeed),
                            y: Number(results[i].score_yslow),
                            r: 10
                        }]
                    };
                    sites.push(site);
                }

                var data = { labels: ["Rapport entre les scores"], datasets: sites };
                var options = {
                    title: { display: true, text: 'Rapport score PageSpeed / Indice' },
                    scales: {
                        yAxes: [{
                            scaleLabel: { display: true, labelString: "Scores : Page Speed" },
                            ticks: { beginAtZero: true, max: 100 }
                        }],
                        xAxes: [{
                            scaleLabel: { display: true, labelString: "Indice" },
                            ticks: { beginAtZero: true, max: 100 }
                        }]
                    }
                };
                new Chart(ctx, { type: "bubble", data: data, options: options });
            },

            error: function(results) {
                console.log(results);
            }
        });
    };

    getSites();

});