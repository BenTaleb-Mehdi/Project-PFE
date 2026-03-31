window.programData = function(clientId) {
    return {
        program: null,
        loading: true,
        error: null,
        clientId: clientId,
        detailModalOpen: false,
        selectedMeal: null,

        async fetchProgram() {
            try {
                this.loading = true;
                const res = await fetch(`/api/client/${this.clientId}/program`);
                
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const json = await res.json();

                if (json.success) {
                    this.program = json.data;
                } else {
                    this.error = json.message || 'Program not found';
                }
            } catch (e) {
                console.error(e);
                this.error = 'Something went wrong while fetching the program';
            } finally {
                this.loading = false;
            }
        }
    }
}
