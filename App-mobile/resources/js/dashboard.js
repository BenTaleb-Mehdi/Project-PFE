const API_URL = import.meta.env.VITE_API_URL;
window.dashboardData = function(clientId) {
    return {
        metrics: null,
        loading: true,
        error: null,
        clientId: clientId,

        async fetchMetrics() {
            try {
                const res = await fetch(`${API_URL}/client/${this.clientId}/metrics`);
                const json = await res.json();

                if (json.success) {
                    this.metrics = json.data;
                } else {
                    this.error = 'Client not found';
                }
            } catch (e) {
                this.error = 'Cannot connect to Web A';
            } finally {
                this.loading = false;
            }
        }
    }
}