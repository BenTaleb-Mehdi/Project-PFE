/**
 * Client Portal Nutrition Logic
 * MT Graphic Charter V3.0 Compliant
 */
import { createIcons, icons } from 'lucide'

export const clientDashboard = (config) => ({
    isLoggingOpen: false,
    activeView: "dashboard",
    history: config.history || [],
    nextMeal: null,
    
    init() {
        this.$nextTick(() => {
            this.initChart();
            this.calculateNextMeal();
            createIcons({ icons });
        });
    },

    formatDate(dateStr) {
        if(!dateStr) return "";
        const date = new Date(dateStr);
        return date.toLocaleDateString("en-US", { day: "2-digit", month: "short" }).toUpperCase();
    },

    initChart() {
        const historyArray = Array.isArray(this.history) ? this.history : Object.values(this.history);
        if (historyArray.length === 0) return;

        const canvas = document.getElementById("dashboardWeightChart");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");
        const labels = historyArray.map(item => this.formatDate(item.recorded_at));
        const data = historyArray.map(item => item.weight);

        if (window.myDashboardChart) {
            window.myDashboardChart.destroy();
        }

        window.myDashboardChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Mass (KG)",
                    data: data,
                    borderColor: "#0891b2",
                    backgroundColor: "rgba(8, 145, 178, 0.05)",
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: true, grid: { display: false }, ticks: { font: { size: 7 }, color: "#a1a1aa" } },
                    y: { display: false }
                }
            }
        });
    },

    calculateNextMeal() {
        if (!config.programMeals) return;

        const now = new Date();
        const currentHour = now.getHours();
        const currentMin = now.getMinutes();
        const currentTime = (currentHour * 60) + currentMin;

        const meals = config.programMeals;
        
        // Find next non-validated meal
        this.nextMeal = meals.find(m => {
            if (m.is_validated) return false;
            const [h, min] = m.time.split(":").map(Number);
            return (h * 60 + min) > currentTime;
        }) || meals.find(m => !m.is_validated); // Or first non-validated if time passed
    }
});
