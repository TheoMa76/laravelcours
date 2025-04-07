import ApexCharts from 'apexcharts';

function initDashboardCharts() {
    const commonOptions = {
        fontFamily: 'Manrope, sans-serif',
        stroke: { curve: 'smooth', width: 2 },
        chart: {
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            }
        }
    };

    const usersChartEl = document.getElementById('usersChart');
    if (usersChartEl) {
        const usersOptions = {
            ...commonOptions,
            series: [{
                name: 'Utilisateurs',
                data: JSON.parse(usersChartEl.dataset.values || '[]'),
            }],
            chart: {
                ...commonOptions.chart,
                type: 'area',
                height: '95%'
            },
            colors: ['var(--primary-green-dark)'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    shadeIntensity: 1,
                    gradientToColors: ['var(--primary-green-light)'],
                    gradientFromColors: ['var(--primary-green)'],
                    type: 'vertical',
                    opacityFrom: 1,
                    style: 'circles',
                    opacityTo: 1,
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: JSON.parse(usersChartEl.dataset.labels || '[]'),
                labels: {
                    style: {
                        colors: 'var(--primary-black)',
                        fontSize: '12px',
                        fontFamily: 'Manrope, sans-serif'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: 'var(--primary-black)',
                        fontSize: '12px'
                    }
                }
            },
            grid: {
                borderColor: 'var(--primary-green-light)',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                y: { formatter: (val) => `${val} utilisateurs` }
            }
        };
        new ApexCharts(usersChartEl, usersOptions).render();
    }

    const projectsChartEl = document.getElementById('projectsChart');
    if (projectsChartEl) {
        const projectsOptions = {
            ...commonOptions,
            series: [{
                name: 'Projets',
                data: JSON.parse(projectsChartEl.dataset.values || '[]'),
            }],
            chart: {
                ...commonOptions.chart,
                type: 'bar',
                height: '95%'
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '45%',
                    distributed: false
                }
            },
            colors: ['var(--primary-green)'],
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: JSON.parse(projectsChartEl.dataset.labels || '[]'),
                labels: {
                    style: {
                        colors: 'var(--primary-black)',
                        fontSize: '12px',
                        fontFamily: 'Manrope, sans-serif'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                min: 0,
                labels: {
                    style: {
                        colors: 'var(--primary-black)',
                        fontSize: '12px'
                    }
                }
            },
            grid: {
                borderColor: 'var(--primary-green-light)',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                y: { formatter: (val) => `${val} projets` }
            }
        };
        new ApexCharts(projectsChartEl, projectsOptions).render();
    }

    const contributionsChartEl = document.getElementById('contributionsChart');
    if (contributionsChartEl) {
        const contributionsData = JSON.parse(contributionsChartEl.dataset.values || '[0, 0, 0]');
        const financialTotal = contributionsChartEl.dataset.financialTotal || '0';
        
        const totalContributions = contributionsData.reduce((a, b) => a + b, 0);
    
        const contributionsOptions = {
            series: contributionsData,
            chart: {
                type: 'donut',
                height: '95%'
            },
            labels: ['Financières', 'Matérielles', 'Bénévolat'],
            colors: ['var(--primary-green-dark)', 'var(--primary-green)', 'var(--primary-green-light)'],
            dataLabels: {
                enabled: true,
                formatter: function(val) { 
                    return val === 0 ? '' : `${val.toFixed(1)}%`;
                },
                style: { fontSize: '10px' }
            },
            legend: {
                position: 'bottom',
                fontSize: '12px',
                labels: {
                    colors: 'var(--primary-black)',
                    useSeriesColors: false
                },
                markers: {
                    width: 8,
                    height: 8,
                    radius: 8
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                color: 'var(--primary-black)',
                                formatter: function() {
                                    return totalContributions === 0 ? '0' : totalContributions.toString();
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val, { seriesIndex }) {
                        if (seriesIndex === 0) {
                            const percentage = totalContributions > 0 ? (val / totalContributions * 100).toFixed(1) : 0;
                            return `${val} contributions (${percentage}%)\nTotal: ${financialTotal}€`;
                        }
                        return `${val} contributions`;
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { width: 200 },
                    legend: { position: 'bottom' }
                }
            }]
        };
    
        if (typeof commonOptions !== 'undefined') {
            contributionsOptions.chart = {...commonOptions.chart, ...contributionsOptions.chart};
        }
    
        new ApexCharts(contributionsChartEl, contributionsOptions).render();
    }
}

document.addEventListener('DOMContentLoaded', initDashboardCharts);
export default initDashboardCharts;