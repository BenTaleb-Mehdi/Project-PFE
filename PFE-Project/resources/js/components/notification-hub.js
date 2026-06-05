/*
 * notification-hub.js
 * Alpine component: notificationHub
 * Renders a real-time notification dropdown in the top bar for
 * both admin (dashboard.blade.php) and client (client.blade.php).
 *
 * Polls /api/notifications every 30 seconds while the page is open.
 */

export function notificationHub() {
  return {
    open: false,
    notifications: [],
    unreadCount: 0,
    loading: false,
    pollingInterval: null,

    async init() {
      await this.fetchNotifications();
      // Poll every 30 seconds for new notifications
      this.pollingInterval = setInterval(() => this.fetchNotifications(), 30000);
    },

    destroy() {
      if (this.pollingInterval) clearInterval(this.pollingInterval);
    },

    async fetchNotifications() {
      this.loading = true;
      try {
        const res = await fetch('/api/notifications', {
          headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
          credentials: 'same-origin',
        });
        if (res.ok) {
          const data = await res.json();
          this.notifications = data.notifications ?? [];
          this.unreadCount  = data.unread_count ?? 0;
          this.$nextTick(() => {
            if (typeof lucide !== 'undefined') {
              lucide.createIcons();
            }
          });
        }
      } catch (e) {
        // Silently fail — no connection noise
      } finally {
        this.loading = false;
      }
    },

    toggle() {
      this.open = !this.open;
      if (this.open) this.fetchNotifications();
    },

    async markRead(id) {
      const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
      await fetch(`/api/notifications/${id}/read`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        credentials: 'same-origin',
      });
      const n = this.notifications.find(n => n.id === id);
      if (n) { n.is_read = true; this.unreadCount = Math.max(0, this.unreadCount - 1); }
    },

    async markAllRead() {
      const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
      await fetch('/api/notifications/read-all', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        credentials: 'same-origin',
      });
      this.notifications.forEach(n => n.is_read = true);
      this.unreadCount = 0;
    },

    iconForType(type) {
      const map = {
        success: 'check-circle',
        warning: 'alert-triangle',
        error:   'x-circle',
        info:    'info',
      };
      return map[type] ?? 'bell';
    },

    colorForType(type) {
      const map = {
        success: '#0891B2',
        warning: '#D97706',
        error:   '#DC2626',
        info:    '#6366F1',
      };
      return map[type] ?? '#6366F1';
    },

    timeAgo(dateStr) {
      const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000);
      if (diff < 60)   return `${diff}s ago`;
      if (diff < 3600) return `${Math.floor(diff/60)}m ago`;
      if (diff < 86400) return `${Math.floor(diff/3600)}h ago`;
      return `${Math.floor(diff/86400)}d ago`;
    },
  };
}
