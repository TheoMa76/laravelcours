import Chart from "chart.js/auto"

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

    new Chart(contributionsChartEl, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Montant des contributions (€)",
            data: values,
            backgroundColor: "rgba(72, 187, 120, 0.2)",
            borderColor: "rgba(72, 187, 120, 1)",
            borderWidth: 2,
            tension: 0.3,
            pointBackgroundColor: "rgba(72, 187, 120, 1)",
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: (value) => value + " €",
            },
          },
        },
      },
    })
  }

  // Projects Status Chart
  const projectsStatusChartEl = document.getElementById("projectsStatusChart")
  if (projectsStatusChartEl) {
    const projectsData = JSON.parse(projectsStatusChartEl.dataset.projects || "[]")

    // Count projects by status
    const pendingProjects = projectsData.filter((project) => project.status === "pending").length
    const activeProjects = projectsData.filter((project) => project.status !== "pending").length

    new Chart(projectsStatusChartEl, {
      type: "doughnut",
      data: {
        labels: ["En attente", "En cours"],
        datasets: [
          {
            data: [pendingProjects, activeProjects],
            backgroundColor: [
              "rgba(72, 187, 120, 0.2)", // primary-green-light
              "rgba(72, 187, 120, 1)", // primary-green
            ],
            borderColor: ["rgba(72, 187, 120, 1)", "rgba(47, 133, 90, 1)"],
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: "bottom",
          },
        },
      },
    })
  }
})
