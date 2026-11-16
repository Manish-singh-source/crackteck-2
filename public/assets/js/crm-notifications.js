(() => {
    const config = window.crmNotificationConfig;
    if (!config) return;

    const list = document.getElementById('crm-notification-list');
    const badge = document.getElementById('crm-notification-badge');
    const headers = { Accept: 'application/json', 'X-CSRF-TOKEN': config.csrfToken };

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[char]));
    const post = (url, body = null) => fetch(url, {
        method: 'POST',
        headers: body ? { ...headers, 'Content-Type': 'application/json' } : headers,
        body: body ? JSON.stringify(body) : null,
    });

    async function loadNotifications() {
        if (document.hidden) return;
        try {
            const response = await fetch(config.endpoints.list, { headers, cache: 'no-store' });
            if (!response.ok) return;
            const result = await response.json();
            const unread = Number(result.unread_count || 0);
            badge.textContent = unread > 99 ? '99+' : unread;
            badge.classList.toggle('d-none', unread === 0);
            list.innerHTML = result.notifications.length ? result.notifications.map(item => {
                const data = item.data || {};
                const url = data.url || '#';
                return `<a class="dropdown-item notify-item border-bottom py-2 ${item.read_at ? '' : 'bg-light'}" href="${escapeHtml(url)}" data-id="${escapeHtml(item.id)}">
                    <div class="d-flex align-items-start"><i data-feather="bell" class="me-2 mt-1"></i><div class="flex-grow-1"><div class="fw-semibold">${escapeHtml(data.title || 'CRM update')}</div><div class="small text-muted text-wrap">${escapeHtml(data.message || '')}</div></div></div>
                </a>`;
            }).join('') : '<div class="p-3 text-muted small">No notifications yet.</div>';
            if (window.feather) window.feather.replace();
            list.querySelectorAll('[data-id]').forEach(element => element.addEventListener('click', () => post(`${config.endpoints.list}/${element.dataset.id}/read`)));
        } catch (_) { /* Preserve last notification state while offline. */ }
    }

    document.getElementById('crm-read-all')?.addEventListener('click', async () => { await post(config.endpoints.readAll); loadNotifications(); });
    loadNotifications();
    setInterval(loadNotifications, 30000);
    document.addEventListener('visibilitychange', loadNotifications);

    const firebaseConfig = config.firebase || {};
    if (!('serviceWorker' in navigator) || !firebaseConfig.apiKey || !firebaseConfig.vapidKey) return;

    let messaging;
    let serviceWorkerRegistration;
    async function enablePush() {
        if (!messaging || !serviceWorkerRegistration) return;
        try {
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') return;
            const token = await messaging.getToken({ vapidKey: firebaseConfig.vapidKey, serviceWorkerRegistration });
            if (token) await post(config.endpoints.deviceToken, { fcm_token: token });
            document.getElementById('crm-enable-push')?.classList.add('d-none');
        } catch (error) { console.warn('CRM web push is unavailable.', error); }
    }
    document.getElementById('crm-enable-push')?.addEventListener('click', enablePush);

    const script = document.createElement('script');
    script.src = 'https://www.gstatic.com/firebasejs/10.13.2/firebase-app-compat.js';
    script.onload = () => {
        const messagingScript = document.createElement('script');
        messagingScript.src = 'https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging-compat.js';
        messagingScript.onload = async () => {
            try {
                window.firebase.initializeApp(firebaseConfig);
                serviceWorkerRegistration = await navigator.serviceWorker.register(config.serviceWorker, { scope: '/demo/' });
                messaging = window.firebase.messaging();
                messaging.onMessage(() => loadNotifications());
                if (Notification.permission === 'granted') enablePush();
            } catch (error) { console.warn('CRM web push is unavailable.', error); }
        };
        document.head.appendChild(messagingScript);
    };
    document.head.appendChild(script);
})();
