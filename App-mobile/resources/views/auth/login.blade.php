<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IronCoach Mobile</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-6" x-data="loginHandler()">
        <div class="w-full max-w-sm space-y-8">
            <div class="text-center">
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 uppercase">IronCoach</h1>
                <p class="text-xs text-zinc-500 font-mono mt-2 uppercase tracking-widest">Client Identity Synchronization</p>
            </div>

            <div class="bg-white border border-zinc-200 p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.05)]">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-1.5">
                        <label for="email" class="text-[10px] uppercase font-bold text-zinc-400 tracking-widest">Communication Node (Email)</label>
                        <input type="email" id="email" x-model="form.email" required autocomplete="email"
                               class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-xs outline-none focus:border-cyan-600 transition-colors">
                        <template x-if="errors.email">
                            <p class="text-[10px] text-red-600 uppercase font-mono mt-1" x-text="errors.email"></p>
                        </template>
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="text-[10px] uppercase font-bold text-zinc-400 tracking-widest">Encryption Key (Password)</label>
                        <input type="password" id="password" x-model="form.password" required autocomplete="current-password"
                               class="w-full bg-zinc-50 border border-zinc-200 px-4 py-3 text-xs outline-none focus:border-cyan-600 transition-colors">
                        <template x-if="errors.password">
                            <p class="text-[10px] text-red-600 uppercase font-mono mt-1" x-text="errors.password"></p>
                        </template>
                    </div>

                    <button type="submit" :disabled="loading"
                            class="w-full py-4 bg-zinc-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] active:scale-[0.98] disabled:opacity-50">
                        <span x-show="!loading">Establish Connection</span>
                        <span x-show="loading">Authenticating...</span>
                    </button>

                    <div x-show="generalError" class="p-3 bg-red-50 border border-red-200 text-red-700 text-[10px] uppercase font-mono" x-text="generalError"></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loginHandler() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                loading: false,
                errors: {},
                generalError: '',
                async submit() {
                    this.loading = true;
                    this.errors = {};
                    this.generalError = '';

                    try {
                        const response = await fetch('{{ route("login.post") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.form)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            window.location.href = result.redirect;
                        } else {
                            if (result.errors) {
                                this.errors = Object.fromEntries(
                                    Object.entries(result.errors).map(([key, val]) => [key, val[0]])
                                );
                            } else {
                                this.generalError = result.message || 'Login failed';
                            }
                        }
                    } catch (e) {
                        this.generalError = 'Connection lost. Check your internet.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>
