<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatSystem', () => ({
            contacts: [],
            activeContact: null,
            messages: [],
            messageText: '',
            searchQuery: '',
            showContacts: false,
            selectedFile: null,
            fileName: '',
            filePreview: null,
            isUploading: false,
            loadingContacts: true,
            loadingMessages: false,
            pollingInterval: null,
            currentUserId: {{ auth()->id() }},
            
            init() {
                this.fetchContacts();
                
                // Real-time loop polling every 3 seconds for updates
                this.pollingInterval = setInterval(() => {
                    this.fetchContacts(true);
                    if (this.activeContact) {
                        this.fetchMessages(this.activeContact.id, true);
                    }
                }, 3000);
            },
            
            destroy() {
                if (this.pollingInterval) {
                    clearInterval(this.pollingInterval);
                }
            },
            
            fetchContacts(silent = false) {
                if (!silent) this.loadingContacts = true;
                
                fetch('{{ route("coach.chat.contacts") }}')
                    .then(res => res.json())
                    .then(data => {
                        this.contacts = data.contacts;
                        
                        // Keep current active contact synced
                        if (this.activeContact) {
                            const updated = this.contacts.find(c => c.id === this.activeContact.id);
                            if (updated) {
                                this.activeContact.unread_count = updated.unread_count;
                            }
                        }
                    })
                    .finally(() => {
                        if (!silent) this.loadingContacts = false;
                        this.reinitLucide();
                    });
            },
            
            filteredContacts() {
                if (!this.searchQuery.trim()) return this.contacts;
                const query = this.searchQuery.toLowerCase();
                return this.contacts.filter(c => c.name.toLowerCase().includes(query));
            },
            
            selectContact(contact) {
                this.activeContact = contact;
                this.messages = [];
                this.fetchMessages(contact.id);
                contact.unread_count = 0;
                this.showContacts = false;
            },
            
            fetchMessages(contactId, silent = false) {
                if (!silent) this.loadingMessages = true;
                
                let url = '{{ route("coach.chat.messages", ["contactId" => ":id"]) }}';
                url = url.replace(':id', contactId);
                
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        // Prevent race condition - only update if still viewing same contact
                        if (!this.activeContact || this.activeContact.id !== contactId) return;
                        const prevCount = this.messages.length;
                        this.messages = data.messages;
                        
                        if (data.messages.length > prevCount) {
                            this.$nextTick(() => {
                                this.scrollToBottom();
                            });
                        }
                    })
                    .finally(() => {
                        if (!silent) this.loadingMessages = false;
                        this.reinitLucide();
                    });
            },
            
            handleFileChange(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                // Max 5MB file size validation
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('File too large. Maximum size is 5MB.');
                    this.clearFile();
                    return;
                }
                
                this.selectedFile = file;
                this.fileName = file.name;
            },
            
            clearFile() {
                this.selectedFile = null;
                this.fileName = '';
                if (this.$refs.fileInput) {
                    this.$refs.fileInput.value = '';
                }
            },
            
            async compressImage(file) {
                return new Promise((resolve) => {
                    if (!file.type.startsWith('image/')) {
                        resolve(file);
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = new Image();
                        img.onload = () => {
                            const canvas = document.createElement('canvas');
                            let { width, height } = img;
                            // Max dimensions 1920px
                            const maxDim = 1920;
                            if (width > maxDim || height > maxDim) {
                                if (width > height) {
                                    height = (height / width) * maxDim;
                                    width = maxDim;
                                } else {
                                    width = (width / height) * maxDim;
                                    height = maxDim;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);
                            canvas.toBlob((blob) => {
                                const compressed = new File([blob], file.name, {
                                    type: file.type,
                                    lastModified: Date.now()
                                });
                                resolve(compressed);
                            }, file.type, 0.8);
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            },
            
            async sendMessage() {
                if (!this.activeContact) return;
                if (!this.messageText.trim() && !this.selectedFile) return;
                
                this.isUploading = true;
                
                const formData = new FormData();
                if (this.messageText.trim()) {
                    formData.append('message', this.messageText);
                }
                if (this.selectedFile) {
                    const compressed = await this.compressImage(this.selectedFile);
                    formData.append('file', compressed);
                }
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                let url = '{{ route("coach.chat.send", ["contactId" => ":id"]) }}';
                url = url.replace(':id', this.activeContact.id);
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.messages.push(data.message);
                        this.messageText = '';
                        this.clearFile();
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                        this.fetchContacts(true);
                    }
                })
                .finally(() => {
                    this.isUploading = false;
                    this.reinitLucide();
                });
            },
            
            scrollToBottom() {
                const container = this.$refs.messageContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            },
            
            formatTime(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
            },
            
            formatDate(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleDateString([], { month: 'short', day: 'numeric', year: 'numeric' });
            },
            
            isNewDay(prevDateStr, currDateStr) {
                const prev = new Date(prevDateStr).toDateString();
                const curr = new Date(currDateStr).toDateString();
                return prev !== curr;
            },
            
            reinitLucide() {
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            }
        }));
    });
</script>
