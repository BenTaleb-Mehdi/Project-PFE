
import { createIcons, icons } from 'lucide'

export const evolutionSync = (config) => ({
    syncModalOpen: false, 
    selectedSync: null,
    previewPhotos: [],
    searchQuery: "",
    filterOption: "latest",
    history: [],
    
    init() {
        // Handle history initialization
        const rawHistory = config?.history || [];
        this.history = Array.isArray(rawHistory) ? rawHistory : Object.values(rawHistory);

        this.$nextTick(() => {
            this.initChart();
            createIcons({ icons });
        });
    },
    
    get filteredHistory() {
        let filtered = Array.isArray(this.history) ? [...this.history] : Object.values(this.history);
        
        // Search Filter
        if(this.searchQuery) {
            const query = this.searchQuery.toLowerCase();
            filtered = filtered.filter(item => 
                item.weight.toString().includes(query) || 
                this.formatDate(item.recorded_at).toLowerCase().includes(query)
            );
        }
        
        // Sort Filter
        if(this.filterOption === 'latest') filtered.sort((a,b) => new Date(b.recorded_at) - new Date(a.recorded_at));
        if(this.filterOption === 'oldest') filtered.sort((a,b) => new Date(a.recorded_at) - new Date(b.recorded_at));
        if(this.filterOption === 'heaviest') filtered.sort((a,b) => b.weight - a.weight);
        if(this.filterOption === 'lightest') filtered.sort((a,b) => a.weight - b.weight);
        if(this.filterOption === 'photos') filtered = filtered.filter(item => item.images && item.images.length > 0);
        
        return filtered;
    },
    
    formatDate(dateStr) {
        if(!dateStr) return "";
        const date = new Date(dateStr);
        return date.toLocaleDateString("en-US", { day: "2-digit", month: "short", year: "numeric" }).toUpperCase();
    },
    handleFileChange(e) {
        this.previewPhotos = [];
        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = (event) => {
                this.previewPhotos.push(event.target.result);
            };
            reader.readAsDataURL(files[i]);
        }
    },
    initChart() {
        const historyArray = Array.isArray(this.history) ? this.history : Object.values(this.history);
        if (historyArray.length === 0 || typeof Chart === 'undefined') return;

        const canvas = document.getElementById("weightChart");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");
        const labels = historyArray.map(item => this.formatDate(item.recorded_at));
        const data = historyArray.map(item => item.weight);

        if (window.myEvolutionChart) {
            window.myEvolutionChart.destroy();
        }

        window.myEvolutionChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "System Mass (KG)",
                    data: data,
                    borderColor: "#0891b2",
                    backgroundColor: "rgba(8, 145, 178, 0.1)",
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: "#0891b2",
                    pointBorderColor: "#fff",
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        ticks: { font: { family: "JetBrains Mono", size: 8 }, color: "#a1a1aa" }
                    },
                    y: {
                        display: true,
                        grid: { color: "rgba(0,0,0,0.05)", drawBorder: false },
                        ticks: { font: { family: "JetBrains Mono", size: 8 }, color: "#a1a1aa" }
                    }
                }
            }
        });
    }
});
