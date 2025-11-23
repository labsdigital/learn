<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Studi AI - Mobile</title>
    
    <!-- 1. Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- 2. Load Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet" />
    
    <!-- 3. Konfigurasi Tailwind & CSS Kustom -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3b82f6",
                        surface: "#1e293b",
                        background: "#0f172a",
                    },
                    fontFamily: {
                        display: ["Lexend", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            -webkit-tap-highlight-color: transparent; /* Hilangkan highlight biru di Android */
        }
        
        /* Animasi Sentuh */
        .btn-press:active {
            transform: scale(0.96);
            transition: transform 0.1s;
        }

        /* Flip Card Effect */
        .flip-card-container { perspective: 1000px; }
        .flip-card-inner {
            position: relative; width: 100%; height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            transform-origin: center center; /* Pastikan poros putar di tengah */
        }
        .flip-card-inner.is-flipped { transform: rotateY(180deg); }
        
        .card-front, .card-back {
            position: absolute; 
            top: 0;      /* FIX: Kunci posisi atas */
            left: 0;     /* FIX: Kunci posisi kiri */
            width: 100%; height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 1rem;
        }
        .card-back { transform: rotateY(180deg); }

        /* Hide Scrollbar but allow scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="font-display min-h-screen flex flex-col">

    <div id="app" class="flex-1 flex flex-col max-w-md mx-auto w-full bg-background min-h-screen relative shadow-xl overflow-hidden">
        
        <!-- HEADER STICKY -->
        <header id="global-header" class="sticky top-0 z-40 bg-background/80 backdrop-blur-md border-b border-slate-800 px-4 py-3 flex items-center justify-between transition-transform duration-300">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary rounded-lg shadow-lg shadow-primary/20">
                    <span class="material-symbols-rounded text-white text-xl">school</span>
                </div>
                <h1 class="text-lg font-bold tracking-tight">Studi AI</h1>
            </div>
            <!-- Tombol Tambah Mini di Header -->
            <button onclick="navigate('page-create-form')" class="btn-press p-2 bg-slate-800 rounded-full border border-slate-700 text-primary">
                <span class="material-symbols-rounded">add</span>
            </button>
        </header>

        <!-- =================================================================== -->
        <!-- HALAMAN 1: DASHBOARD (LIST VIEW)                                    -->
        <!-- =================================================================== -->
        <div id="page-deck-list" class="flex-1 flex flex-col p-4 overflow-y-auto pb-24">
            <div class="flex justify-between items-end mb-4">
                <h2 class="text-slate-400 text-sm font-medium">Koleksi Belajar</h2>
            </div>

            <main id="unit-grid" class="flex flex-col gap-3">
                <!-- Unit Cards Injected Here -->
            </main>

            <!-- Empty State -->
            <div id="empty-state" class="hidden flex-1 flex flex-col items-center justify-center text-slate-500 py-10">
                <span class="material-symbols-rounded text-6xl opacity-20 mb-4">dashboard</span>
                <p class="text-lg font-medium">Belum ada materi.</p>
                <p class="text-sm mt-1 text-center px-6">Tekan tombol + di pojok kanan atas untuk membuat baru.</p>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- HALAMAN 2: FORMULIR BUAT UNIT                                       -->
        <!-- =================================================================== -->
        <div id="page-create-form" class="hidden flex-1 flex flex-col bg-background z-50 absolute inset-0">
            <div class="px-4 py-3 border-b border-slate-800 flex items-center gap-3 bg-background">
                <button onclick="navigate('page-deck-list')" class="btn-press p-2 -ml-2 text-slate-400">
                    <span class="material-symbols-rounded text-2xl">arrow_back</span>
                </button>
                <h2 class="text-lg font-bold">Buat Materi Baru</h2>
            </div>
            
            <div class="p-4 flex flex-col gap-5 overflow-y-auto flex-1">
                <!-- Tipe Materi -->
                <div>
                    <label class="text-sm text-slate-400 mb-2 block">Pilih Tipe</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="btn-press bg-surface p-4 rounded-xl border border-slate-700 flex flex-col items-center gap-2 group selected-type ring-2 ring-primary" data-value="flashcard" onclick="selectType(this, 'flashcard')">
                            <span class="material-symbols-rounded text-3xl text-primary">style</span>
                            <span class="text-sm font-bold">Flashcard</span>
                        </button>
                        <button type="button" class="btn-press bg-surface p-4 rounded-xl border border-slate-700 flex flex-col items-center gap-2 group" data-value="quiz" onclick="selectType(this, 'quiz')">
                            <span class="material-symbols-rounded text-3xl text-purple-400">quiz</span>
                            <span class="text-sm font-bold">Kuis</span>
                        </button>
                    </div>
                </div>

                <!-- Input -->
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="text-sm text-slate-400 mb-1 block">Judul</label>
                        <input type="text" id="form-title" class="w-full bg-surface text-white p-4 rounded-xl border border-slate-700 focus:border-primary focus:outline-none transition-colors" placeholder="Cth: Bahasa Inggris Dasar" />
                    </div>
                    
                    <div>
                        <label class="text-sm text-slate-400 mb-1 block">Topik / Materi</label>
                        <textarea id="form-description" rows="4" class="w-full bg-surface text-white p-4 rounded-xl border border-slate-700 focus:border-primary focus:outline-none transition-colors" placeholder="Cth: 20 kosakata tentang hewan peliharaan"></textarea>
                    </div>
                </div>

                <div class="flex-1"></div> <!-- Spacer -->

                <button id="btn-generate" class="btn-press w-full bg-primary text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-primary/25 mb-4">
                    <span class="material-symbols-rounded">auto_awesome</span>
                    Generate dengan AI
                </button>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- HALAMAN 3: FLASHCARD PLAYER                                         -->
        <!-- =================================================================== -->
        <div id="page-flashcard-player" class="hidden flex-1 flex flex-col bg-background z-50 absolute inset-0">
            <!-- Top Nav -->
            <div class="px-4 py-3 flex items-center justify-between">
                <button onclick="navigate('page-deck-list')" class="btn-press p-2 -ml-2 text-slate-400 bg-surface/50 rounded-full">
                    <span class="material-symbols-rounded">close</span>
                </button>
                <div class="text-sm font-mono text-primary bg-primary/10 px-3 py-1 rounded-full border border-primary/20">
                    <span id="fc-idx">1</span> / <span id="fc-total">10</span>
                </div>
            </div>

            <!-- Card Area -->
            <div class="flex-1 flex flex-col items-center justify-center p-6 relative perspective-container">
                <div class="w-full aspect-[3/4] max-h-[60vh] flip-card-container">
                    <div id="flashcard-inner" class="flip-card-inner cursor-pointer" onclick="this.classList.toggle('is-flipped')">
                        <!-- Front (PERBAIKAN: Hapus class 'relative') -->
                        <div class="card-front bg-surface border border-slate-700 flex flex-col items-center justify-center p-6 text-center shadow-2xl overflow-hidden">
                            <div class="absolute top-0 w-full h-1 bg-primary"></div>
                            <span class="text-primary text-xs font-bold tracking-widest uppercase mb-4 opacity-70">Pertanyaan</span>
                            <p id="fc-front" class="text-2xl font-semibold leading-relaxed">...</p>
                            <span class="absolute bottom-6 text-xs text-slate-500 flex items-center gap-1 animate-pulse">
                                <span class="material-symbols-rounded text-sm">touch_app</span> Tap untuk balik
                            </span>
                        </div>
                        <!-- Back (PERBAIKAN: Hapus class 'relative') -->
                        <div class="card-back bg-indigo-900 border border-indigo-700 flex flex-col items-center justify-center p-6 text-center shadow-2xl overflow-hidden">
                            <div class="absolute top-0 w-full h-1 bg-indigo-400"></div>
                            <span class="text-indigo-300 text-xs font-bold tracking-widest uppercase mb-4 opacity-70">Jawaban</span>
                            <p id="fc-back" class="text-xl font-medium leading-relaxed text-indigo-100">...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Controls -->
            <div class="p-6 grid grid-cols-2 gap-4">
                <button id="btn-fc-prev" onclick="prevFlashcard()" class="btn-press py-4 bg-surface rounded-xl border border-slate-700 flex items-center justify-center disabled:opacity-30">
                    <span class="material-symbols-rounded text-3xl text-slate-300">chevron_left</span>
                </button>
                <button id="btn-fc-next" onclick="nextFlashcard()" class="btn-press py-4 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20 disabled:opacity-30">
                    <span class="material-symbols-rounded text-3xl">chevron_right</span>
                </button>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- HALAMAN 4: KUIS PLAYER                                              -->
        <!-- =================================================================== -->
        <div id="page-quiz-player" class="hidden flex-1 flex flex-col bg-background z-50 absolute inset-0">
             <div class="px-4 py-4 border-b border-slate-800">
                <div class="flex justify-between items-center mb-3">
                    <button onclick="navigate('page-deck-list')" class="text-slate-400 text-sm flex items-center gap-1">
                        <span class="material-symbols-rounded text-sm">close</span> Keluar
                    </button>
                    <span class="text-xs text-slate-500 font-mono" id="quiz-counter-text">1/10</span>
                </div>
                <!-- Progress Bar -->
                <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                    <div id="quiz-progress-bar" class="h-full bg-green-500 transition-all duration-500 ease-out" style="width: 0%"></div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-5 pb-20">
                <!-- Soal -->
                <div class="mb-8">
                    <h1 id="quiz-question" class="text-xl font-semibold leading-relaxed text-white">...</h1>
                </div>

                <!-- Pilihan Jawaban -->
                <div class="flex flex-col gap-3" id="quiz-options-container">
                    <!-- Options injected via JS -->
                </div>
            </div>

             <!-- Feedback Overlay (Toast) -->
             <div id="quiz-feedback" class="absolute bottom-10 left-1/2 -translate-x-1/2 bg-slate-800 border border-slate-700 px-6 py-3 rounded-full flex items-center gap-3 shadow-2xl opacity-0 transition-all pointer-events-none transform translate-y-10">
                <!-- Content injected -->
             </div>
        </div>

        <!-- LOADING OVERLAY -->
        <div id="loading-overlay" class="fixed inset-0 z-[60] bg-background/90 backdrop-blur-sm flex flex-col items-center justify-center hidden">
            <div class="w-12 h-12 border-4 border-t-primary border-slate-700 rounded-full animate-spin mb-4"></div>
            <h2 class="text-lg font-medium animate-pulse">Membuat Materi...</h2>
        </div>
        
        <!-- RESULT OVERLAY -->
        <div id="result-overlay" class="fixed inset-0 z-50 bg-background flex flex-col items-center justify-center hidden p-6 animate-fade-in">
            <div class="w-24 h-24 bg-surface rounded-full flex items-center justify-center mb-6 shadow-xl ring-4 ring-primary/20">
                <span class="material-symbols-rounded text-5xl text-yellow-400">emoji_events</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Selesai!</h1>
            <p class="text-slate-400 mb-8">Skor Kuis Anda</p>
            
            <div class="text-6xl font-bold text-primary mb-12 tracking-tighter">
                <span id="result-score">0</span>
            </div>

            <button onclick="closeResult()" class="btn-press w-full bg-slate-800 border border-slate-700 text-white font-medium py-4 rounded-xl">
                Kembali ke Menu
            </button>
        </div>

    </div>

    <!-- LOGIC -->
    <script>
        // --- CONFIG & STATE ---
        const API_URL = 'https://taraka.id/apigate/cr-llama.php';
        let db = { units: [] };
        let currentUnit = null;
        let currentIndex = 0;
        let quizScore = 0;
        let isQuizAnswered = false;

        // --- INIT ---
        window.onload = () => {
            loadDB();
            renderDeckList();
        };

        // --- NAVIGATION ---
        function navigate(pageId) {
            // Sembunyikan semua halaman kecuali yang dituju
            ['page-deck-list', 'page-create-form', 'page-flashcard-player', 'page-quiz-player'].forEach(id => {
                const el = document.getElementById(id);
                if(id === pageId) {
                    el.classList.remove('hidden');
                    // Reset scroll
                    if(el.querySelector('.overflow-y-auto')) el.querySelector('.overflow-y-auto').scrollTop = 0;
                } else {
                    el.classList.add('hidden');
                }
            });

            // Toggle Header Utama (hanya muncul di Deck List)
            const header = document.getElementById('global-header');
            if(pageId === 'page-deck-list') {
                header.classList.remove('-translate-y-full');
            } else {
                header.classList.add('-translate-y-full');
            }
            
            // Reset Flashcard Flip State
            if (pageId === 'page-flashcard-player') {
                document.getElementById('flashcard-inner').classList.remove('is-flipped');
            }
        }

        // --- DATA MANAGEMENT ---
        function loadDB() {
            const data = localStorage.getItem('mobile_edu_app');
            if (data) db = JSON.parse(data);
        }

        function saveDB() {
            localStorage.setItem('mobile_edu_app', JSON.stringify(db));
        }

        // --- PAGE: DECK LIST ---
        function renderDeckList() {
            const container = document.getElementById('unit-grid');
            const empty = document.getElementById('empty-state');
            container.innerHTML = '';

            if (db.units.length === 0) {
                empty.classList.remove('hidden');
            } else {
                empty.classList.add('hidden');
                // Reverse agar yang baru di atas
                [...db.units].reverse().forEach((unit) => {
                    const icon = unit.type === 'flashcard' ? 'style' : 'quiz';
                    const colorClass = unit.type === 'flashcard' ? 'text-primary bg-primary/10' : 'text-purple-400 bg-purple-500/10';
                    const borderColor = unit.type === 'flashcard' ? 'border-l-primary' : 'border-l-purple-500';
                    
                    const html = `
                        <div class="btn-press bg-surface p-4 rounded-xl border border-slate-700 border-l-4 ${borderColor} flex items-center justify-between shadow-sm" onclick="playUnit('${unit.id}')">
                            <div class="flex items-center gap-4 overflow-hidden">
                                <div class="p-3 rounded-full ${colorClass} shrink-0">
                                    <span class="material-symbols-rounded text-2xl">${icon}</span>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base font-bold text-white truncate">${unit.title}</h3>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate">${unit.count} Item • ${new Date(parseInt(unit.id)).toLocaleDateString()}</p>
                                </div>
                            </div>
                            <button class="p-2 text-slate-600 hover:text-red-400 z-10" onclick="deleteUnit(event, '${unit.id}')">
                                <span class="material-symbols-rounded">delete</span>
                            </button>
                        </div>
                    `;
                    container.innerHTML += html;
                });
            }
        }

        function playUnit(id) {
            currentUnit = db.units.find(u => u.id === id);
            currentIndex = 0;
            if (currentUnit.type === 'flashcard') {
                navigate('page-flashcard-player');
                renderFlashcard(); 
            } else {
                quizScore = 0;
                renderQuiz();
                navigate('page-quiz-player');
            }
        }

        function deleteUnit(e, id) {
            e.stopPropagation(); // Mencegah klik parent (playUnit)
            if (confirm('Hapus materi ini?')) {
                db.units = db.units.filter(u => u.id !== id);
                saveDB();
                renderDeckList();
            }
        }

        // --- PAGE: CREATE ---
        let selectedType = 'flashcard';
        function selectType(el, type) {
            selectedType = type;
            document.querySelectorAll('.selected-type').forEach(b => {
                b.classList.remove('ring-2', 'ring-primary', 'selected-type');
            });
            el.classList.add('ring-2', 'ring-primary', 'selected-type');
        }

        document.getElementById('btn-generate').addEventListener('click', async () => {
            const title = document.getElementById('form-title').value;
            const desc = document.getElementById('form-description').value;
            
            if (!title || !desc) return alert("Mohon isi judul dan topik!");

            document.getElementById('loading-overlay').classList.remove('hidden');
            document.getElementById('loading-overlay').classList.add('flex');

            // AI PROMPT LOGIC
            const system = "Anda asisten pendidikan. HANYA Jawab JSON valid minified tanpa markdown.";
            let prompt = "";
            if (selectedType === 'flashcard') {
                prompt = `Topik: ${desc}\nJumlah: 20\nBuat materi flashcard JSON format: {"cards": [{"term": "singkat", "definition": "penjelasan jelas"}]}`;
            } else {
                prompt = `Topik: ${desc}\nJumlah: 20\nBuat materi kuis JSON format: {"questions": [{"question": "...", "options": ["A","B","C","D"], "answer": "text exact match"}]}`;
            }

            try {
                const req = await fetch(API_URL, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ prompt, system })
                });
                let text = await req.text();
                // Basic cleanup
                text = text.replace(/```json/g, '').replace(/```/g, '').trim();
                if (text.startsWith('"')) text = JSON.parse(text); 
                
                const data = JSON.parse(text);
                
                const newUnit = {
                    id: Date.now().toString(),
                    title: title,
                    type: selectedType,
                    count: 20, 
                    ...data
                };
                
                db.units.push(newUnit);
                saveDB();
                
                // Reset form
                document.getElementById('loading-overlay').classList.add('hidden');
                document.getElementById('form-title').value = '';
                document.getElementById('form-description').value = '';
                
                renderDeckList();
                navigate('page-deck-list');

            } catch (e) {
                console.error(e);
                alert("Gagal koneksi AI. Coba lagi.");
                document.getElementById('loading-overlay').classList.add('hidden');
            }
        });

        // --- PAGE: FLASHCARD ---
        function renderFlashcard() {
            const card = currentUnit.cards[currentIndex];
            document.getElementById('fc-idx').innerText = currentIndex + 1;
            document.getElementById('fc-total').innerText = currentUnit.cards.length;
            document.getElementById('fc-front').innerText = card.term;
            document.getElementById('fc-back').innerText = card.definition;
            
            const btnPrev = document.getElementById('btn-fc-prev');
            const btnNext = document.getElementById('btn-fc-next');
            
            btnPrev.disabled = currentIndex === 0;
            btnNext.disabled = currentIndex === currentUnit.cards.length - 1;
        }

        function nextFlashcard() {
            if (currentIndex < currentUnit.cards.length - 1) {
                currentIndex++;
                document.getElementById('flashcard-inner').classList.remove('is-flipped');
                setTimeout(() => renderFlashcard(), 150); // Delay dikit biar animasi smooth
            }
        }

        function prevFlashcard() {
            if (currentIndex > 0) {
                currentIndex--;
                document.getElementById('flashcard-inner').classList.remove('is-flipped');
                setTimeout(() => renderFlashcard(), 150);
            }
        }

        // --- PAGE: QUIZ ---
        function renderQuiz() {
            isQuizAnswered = false;
            const q = currentUnit.questions[currentIndex];
            const total = currentUnit.questions.length;
            
            document.getElementById('quiz-question').innerText = q.question;
            document.getElementById('quiz-counter-text').innerText = `${currentIndex + 1}/${total}`;
            document.getElementById('quiz-progress-bar').style.width = `${((currentIndex) / total) * 100}%`;

            const container = document.getElementById('quiz-options-container');
            container.innerHTML = '';
            
            // Shuffle options
            const opts = [...q.options].sort(() => Math.random() - 0.5);

            opts.forEach((opt) => {
                const btn = document.createElement('button');
                btn.className = 'btn-press w-full bg-surface p-4 rounded-xl border border-slate-700 text-left text-sm font-medium text-slate-200 transition-all';
                btn.innerText = opt;
                btn.onclick = () => handleQuizAnswer(btn, opt, q.answer);
                container.appendChild(btn);
            });
        }

        function handleQuizAnswer(btn, selected, correct) {
            if (isQuizAnswered) return;
            isQuizAnswered = true;

            const feedback = document.getElementById('quiz-feedback');
            
            // Animasi feedback toast
            feedback.classList.remove('opacity-0', 'translate-y-10');
            
            if (selected === correct) {
                quizScore++;
                btn.classList.remove('bg-surface', 'border-slate-700');
                btn.classList.add('bg-green-600', 'border-green-500', 'text-white', 'shadow-lg');
                feedback.innerHTML = '<span class="material-symbols-rounded text-green-400">check_circle</span> <span class="text-white font-bold">Benar!</span>';
                feedback.className = "absolute bottom-10 left-1/2 -translate-x-1/2 bg-slate-800 border border-green-900 px-6 py-3 rounded-full flex items-center gap-3 shadow-2xl transition-all pointer-events-none transform";
            } else {
                btn.classList.remove('bg-surface', 'border-slate-700');
                btn.classList.add('bg-red-600', 'border-red-500', 'text-white');
                feedback.innerHTML = `<span class="material-symbols-rounded text-red-400">cancel</span> <span class="text-white">Jawaban: ${correct}</span>`;
                feedback.className = "absolute bottom-10 left-1/2 -translate-x-1/2 bg-slate-800 border border-red-900 px-6 py-3 rounded-full flex items-center gap-3 shadow-2xl transition-all pointer-events-none transform";
            }

            // Auto advance
            setTimeout(() => {
                feedback.classList.add('opacity-0', 'translate-y-10');
                if (currentIndex < currentUnit.questions.length - 1) {
                    currentIndex++;
                    renderQuiz();
                } else {
                    showResult();
                }
            }, 1800);
        }

        function showResult() {
            const overlay = document.getElementById('result-overlay');
            document.getElementById('result-score').innerText = `${quizScore}/${currentUnit.questions.length}`;
            overlay.classList.remove('hidden');
        }

        function closeResult() {
            document.getElementById('result-overlay').classList.add('hidden');
            navigate('page-deck-list');
        }

    </script>
</body>
</html>
