window.dashboardData = function(clientId) {
    return {
        metrics: null,
        loading: true,
        error: null,
        clientId: clientId,

        async fetchMetrics() {
            try {

                const res = await fetch(`/api/client/${this.clientId}/metrics`);
                const json = await res.json();

                if (json.success) {
                    this.metrics = json.data;
                } else {
                    this.error = json.message || 'Client not found';
                }
            } catch (e) {
                this.error = 'Something went wrong';
            } finally {
                this.loading = false;
            }
        }
    }
}