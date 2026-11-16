importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging-compat.js');

firebase.initializeApp(@json($firebaseConfig));
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    const notification = payload.notification || {};
    self.registration.showNotification(notification.title || 'Crackteck CRM', {
        body: notification.body || '',
        icon: '{{ asset('assets/images/favicon.png') }}',
        data: payload.data || {},
    });
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.url || '{{ url('/demo/crm/index') }}'));
});
