import ApexCharts from "apexcharts"

document.addEventListener("DOMContentLoaded", () => {
  // Contributions Chart
  const contributionsChartEl = document.getElementById("contributionsChart")
  if (contributionsChartEl) {
    const contributionsData = JSON.parse(contributionsChartEl.dataset.contributions || "[]")

    // Group contributions by month
    const contributionsByMonth = {}
    const months = ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"]

    contributionsData.forEach((contribution) => {
      const date = new Date(contribution.created_at)
      const monthKey = `${months[date.getMonth()]} ${date.getFullYear()}`

      if (!contributionsByMonth[monthKey]) {
        contributionsByMonth[monthKey] = 0
      }
      contributionsByMonth[monthKey] += Number.parseFloat(contribution.amount)
    })

    // Prepare data for chart
    const labels = Object.keys(contributionsByMonth).sort((a, b) => {
      const [aMonth, aYear] = a.split(" ")
      const [bMonth, bYear] = b.split(" ")
      return new Date(`${aMonth} 1, ${aYear}`) - new Date(`${bMonth} 1, ${bYear}`)
    })

    const values = labels.map((label) => contributionsByMonth[label])

    const options = {
      chart: {
        type: 'line',
        height: '100%',
        toolbar: {
          show: false
        }
      },
      series: [{
        name: "Montant des contributions (€)",
        data: values
      }],
      stroke: {
        width: 2,
        curve: 'smooth',
        colors: ["#48BB78"]
      },
      markers: {
        size: 5,
        colors: ["#48BB78"]
      },
      fill: {
        type: 'solid',
        colors: ["#48BB78"],
        opacity: 0.2
      },
      xaxis: {
        categories: labels
      },
      yaxis: {
        min: 0,
        labels: {
          formatter: function(val) {
            return val + " €"
          }
        }
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val + " €"
          }
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: '100%'
          }
        }
      }]
    }

    const chart = new ApexCharts(contributionsChartEl, options)
    chart.render()
  }

  // Projects Status Chart
  const projectsStatusChartEl = document.getElementById("projectsStatusChart")
  if (projectsStatusChartEl) {
    const projectsData = JSON.parse(projectsStatusChartEl.dataset.projects || "[]")

    // Count projects by status
    const pendingProjects = projectsData.filter((project) => project.status === "pending").length
    const activeProjects = projectsData.filter((project) => project.status !== "pending").length

    const options = {
      chart: {
        type: 'donut',
        height: '100%'
      },
      series: [pendingProjects, activeProjects],
      labels: ["En attente", "En cours"],
      colors: ["rgba(72, 187, 120, 0.2)", "rgba(72, 187, 120, 1)"],
      stroke: {
        colors: ["rgba(72, 187, 120, 1)", "rgba(47, 133, 90, 1)"],
        width: 1
      },
      legend: {
        position: 'bottom'
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: '100%'
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    }

    const chart = new ApexCharts(projectsStatusChartEl, options)
    chart.render()
  }
})