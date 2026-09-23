let audioContext = null;

function ensureAudioContext() {
    if (!audioContext) {
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
    }

    if (audioContext.state === 'suspended') {
        audioContext.resume().catch(() => {});
    }

    return audioContext;
}

function playHoverSfx() {
    if (!audioContext || audioContext.state !== 'running') {
        return;
    }

    const now = audioContext.currentTime;
    const oscillator = audioContext.createOscillator();
    const gain = audioContext.createGain();

    oscillator.type = 'triangle';
    oscillator.frequency.setValueAtTime(660, now);
    oscillator.frequency.exponentialRampToValueAtTime(440, now + 0.06);

    gain.gain.setValueAtTime(0.0001, now);
    gain.gain.exponentialRampToValueAtTime(0.12, now + 0.01);
    gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.08);

    oscillator.connect(gain);
    gain.connect(audioContext.destination);

    oscillator.start(now);
    oscillator.stop(now + 0.09);
}

function triggerMenuWiggle(target) {
    if (!target.classList.contains('menu-shake')) {
        return;
    }

    target.classList.remove('menu-wiggle-once');
    void target.offsetWidth;
    target.classList.add('menu-wiggle-once');
}

document.addEventListener(
    'animationend',
    (event) => {
        const target = event.target instanceof Element ? event.target.closest('.menu-shake') : null;
        if (!target) {
            return;
        }

        if (event.animationName !== 'menu-wiggle') {
            return;
        }

        target.classList.remove('menu-wiggle-once');
    },
    true
);

window.addEventListener(
    'pointerdown',
    () => {
        ensureAudioContext();
    },
    { once: true }
);

document.addEventListener('pointerover', (event) => {
    const target = event.target instanceof Element ? event.target.closest('[data-sfx="hover"]') : null;
    if (!target) {
        return;
    }

    const related = event.relatedTarget instanceof Element ? event.relatedTarget : null;
    if (related && target.contains(related)) {
        return;
    }

    playHoverSfx();
    triggerMenuWiggle(target);
});

function initAppLoader() {
    const preloader = document.getElementById('globalAppPreloader');
    const progressBar = document.getElementById('loaderProgressBar');
    const percentText = document.getElementById('loaderPercent');
    const root = document.querySelector('[data-app-root]');

    if (!preloader) {
        if (root) root.style.visibility = 'visible';
        return;
    }

    let alreadyBooted = false;
    try {
        alreadyBooted = sessionStorage.getItem('app.booted') === '1';
    } catch {
        alreadyBooted = false;
    }

    if (alreadyBooted) {
        if (root) root.style.visibility = 'visible';
        preloader.style.display = 'none';
        preloader.setAttribute('aria-hidden', 'true');
        return;
    }

    // List of all essential WebP assets and background audio to preload
    const assetsToPreload = Array.isArray(window.__SABI_ALL_ASSETS) && window.__SABI_ALL_ASSETS.length > 0
        ? window.__SABI_ALL_ASSETS
        : [
            '/assets/pantai.webp',
            '/assets/sabi.webp',
            '/assets/c_kerang.webp',
            '/assets/c_menyapa.webp',
            '/assets/c_ide.webp',
            '/assets/c_berpikir.webp',
            '/assets/c_jempol.webp',
            '/assets/c_aksesoris.webp',
            '/assets/pohon.webp',
            '/assets/kapal.webp',
            '/assets/mulai.webp',
            '/assets/menubisnisku.webp',
            '/assets/menupanduan.webp',
            '/assets/menutentangmedia.webp',
            '/assets/idebisnisku.webp',
            '/assets/rencanakeuangan.webp',
            '/assets/pengembanganbisnis.webp',
            '/assets/mulaibisnisku_button.webp',
            '/assets/panduan_button.webp',
            '/assets/tentang_button.webp',
            '/assets/pengaturan_button.webp',
            '/assets/home_button.webp',
            '/assets/left_button.webp',
            '/assets/right_button.webp',
            '/assets/exit_button.webp',
            '/assets/IDE.webp',
            '/assets/RENCANA.webp',
            '/assets/PENGEMBANGAN.webp',
            '/assets/TUJUAN.webp',
            '/assets/CAPAIAN.webp',
            '/assets/pengembang1.webp',
            '/assets/pengembang2.webp',
            '/assets/pengembang3.webp',
            '/assets/gelang.webp',
            '/assets/kalung.webp',
            '/assets/ganci.webp',
            '/assets/hiasan.webp'
        ];

    const routesToPrefetch = Array.isArray(window.__SABI_PREFETCH_ROUTES) ? window.__SABI_PREFETCH_ROUTES : [];

    window.__SABI_IMG_CACHE = window.__SABI_IMG_CACHE || [];
    window.__SABI_PAGE_CACHE = window.__SABI_PAGE_CACHE || new Map();

    const totalCount = assetsToPreload.length + routesToPrefetch.length + 1; // +1 for fonts
    let loadedCount = 0;

    const updateProgress = () => {
        loadedCount++;
        const percent = Math.min(100, Math.round((loadedCount / totalCount) * 100));
        if (progressBar) {
            progressBar.style.width = `${percent}%`;
        }
        if (percentText) {
            percentText.textContent = `${percent}%`;
        }
    };

    const loadSingleImage = (url) => {
        return new Promise((resolve) => {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                if (typeof img.decode === 'function') {
                    img.decode().catch(() => {}).then(() => {
                        updateProgress();
                        resolve(true);
                    });
                } else {
                    updateProgress();
                    resolve(true);
                }
            };
            img.onerror = () => {
                updateProgress();
                resolve(false);
            };
            img.src = url;
            window.__SABI_IMG_CACHE.push(img);
        });
    };

    const prefetchSingleRoute = (url) => {
        return fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then((res) => res.text())
            .then((html) => {
                window.__SABI_PAGE_CACHE.set(url, html);
                updateProgress();
                return true;
            })
            .catch(() => {
                updateProgress();
                return false;
            });
    };

    const loadFonts = () => {
        const fonts = document.fonts;
        if (!fonts || typeof fonts.ready?.then !== 'function') {
            updateProgress();
            return Promise.resolve(true);
        }
        return fonts.ready.then(
            () => { updateProgress(); return true; },
            () => { updateProgress(); return true; }
        );
    };

    const imagePromises = assetsToPreload.map(loadSingleImage);
    const routePromises = routesToPrefetch.map(prefetchSingleRoute);
    const allLoaders = Promise.all([...imagePromises, ...routePromises, loadFonts()]);

    // Safety timeout: max wait 2.5 seconds
    const timeoutPromise = new Promise((resolve) => setTimeout(resolve, 2500));

    Promise.race([allLoaders, timeoutPromise]).then(() => {
        if (typeof window.dismissAppPreloader === 'function') {
            window.dismissAppPreloader();
        } else {
            if (progressBar) progressBar.style.width = '100%';
            if (percentText) percentText.textContent = '100%';

            setTimeout(() => {
                try {
                    sessionStorage.setItem('app.booted', '1');
                } catch {}

                if (root) root.style.visibility = 'visible';
                preloader.style.opacity = '0';
                preloader.style.transition = 'opacity 350ms ease-out, transform 350ms ease-out';
                preloader.style.transform = 'scale(1.02)';
                preloader.style.pointerEvents = 'none';
                preloader.setAttribute('aria-hidden', 'true');

                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 400);
            }, 200);
        }
    });
}

function initInstrumentCarousel() {
    const viewer = document.getElementById('instrumentViewer');
    const nameEl = document.getElementById('instrumentName');
    const descEl = document.getElementById('instrumentDescription');
    const dataEl = document.getElementById('instrumentData');
    const prevBtn = document.querySelector('[data-instrument-prev]');
    const nextBtn = document.querySelector('[data-instrument-next]');
    const audioEl = document.getElementById('instrumentAudio');
    const audioToggle = document.querySelector('[data-instrument-audio-toggle]');
    const audioIcon = document.querySelector('[data-instrument-audio-icon]');

    if (!viewer || !dataEl || !prevBtn || !nextBtn) {
        return;
    }

    let instruments = [];
    try {
        instruments = JSON.parse(dataEl.textContent || '[]');
    } catch {
        instruments = [];
    }

    if (!Array.isArray(instruments) || instruments.length === 0) {
        return;
    }

    let index = 0;
    let isPlaying = false;

    const setAudioUi = (playing) => {
        isPlaying = playing;
        if (audioIcon) {
            audioIcon.setAttribute('src', playing ? '/assets/pause.png' : '/assets/play.png');
            audioIcon.setAttribute('alt', playing ? 'Pause' : 'Play');
        }
    };

    const stopAudio = () => {
        if (!audioEl) {
            return;
        }
        audioEl.pause();
        try {
            audioEl.currentTime = 0;
        } catch {
            // ignore
        }
        setAudioUi(false);
    };

    const render = () => {
        const item = instruments[index];
        if (!item) {
            return;
        }

        stopAudio();

        if (typeof item.src === 'string' && item.src.length) {
            viewer.setAttribute('src', item.src);
        }

        if (nameEl) {
            nameEl.textContent = item.name ?? 'Alat Musik';
        }

        if (descEl) {
            descEl.textContent = item.description ?? '';
        }

        if (audioEl) {
            const audioSrc = typeof item.audio === 'string' ? item.audio : '';
            audioEl.removeAttribute('src');
            audioEl.load();
            if (audioSrc) {
                audioEl.setAttribute('src', audioSrc);
            }
        }
    };

    prevBtn.addEventListener('click', () => {
        index = (index - 1 + instruments.length) % instruments.length;
        render();
    });

    nextBtn.addEventListener('click', () => {
        index = (index + 1) % instruments.length;
        render();
    });

    if (audioEl) {
        audioEl.addEventListener('ended', () => {
            setAudioUi(false);
        });
        audioEl.addEventListener('pause', () => {
            if (audioEl.currentTime === 0 || audioEl.ended) {
                setAudioUi(false);
            } else {
                setAudioUi(false);
            }
        });
        audioEl.addEventListener('play', () => {
            setAudioUi(true);
        });
    }

    if (audioToggle) {
        audioToggle.addEventListener('click', async () => {
            if (!audioEl || !audioEl.getAttribute('src')) {
                return;
            }
            if (audioEl.paused) {
                try {
                    await audioEl.play();
                    setAudioUi(true);
                } catch {
                    setAudioUi(false);
                }
            } else {
                audioEl.pause();
                setAudioUi(false);
            }
        });
    }

    render();
}

function initFontControls() {
    const increaseBtn = document.querySelector('[data-font-increase]');
    const decreaseBtn = document.querySelector('[data-font-decrease]');
    const boldBtn = document.querySelector('[data-font-bold]');
    const indicator = document.querySelector('[data-font-indicator]');
    const targets = Array.from(document.querySelectorAll('[data-font-target]'));

    if (!increaseBtn || !decreaseBtn || !indicator || targets.length === 0) {
        return;
    }

    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
    const step = 0.1;
    const minScale = 0.8;
    const maxScale = 1.5;

    const readScale = () => {
        const stored = Number.parseFloat(localStorage.getItem('ui.fontScale') || '1');
        return Number.isFinite(stored) ? clamp(stored, minScale, maxScale) : 1;
    };

    const writeScale = (value) => {
        localStorage.setItem('ui.fontScale', String(value));
    };

    const readBold = () => {
        return localStorage.getItem('ui.fontBold') === '1';
    };

    const writeBold = (value) => {
        localStorage.setItem('ui.fontBold', value ? '1' : '0');
    };

    const apply = (scale, bold) => {
        targets.forEach((el) => {
            const rawBase = el.getAttribute('data-font-base') || '1.25';
            const base = Number.parseFloat(rawBase);
            const safeBase = Number.isFinite(base) ? base : 1.25;
            el.style.fontSize = `${safeBase * scale}rem`;
            el.style.fontWeight = bold ? '700' : '';
        });

        indicator.textContent = `${Math.round(scale * 100)}%`;

        if (boldBtn) {
            boldBtn.classList.toggle('bg-lime-200', bold);
            boldBtn.classList.toggle('border-lime-400', bold);
        }
    };

    let scale = readScale();
    let bold = readBold();
    apply(scale, bold);

    decreaseBtn.addEventListener('click', () => {
        scale = clamp(Math.round((scale - step) * 10) / 10, minScale, maxScale);
        writeScale(scale);
        apply(scale, bold);
    });

    increaseBtn.addEventListener('click', () => {
        scale = clamp(Math.round((scale + step) * 10) / 10, minScale, maxScale);
        writeScale(scale);
        apply(scale, bold);
    });

    if (boldBtn) {
        boldBtn.addEventListener('click', () => {
            bold = !bold;
            writeBold(bold);
            apply(scale, bold);
        });
    }
}

function initProfilePhotoModal() {
    const modal = document.getElementById('profilePhotoModal');
    const modalImg = document.getElementById('profilePhotoModalImg');
    const closeBtn = document.querySelector('[data-photo-close]');
    const openBtns = Array.from(document.querySelectorAll('[data-photo-open]'));

    if (!modal || !modalImg || !closeBtn || openBtns.length === 0) {
        return;
    }

    const open = (src, alt) => {
        modalImg.src = src || '';
        modalImg.alt = alt || '';
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    };

    const close = () => {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        modalImg.src = '';
        modalImg.alt = '';
    };

    openBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const src = btn.getAttribute('data-photo-src') || '';
            const alt = btn.getAttribute('data-photo-alt') || '';
            open(src, alt);
        });
    });

    closeBtn.addEventListener('click', close);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
            close();
        }
    });
}

function initProfileDropdown() {
    const toggle = document.querySelector('[data-profile-dropdown-toggle]');
    const menu = document.querySelector('[data-profile-dropdown]');

    if (!toggle || !menu) {
        return;
    }

    const open = () => {
        menu.classList.remove('hidden');
        menu.setAttribute('aria-hidden', 'false');
    };

    const close = () => {
        menu.classList.add('hidden');
        menu.setAttribute('aria-hidden', 'true');
    };

    const isOpen = () => !menu.classList.contains('hidden');

    toggle.addEventListener('click', (event) => {
        event.stopPropagation();
        if (isOpen()) {
            close();
        } else {
            open();
        }
    });

    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target : null;
        if (!target) {
            close();
            return;
        }

        if (menu.contains(target) || toggle.contains(target)) {
            return;
        }

        close();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });
}

function initSettingsDropdown() {
    const toggle = document.querySelector('[data-settings-dropdown-toggle]');
    const menu = document.querySelector('[data-settings-dropdown]');

    if (!toggle || !menu) {
        return;
    }

    const open = () => {
        menu.classList.remove('hidden');
        menu.setAttribute('aria-hidden', 'false');
    };

    const close = () => {
        menu.classList.add('hidden');
        menu.setAttribute('aria-hidden', 'true');
    };

    const isOpen = () => !menu.classList.contains('hidden');

    toggle.addEventListener('click', (event) => {
        event.stopPropagation();
        if (isOpen()) {
            close();
        } else {
            open();
        }
    });

    menu.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target : null;
        if (!target) {
            return;
        }

        if (target.closest('[data-settings-item]')) {
            close();
        }
    });

    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target : null;
        if (!target) {
            close();
            return;
        }

        if (menu.contains(target) || toggle.contains(target)) {
            return;
        }

        close();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });
}

async function lockLandscape() {
    try {
        const orientation = screen && screen.orientation ? screen.orientation : null;
        if (orientation && typeof orientation.lock === 'function') {
            await orientation.lock('landscape');
        }
    } catch {
    }
}

function unlockOrientation() {
    try {
        const orientation = screen && screen.orientation ? screen.orientation : null;
        if (orientation && typeof orientation.unlock === 'function') {
            orientation.unlock();
        }
    } catch {
    }
}

async function requestFullscreen() {
    try {
        const el = document.documentElement;
        if (el && typeof el.requestFullscreen === 'function') {
            await el.requestFullscreen();
            return true;
        }
    } catch {
    }
    return false;
}

function isFullscreen() {
    return Boolean(document.fullscreenElement);
}

function initFullscreenSetting() {
    const btn = document.querySelector('[data-fullscreen-toggle]');
    const label = document.querySelector('[data-fullscreen-label]');

    if (!btn) {
        return;
    }

    const updateLabel = () => {
        if (!label) {
            return;
        }
        label.textContent = isFullscreen() ? 'Keluar Fullscreen' : 'Masuk Fullscreen';
    };

    updateLabel();

    document.addEventListener('fullscreenchange', () => {
        updateLabel();
    });

    btn.addEventListener('click', async () => {
        try {
            if (!isFullscreen()) {
                const ok = await requestFullscreen();
                if (ok) {
                    await lockLandscape();
                    try {
                        sessionStorage.setItem('app.fullscreen.preferred', '1');
                        sessionStorage.removeItem('app.fullscreen.next');
                    } catch {
                    }
                }
            } else if (typeof document.exitFullscreen === 'function') {
                await document.exitFullscreen();
                unlockOrientation();
                try {
                    sessionStorage.setItem('app.fullscreen.preferred', '0');
                    sessionStorage.removeItem('app.fullscreen.next');
                } catch {
                }
            }
        } catch {
        }

        updateLabel();
    });
}

function initFullscreenResumePrompt() {
    const modal = document.querySelector('[data-fullscreen-resume-modal]');
    const yesBtn = document.querySelector('[data-fullscreen-resume-yes]');
    const noBtn = document.querySelector('[data-fullscreen-resume-no]');

    if (!(modal instanceof HTMLElement) || !(yesBtn instanceof HTMLElement) || !(noBtn instanceof HTMLElement)) {
        return;
    }

    let prompted = false;
    try {
        prompted = sessionStorage.getItem('app.fullscreen.prompted') === '1';
    } catch {
        prompted = false;
    }

    if (prompted || isFullscreen()) {
        return;
    }

    const open = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
    };

    const close = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
    };

    open();

    yesBtn.addEventListener('click', async () => {
        close();
        const ok = await requestFullscreen();
        if (ok) {
            await lockLandscape();
        }
        try {
            sessionStorage.setItem('app.fullscreen.preferred', ok ? '1' : '0');
            sessionStorage.setItem('app.fullscreen.prompted', '1');
        } catch {
        }
    });

    noBtn.addEventListener('click', () => {
        close();
        try {
            sessionStorage.setItem('app.fullscreen.preferred', '0');
            sessionStorage.setItem('app.fullscreen.prompted', '1');
        } catch {
        }
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
            close();
        }
    });
}

function initAsalUsulSlides() {
    const dataEl = document.getElementById('asalUsulSlides');
    const backdropEl = document.querySelector('[data-asal-backdrop]');
    const prevBtn = document.querySelector('[data-asal-prev]');
    const nextBtn = document.querySelector('[data-asal-next]');
    const exitEl = document.getElementById('asalUsulExit');
    const pageElements = document.querySelectorAll('.flipbook-page');

    if (!dataEl || !pageElements || pageElements.length === 0 || !prevBtn || !nextBtn) {
        return;
    }

    let slides = [];
    try {
        slides = JSON.parse(dataEl.textContent || '[]');
    } catch {
        slides = [];
    }

    if (!Array.isArray(slides) || slides.length === 0) {
        return;
    }

    let index = 0;
    let isAnimating = false;

    const updateZIndices = () => {
        pageElements.forEach((page, i) => {
            if (i === index) {
                page.classList.add('front');
                page.classList.remove('flipped');
                page.style.zIndex = pageElements.length - i;
            } else if (i < index) {
                page.classList.remove('front');
                page.classList.add('flipped');
                page.style.zIndex = pageElements.length - i;
            } else {
                page.classList.remove('front');
                page.classList.add('flipped');
                page.style.zIndex = pageElements.length - i;
            }
        });
    };

    const render = () => {
        const src = slides[index];
        if (backdropEl) {
            backdropEl.style.backgroundImage = `url("${src}")`;
        }

        prevBtn.style.visibility = index === 0 ? 'hidden' : 'visible';
        nextBtn.style.visibility = index === slides.length - 1 ? 'hidden' : 'visible';

        if (exitEl) {
            exitEl.style.display = index === slides.length - 1 ? 'flex' : 'none';
        }
    };

    prevBtn.addEventListener('click', () => {
        if (isAnimating || index <= 0) return;
        isAnimating = true;

        const currentPage = pageElements[index];
        currentPage.classList.remove('front');
        currentPage.classList.remove('flipped');
        currentPage.style.zIndex = pageElements.length - index + 1;

        setTimeout(() => {
            index--;
            updateZIndices();
            render();
            isAnimating = false;
        }, 800);
    });

    nextBtn.addEventListener('click', () => {
        if (isAnimating || index >= slides.length - 1) return;
        isAnimating = true;

        const currentPage = pageElements[index];
        currentPage.classList.add('flipped');

        setTimeout(() => {
            index++;
            updateZIndices();
            render();
            isAnimating = false;
        }, 800);
    });

    updateZIndices();
    render();
}

function initProfileSenimanSlides() {
    const dataEl = document.getElementById('profileSenimanSlides');
    const imgEl = document.querySelector('[data-profile-seniman-img]');
    const textEl = document.querySelector('[data-profile-seniman-text]');
    const textWrap = document.querySelector('[data-profile-seniman-text-wrap]');
    const sideEl = document.querySelector('[data-profile-seniman-side]');
    const photoWrap = document.querySelector('[data-profile-seniman-photo-wrap]');
    const prevBtn = document.querySelector('[data-profile-seniman-prev]');
    const nextBtn = document.querySelector('[data-profile-seniman-next]');
    const photoBtn = document.querySelector('[data-profile-seniman-photo-open]');
    const normalEl = document.querySelector('[data-profile-seniman-normal]');
    const galleryEl = document.querySelector('[data-profile-seniman-gallery]');

    if (!dataEl || !prevBtn || !nextBtn) {
        return;
    }

    let slides = [];
    try {
        slides = JSON.parse(dataEl.textContent || '[]');
    } catch {
        slides = [];
    }

    if (!Array.isArray(slides) || slides.length === 0) {
        return;
    }

    let index = 0;
    const baseWrapWidth = photoWrap ? photoWrap.style.width : '';
    const baseImgTransform = imgEl ? imgEl.style.transform : '';

    const renderGallery = (images) => {
        if (!galleryEl) return;
        galleryEl.innerHTML = '';
        (images || []).forEach(image => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'block w-full max-w-[280px] md:max-w-[360px]';
            btn.setAttribute('data-photo-open', '');
            btn.setAttribute('data-photo-src', image.src || '');
            btn.setAttribute('data-photo-alt', image.alt || '');

            const img = document.createElement('img');
            img.src = image.src || '';
            img.alt = image.alt || '';
            img.className = 'w-full h-auto';
            btn.appendChild(img);
            galleryEl.appendChild(btn);
        });

        // Re-attach modal listeners for new buttons
        initProfilePhotoModal();
    };

    const render = () => {
        const item = slides[index];
        if (!item) {
            return;
        }

        if (item.type === 'gallery') {
            if (normalEl) normalEl.style.display = 'none';
            if (galleryEl) {
                galleryEl.style.display = 'flex';
                galleryEl.classList.remove('hidden');
            }
            renderGallery(item.images);
        } else {
            if (galleryEl) {
                galleryEl.style.display = 'none';
                galleryEl.classList.add('hidden');
            }
            if (normalEl) normalEl.style.display = 'flex';

            if (!imgEl || !textEl || !photoBtn) {
                return;
            }

            const src = typeof item.img === 'string' ? item.img : '';
            const alt = typeof item.alt === 'string' ? item.alt : '';
            const body = typeof item.body === 'string' ? item.body : '';
            const photo = item.photo && typeof item.photo === 'object' ? item.photo : null;
            const photoMobile = item.photo_mobile && typeof item.photo_mobile === 'object' ? item.photo_mobile : null;
            const text = item.text && typeof item.text === 'object' ? item.text : null;
            const textMobile = item.text_mobile && typeof item.text_mobile === 'object' ? item.text_mobile : null;
            const useMobile = typeof window.matchMedia === 'function' ? window.matchMedia('(max-width: 768px)').matches : window.innerWidth <= 768;

            imgEl.setAttribute('src', src);
            imgEl.setAttribute('alt', alt);
            textEl.textContent = body;

            photoBtn.setAttribute('data-photo-src', src);
            photoBtn.setAttribute('data-photo-alt', alt);

            const activePhoto = useMobile && photoMobile ? photoMobile : photo;
            const activeText = useMobile && textMobile ? textMobile : text;

            if (photoWrap) {
                const width = activePhoto && typeof activePhoto.width === 'number' && Number.isFinite(activePhoto.width) ? activePhoto.width : null;
                photoWrap.style.width = width ? `${width}px` : baseWrapWidth;
            }

            if (activePhoto) {
                const x = typeof activePhoto.shift_x === 'number' && Number.isFinite(activePhoto.shift_x) ? activePhoto.shift_x : 0;
                const y = typeof activePhoto.shift_y === 'number' && Number.isFinite(activePhoto.shift_y) ? activePhoto.shift_y : 0;
                const scale = typeof activePhoto.scale === 'number' && Number.isFinite(activePhoto.scale) ? activePhoto.scale : 1;
                imgEl.style.transform = `translate(${x}px, ${y}px) scale(${scale})`;
                imgEl.style.transformOrigin = 'center';
            } else if (imgEl) {
                imgEl.style.transform = baseImgTransform;
            }

            if (sideEl) {
                sideEl.style.display = index === 0 ? 'flex' : 'none';
            }

            if (textWrap instanceof HTMLElement) {
                const x = activeText && typeof activeText.shift_x === 'number' && Number.isFinite(activeText.shift_x) ? activeText.shift_x : 0;
                const y = activeText && typeof activeText.shift_y === 'number' && Number.isFinite(activeText.shift_y) ? activeText.shift_y : 0;
                if (x === 0 && y === 0) {
                    textWrap.style.transform = 'none';
                } else {
                    textWrap.style.transform = `translate(${x}px, ${y}px)`;
                    textWrap.style.transformOrigin = 'top left';
                }
            }
        }

        prevBtn.style.visibility = index === 0 ? 'hidden' : 'visible';
        nextBtn.style.visibility = index === slides.length - 1 ? 'hidden' : 'visible';
    };

    prevBtn.addEventListener('click', () => {
        index = Math.max(0, index - 1);
        render();
    });

    nextBtn.addEventListener('click', () => {
        index = Math.min(slides.length - 1, index + 1);
        render();
    });

    render();
}

function initOklikSim() {
    const dataEl = document.getElementById('oklikSimSounds');
    const buttons = Array.from(document.querySelectorAll('[data-oklik-sim-key]'));
    const demoAudio = document.getElementById('oklikDemoAudio');
    const demoToggle = document.querySelector('[data-oklik-demo-toggle]');
    const demoIcon = document.querySelector('[data-oklik-demo-icon]');

    if (!dataEl || buttons.length === 0) {
        return;
    }

    let sounds = {};
    try {
        sounds = JSON.parse(dataEl.textContent || '{}');
    } catch {
        sounds = {};
    }

    const activePlayers = new Set();
    const maxSimultaneous = 12;

    const playKey = async (key) => {
        const src = typeof sounds?.[key] === 'string' ? sounds[key] : '';
        if (!src) {
            return;
        }

        if (activePlayers.size >= maxSimultaneous) {
            const oldest = activePlayers.values().next().value;
            if (oldest) {
                try {
                    oldest.pause();
                } catch {
                    // ignore
                }
                activePlayers.delete(oldest);
            }
        }

        const player = new Audio(src);
        player.preload = 'auto';
        player.volume = 1;
        activePlayers.add(player);

        const cleanup = () => {
            activePlayers.delete(player);
        };

        player.addEventListener('ended', cleanup, { once: true });
        player.addEventListener('error', cleanup, { once: true });

        try {
            await player.play();
        } catch {
            cleanup();
        }
    };

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const key = btn.getAttribute('data-oklik-sim-key') || '';
            if (!key) {
                return;
            }
            playKey(key);
        });
    });

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
            activePlayers.forEach((player) => {
                try {
                    player.pause();
                } catch {
                    // ignore
                }
            });
            activePlayers.clear();

            if (demoAudio instanceof HTMLAudioElement) {
                try {
                    demoAudio.pause();
                    demoAudio.currentTime = 0;
                } catch {
                    // ignore
                }
            }
        }
    });

    if (demoAudio instanceof HTMLAudioElement && demoToggle instanceof HTMLElement) {
        const setDemoUi = (playing) => {
            if (demoIcon instanceof HTMLImageElement) {
                demoIcon.src = playing ? '/assets/pause.png' : '/assets/play.png';
                demoIcon.alt = playing ? 'Pause' : 'Play';
            }
        };

        demoToggle.addEventListener('click', async () => {
            if (demoAudio.paused) {
                try {
                    await demoAudio.play();
                    setDemoUi(true);
                } catch {
                    setDemoUi(false);
                }
            } else {
                demoAudio.pause();
                setDemoUi(false);
            }
        });

        demoAudio.addEventListener('ended', () => {
            setDemoUi(false);
        });

        demoAudio.addEventListener('pause', () => {
            if (demoAudio.ended || demoAudio.currentTime === 0) {
                setDemoUi(false);
            }
        });
    }
}

function initOrientationHandler() {
    // CSS media query sudah menangani rotasi secara otomatis.
    // Kita hanya perlu memastikan body tidak bisa di-scroll.
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
}

// ============================================================
// GLOBAL BACKGROUND MUSIC (BGM) MANAGER & SOUND SETTINGS
// ============================================================
class SabiBgmManager {
    constructor() {
        this.audioSrc = '/assets/underthesea.mp3';
        this.audio = null;
        this.volume = 0.6;
        this.isMuted = false;
        this.targetTime = 0;
        this.timeRestored = false;
        this.init();
    }

    init() {
        // 1. Read volume & mute settings
        try {
            const savedVol = localStorage.getItem('sabi_bgm_volume');
            const savedMuted = localStorage.getItem('sabi_bgm_muted');
            if (savedVol !== null) {
                const parsed = parseInt(savedVol, 10);
                if (!isNaN(parsed)) {
                    this.volume = Math.max(0, Math.min(100, parsed)) / 100;
                }
            }
            if (savedMuted !== null) {
                this.isMuted = (savedMuted === 'true');
            }
        } catch (e) {}

        // 2. Calculate target start time from previous page
        try {
            const savedTime = localStorage.getItem('sabi_bgm_time');
            const savedStamp = localStorage.getItem('sabi_bgm_timestamp');
            if (savedTime) {
                const parsedTime = parseFloat(savedTime);
                if (Number.isFinite(parsedTime) && parsedTime > 0.5) {
                    let elapsed = 0;
                    if (savedStamp) {
                        const parsedStamp = parseInt(savedStamp, 10);
                        if (!isNaN(parsedStamp)) {
                            const diff = (Date.now() - parsedStamp) / 1000;
                            if (diff > 0 && diff < 8) {
                                elapsed = diff;
                            }
                        }
                    }
                    this.targetTime = parsedTime + elapsed;
                }
            }
        } catch (e) {}

        this.timeRestored = (this.targetTime <= 0.5);

        // 3. Create or reuse global audio element
        let existingAudio = document.getElementById('sabiGlobalBgm');
        if (existingAudio) {
            this.audio = existingAudio;
            if (!this.audio.paused && this.audio.currentTime > 0.5) {
                this.timeRestored = true;
                this.applyAudioSettings();
                this.startTracking();
                this.bindModalControls();
                this.updateModalUI();
                return;
            }
        } else {
            this.audio = document.createElement('audio');
            this.audio.id = 'sabiGlobalBgm';
            this.audio.loop = true;
            this.audio.preload = 'auto';
            if (document.body) {
                document.body.appendChild(this.audio);
            } else if (document.documentElement) {
                document.documentElement.appendChild(this.audio);
            }
        }

        const targetVolume = this.isMuted ? 0 : this.volume;

        // 4. Set clean audio source dynamically
        const finalSrc = window.__SABI_BGM_URL || this.audioSrc || '/assets/underthesea.mp3';
        if (!this.audio.src || !this.audio.src.includes('underthesea')) {
            this.audio.src = finalSrc;
        }

        // Apply initial volume/mute
        this.audio.volume = targetVolume;
        this.audio.muted = this.isMuted;

        const applySeek = () => {
            if (this.targetTime > 0.5 && !this.timeRestored) {
                try {
                    if (this.audio.duration && Number.isFinite(this.audio.duration)) {
                        this.audio.currentTime = this.targetTime % this.audio.duration;
                    } else {
                        this.audio.currentTime = this.targetTime;
                    }
                    this.timeRestored = true;
                } catch (e) {}
            }
        };

        this.audio.addEventListener('loadedmetadata', applySeek);
        this.audio.addEventListener('canplay', applySeek);
        this.audio.addEventListener('play', applySeek);

        // 5. Start playback
        this.tryPlay();

        // 6. Interaction fallback if browser restricts initial autoplay
        const unlockAudio = () => {
            applySeek();
            this.tryPlay();
        };
        window.addEventListener('pointerdown', unlockAudio, { passive: true });
        window.addEventListener('click', unlockAudio, { passive: true });
        window.addEventListener('touchstart', unlockAudio, { passive: true });
        window.addEventListener('keydown', unlockAudio, { passive: true });

        // 7. Tracking & Modal UI
        this.startTracking();
        this.bindModalControls();
        this.updateModalUI();
    }

    applyAudioSettings() {
        if (!this.audio) return;
        this.audio.volume = this.isMuted ? 0 : this.volume;
        this.audio.muted = this.isMuted;
    }

    tryPlay() {
        if (!this.audio || this.isMuted) return;
        const playPromise = this.audio.play();
        if (playPromise !== undefined) {
            playPromise.catch(() => {});
        }
    }

    setVolume(val) {
        const parsed = parseInt(val, 10);
        this.volume = Math.max(0, Math.min(100, isNaN(parsed) ? 60 : parsed)) / 100;
        if (this.isMuted && this.volume > 0) {
            this.isMuted = false;
            try { localStorage.setItem('sabi_bgm_muted', 'false'); } catch (e) {}
        }
        try {
            localStorage.setItem('sabi_bgm_volume', Math.round(this.volume * 100));
        } catch (e) {}
        this.applyAudioSettings();
        this.updateModalUI();
        if (this.audio && this.audio.paused && !this.isMuted) {
            this.tryPlay();
        }
    }

    toggleMute() {
        this.isMuted = !this.isMuted;
        try {
            localStorage.setItem('sabi_bgm_muted', this.isMuted ? 'true' : 'false');
        } catch (e) {}
        this.applyAudioSettings();
        this.updateModalUI();
        if (!this.isMuted && this.audio && this.audio.paused) {
            this.tryPlay();
        }
    }

    saveCurrentState() {
        if (this.audio && Number.isFinite(this.audio.currentTime)) {
            if (this.timeRestored && this.audio.currentTime > 0.5) {
                try {
                    localStorage.setItem('sabi_bgm_time', this.audio.currentTime.toFixed(2));
                    localStorage.setItem('sabi_bgm_timestamp', Date.now().toString());
                } catch (e) {}
            }
        }
    }

    startTracking() {
        if (this.audio) {
            this.audio.addEventListener('timeupdate', () => {
                this.saveCurrentState();
            });
        }

        window.addEventListener('beforeunload', () => this.saveCurrentState());
        window.addEventListener('pagehide', () => this.saveCurrentState());
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                this.saveCurrentState();
            }
        });

        const captureNavClick = (e) => {
            const el = e.target instanceof Element ? e.target.closest('a, button, [onclick]') : null;
            if (el) {
                this.saveCurrentState();
            }
        };
        document.addEventListener('pointerdown', captureNavClick, { capture: true, passive: true });
        document.addEventListener('click', captureNavClick, { capture: true, passive: true });
    }

    updateModalUI() {
        const slider = document.getElementById('bgmVolumeSlider');
        const valText = document.getElementById('bgmVolumeVal');
        const muteBtn = document.getElementById('bgmMuteBtn');
        const muteIcon = document.getElementById('bgmMuteIcon');
        const muteLabel = document.getElementById('bgmMuteLabel');

        const volPercent = Math.round(this.volume * 100);

        if (slider) slider.value = volPercent;
        if (valText) valText.textContent = this.isMuted ? 'Mute' : volPercent + '%';

        if (muteIcon && muteLabel && muteBtn) {
            if (this.isMuted) {
                muteIcon.innerHTML = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.3"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>`;
                muteLabel.textContent = 'Mute';
                muteBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
                muteBtn.classList.add('bg-rose-500', 'hover:bg-rose-600');
            } else {
                muteIcon.innerHTML = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.3"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>`;
                muteLabel.textContent = 'Aktif';
                muteBtn.classList.remove('bg-rose-500', 'hover:bg-rose-600');
                muteBtn.classList.add('bg-green-500', 'hover:bg-green-600');
            }
        }
    }

    bindModalControls() {
        const slider = document.getElementById('bgmVolumeSlider');
        const muteBtn = document.getElementById('bgmMuteBtn');

        if (slider) {
            slider.addEventListener('input', (e) => {
                this.setVolume(e.target.value);
            });
        }

        if (muteBtn) {
            muteBtn.addEventListener('click', () => {
                this.toggleMute();
            });
        }
    }
}

// Global modal open/close accessible everywhere
window.openSettingsModal = function() {
    const modal = document.getElementById('settingsModal');
    const box = document.getElementById('settingsBox');
    if (window.sabiBgm) {
        window.sabiBgm.updateModalUI();
    }
    if (modal) {
        modal.classList.remove('opacity-0', 'pointer-events-none', 'hidden');
        modal.classList.add('opacity-100', 'pointer-events-auto', 'flex');
        if (box) {
            box.classList.remove('scale-90');
            box.classList.add('scale-100');
        }
    }
};

window.closeSettingsModal = function() {
    const modal = document.getElementById('settingsModal');
    const box = document.getElementById('settingsBox');
    if (modal) {
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.classList.add('opacity-0', 'pointer-events-none');
        if (box) {
            box.classList.remove('scale-100');
            box.classList.add('scale-90');
        }
    }
};

// Listen for Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        window.closeSettingsModal();
    }
});

// ============================================================
// GLOBAL INITIALIZATION & SEAMLESS SPA PAGE NAVIGATION
// ============================================================
function initAllPageFeatures() {
    initOrientationHandler();
    initAppLoader();
    initInstrumentCarousel();
    initFontControls();
    initProfilePhotoModal();
    initProfileDropdown();
    initSettingsDropdown();
    initFullscreenSetting();
    initFullscreenResumePrompt();
    initAsalUsulSlides();
    initProfileSenimanSlides();
    initOklikSim();

    if (window.sabiBgm) {
        window.sabiBgm.bindModalControls();
        window.sabiBgm.updateModalUI();
    }
}

// Seamless SPA Router (Swaps page DOM without reloading window or stopping audio)
class SabiSpaRouter {
    constructor() {
        this.isNavigating = false;
        this.pageCache = window.__SABI_PAGE_CACHE = window.__SABI_PAGE_CACHE || new Map();
        this.initEventListeners();
    }

    initEventListeners() {
        // Intercept all internal navigation link clicks
        document.addEventListener('click', (e) => {
            const link = e.target instanceof Element ? e.target.closest('a') : null;
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.hasAttribute('data-no-spa') || link.target === '_blank') {
                return;
            }

            try {
                const targetUrl = new URL(href, window.location.origin);
                if (targetUrl.origin !== window.location.origin) return;
                if (targetUrl.pathname.startsWith('/admin') || targetUrl.pathname.includes('/logout')) return;

                e.preventDefault();
                this.navigateTo(targetUrl.href);
            } catch (err) {}
        });

        // Hover prefetch for instantaneous swaps
        document.addEventListener('pointerover', (e) => {
            const link = e.target instanceof Element ? e.target.closest('a') : null;
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.hasAttribute('data-no-spa') || link.target === '_blank') {
                return;
            }

            try {
                const targetUrl = new URL(href, window.location.origin);
                if (targetUrl.origin === window.location.origin && !this.pageCache.has(targetUrl.href)) {
                    fetch(targetUrl.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then((res) => res.text())
                        .then((html) => this.pageCache.set(targetUrl.href, html))
                        .catch(() => {});
                }
            } catch (err) {}
        });

        // Intercept Form Submissions
        document.addEventListener('submit', (e) => {
            const form = e.target instanceof HTMLFormElement ? e.target : null;
            if (!form) return;

            try {
                const targetUrl = new URL(form.action, window.location.origin);
                if (targetUrl.origin !== window.location.origin) return;
                if (targetUrl.pathname.startsWith('/admin') || targetUrl.pathname.includes('/logout')) return;

                // For AJAX-handled forms with their own JS handlers, let them proceed
                if (
                    form.id === 'ideBisnisForm' ||
                    form.id === 'hitungModalForm' ||
                    form.id === 'hitungTotalUsahaForm' ||
                    form.id === 'studiKasusTabunganForm' ||
                    form.id === 'studiKasusInvestasiForm' ||
                    form.hasAttribute('data-no-spa') ||
                    !form.getAttribute('action')
                ) return;

                e.preventDefault();
                const formData = new FormData(form);
                const method = (form.method || 'POST').toUpperCase();

                this.submitForm(targetUrl.href, method, formData);
            } catch (err) {}
        });

        // Handle Browser Back / Forward buttons
        window.addEventListener('popstate', () => {
            this.navigateTo(window.location.href, false);
        });
    }

    async submitForm(url, method, formData) {
        if (this.isNavigating) return;
        this.isNavigating = true;

        try {
            const options = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            };
            if (method === 'GET') {
                const params = new URLSearchParams(formData).toString();
                url = url + (url.includes('?') ? '&' : '?') + params;
            } else {
                options.body = formData;
            }

            const response = await fetch(url, options);
            const finalUrl = response.url || url;
            const htmlText = await response.text();

            this.pageCache.set(url, htmlText);
            this.pageCache.set(finalUrl, htmlText);

            this.swapPageContent(htmlText, finalUrl, true);
        } catch (err) {
            window.location.href = url;
        } finally {
            this.isNavigating = false;
        }
    }

    async navigateTo(url, pushState = true) {
        if (this.isNavigating) return;
        this.isNavigating = true;

        try {
            // Check memory cache first for instant 0ms swap
            if (this.pageCache.has(url)) {
                const cachedHtml = this.pageCache.get(url);
                this.swapPageContent(cachedHtml, url, pushState);
                this.isNavigating = false;

                // Re-fetch in background to update cache
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then((res) => res.text())
                    .then((freshHtml) => {
                        this.pageCache.set(url, freshHtml);
                    })
                    .catch(() => {});
                return;
            }

            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const finalUrl = response.url || url;
            const htmlText = await response.text();

            this.pageCache.set(url, htmlText);
            this.pageCache.set(finalUrl, htmlText);

            this.swapPageContent(htmlText, finalUrl, pushState);
        } catch (err) {
            window.location.href = url;
        } finally {
            this.isNavigating = false;
        }
    }

    swapPageContent(htmlText, finalUrl, pushState) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(htmlText, 'text/html');

        // Update Title
        if (doc.title) {
            document.title = doc.title;
        }

        // Keep audio persistent in body
        const audio = document.getElementById('sabiGlobalBgm');

        // Find main content container
        const currentContainer = document.querySelector('.landscape-force') || document.body;
        const newContainer = doc.querySelector('.landscape-force') || doc.body;

        if (currentContainer && newContainer) {
            currentContainer.innerHTML = newContainer.innerHTML;

            // Copy over any body styles / classes if applicable
            if (doc.body) {
                document.body.className = doc.body.className;
            }
        }

        // Sync incoming inline styles from head
        const incomingStyles = doc.querySelectorAll('head style');
        if (incomingStyles.length > 0) {
            document.querySelectorAll('head style[data-spa-style]').forEach(s => s.remove());
            incomingStyles.forEach((st) => {
                const newStyle = document.createElement('style');
                newStyle.setAttribute('data-spa-style', 'true');
                newStyle.textContent = st.textContent;
                document.head.appendChild(newStyle);
            });
        }

        // Sync CSRF Token meta tag
        const incomingCsrf = doc.querySelector('meta[name="csrf-token"]');
        if (incomingCsrf) {
            let existingCsrf = document.querySelector('meta[name="csrf-token"]');
            if (!existingCsrf) {
                existingCsrf = document.createElement('meta');
                existingCsrf.setAttribute('name', 'csrf-token');
                document.head.appendChild(existingCsrf);
            }
            existingCsrf.setAttribute('content', incomingCsrf.getAttribute('content'));
        }

        // Ensure global audio stays in document body
        if (audio && !document.body.contains(audio)) {
            document.body.appendChild(audio);
        }

        // Update browser URL first so scripts reading window.location.search see the new parameters
        if (pushState && finalUrl !== window.location.href) {
            window.history.pushState({ path: finalUrl }, '', finalUrl);
        }

        // Execute any new scripts from incoming document (inside or outside container)
        const scripts = doc.querySelectorAll('body script');
        scripts.forEach((oldScript) => {
            const src = oldScript.getAttribute('src') || '';
            if (src.includes('app.js') || src.includes('@vite') || src.includes('resources/js/app.js')) {
                return; // Skip re-executing main bundle
            }
            const newScript = document.createElement('script');
            Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
            newScript.textContent = oldScript.textContent;
            currentContainer.appendChild(newScript);
        });

        // Re-run all feature initializations for the new page view
        initAllPageFeatures();

        // Scroll to top
        window.scrollTo(0, 0);
    }
}

function bootstrapSabiApp() {
    try {
        window.sabiBgm = new SabiBgmManager();
    } catch (e) {
        console.warn('BGM init error:', e);
    }

    try {
        window.sabiRouter = new SabiSpaRouter();
    } catch (e) {
        console.warn('Router init error:', e);
    }

    try {
        initAllPageFeatures();
    } catch (e) {
        console.warn('Features init error:', e);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootstrapSabiApp);
} else {
    bootstrapSabiApp();
}

