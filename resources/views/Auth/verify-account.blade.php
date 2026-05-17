{-- Verify Account View --}
{-- This view handles the display and user interaction for Verify Account. --}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Your Account | Millenium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, .logo { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#FAF8F5] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="logo text-4xl font-bold text-[#8B1C3A]">Mille<span class="text-[#D4A574]">nium</span></a>
        </div>

        <!-- Verification Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-[#F5E6D3]">
            <div class="p-8 text-center bg-[#8B1C3A] text-white">
                <h2 class="text-2xl font-bold">Activate Account</h2>
                <p class="text-white/80 text-sm mt-2">Enter the 6-digit activation code sent to you</p>
            </div>

            <form action="{{ route('account.verify.post') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div class="flex justify-between gap-2" x-data="{ 
                        code: ['', '', '', '', '', ''],
                        handleInput(e, index) {
                            const val = e.target.value;
                            if (!/^\d*$/.test(val)) {
                                this.code[index] = '';
                                return;
                            }
                            
                            // Handle potential multi-character input (like autofill or paste)
                            if (val.length > 1) {
                                const digits = val.split('').filter(d => /^\d$/.test(d));
                                digits.forEach((d, i) => {
                                    if (index + i < 6) this.code[index + i] = d;
                                });
                                const nextIdx = Math.min(index + digits.length, 5);
                                this.$nextTick(() => this.$refs['digit' + nextIdx].focus());
                                return;
                            }

                            if (this.code[index] && index < 5) {
                                this.$nextTick(() => {
                                    this.$refs['digit' + (index + 1)].focus();
                                });
                            }
                        },
                        handleKeydown(e, index) {
                            if (e.key === 'Backspace' && !this.code[index] && index > 0) {
                                this.$nextTick(() => {
                                    this.$refs['digit' + (index - 1)].focus();
                                });
                            }
                        },
                        handlePaste(e) {
                            const pasteData = e.clipboardData.getData('text').trim().slice(0, 6).split('');
                            pasteData.forEach((char, i) => {
                                if (/^\d$/.test(char)) {
                                    this.code[i] = char;
                                }
                            });
                            const nextIndex = Math.min(pasteData.length, 5);
                            this.$nextTick(() => {
                                this.$refs['digit' + nextIndex].focus();
                            });
                        }
                    }">
                        <input type="hidden" name="code" :value="code.join('')">
                        <template x-for="(digit, index) in code" :key="index">
                            <input 
                                type="text" 
                                maxlength="1" 
                                x-model="code[index]"
                                class="w-12 h-14 text-center text-2xl font-bold bg-gray-50 border-2 border-gray-100 rounded-xl focus:border-[#8B1C3A] focus:ring-4 focus:ring-[#8B1C3A]/10 outline-none transition-all"
                                :x-ref="'digit' + index"
                                @input="handleInput($event, index)"
                                @keydown="handleKeydown($event, index)"
                                @paste="handlePaste($event)"
                                required
                            >
                        </template>
                    </div>

                    @if(session('test_verification_code'))
                        <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl text-amber-800 text-xs text-center animate-pulse">
                            <strong>Test Mode:</strong> Your activation code is <span class="font-bold text-lg block mt-1">{{ session('test_verification_code') }}</span>
                        </div>
                    @endif
                </div>

                <button type="submit" class="w-full py-4 bg-[#8B1C3A] text-white font-bold rounded-2xl hover:bg-[#a01c3a] transition-all shadow-lg shadow-[#8B1C3A]/20 text-lg">
                    Activate Now
                </button>

                <div class="text-center pt-4 border-t border-gray-50">
                    <p class="text-sm text-gray-500">Didn't receive the code?</p>
                    <button type="button" onclick="location.reload()" class="text-sm font-bold text-[#8B1C3A] hover:underline mt-1">Request New Code</button>
                </div>
            </form>
        </div>

        <div class="text-center mt-8">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">Cancel and Sign Out</button>
            </form>
        </div>
    </div>
</body>
</html>
