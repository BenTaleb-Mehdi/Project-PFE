window.dashboardData = function(clientId) {
    return {
        metrics: null,
        loading: true,
        error: null,
        clientId: clientId,
        newWeight: '',
        updating: false,
        updateSuccess: false,

        async fetchMetrics() {
            try {
                const res = await fetch(`/api/client/${this.clientId}/metrics`);
                const json = await res.json();

                if (json.success) {
                    this.metrics = json.data;
                    this.newWeight = this.metrics.current_weight;
                } else {
                    this.error = json.message || 'Client not found';
                }
            } catch (e) {
                this.error = 'Something went wrong';
            } finally {
                this.loading = false;
            }
        },

        async updateWeight() {
            if (!this.newWeight || this.updating) return;

            this.updating = true;
            this.updateSuccess = false;
            this.error = null;

            const sanitizedWeight = this.newWeight.toString().replace(',', '.');

            try {
                const res = await fetch(`/api/client/${this.clientId}/metrics`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({ weight: sanitizedWeight })
                });

                const json = await res.json();

                if (json.success) {
                    if (window.Alpine) {
                        Alpine.store('alert').show('Weight_Updated_Successfully');
                    }
                    await this.fetchMetrics();
                } else {
                    const msg = json.message || 'Update failed';
                    if (window.Alpine) {
                        Alpine.store('alert').show(msg, 'error');
                    }
                    this.error = msg;
                }
            } catch (e) {
                const errMsg = 'Failed to update weight';
                if (window.Alpine) {
                    Alpine.store('alert').show(errMsg, 'error');
                }
                this.error = errMsg;
            } finally {
                this.updating = false;
            }
        }
    }
}