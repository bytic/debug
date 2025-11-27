/* Modern, minimal error page styles */
:root {
  --bg: #ffffff;
  --fg: #1f2328;
  --muted: #6c757d;
  --card: #ffffff;
  --shadow: 0 8px 30px rgba(0,0,0,0.08);
  --accent: #dc3545;
}

@media (prefers-color-scheme: dark) {
  :root {
    --bg: #0b0c0f;
    --fg: #e6edf3;
    --muted: #8b949e;
    --card: #161b22;
    --shadow: 0 8px 30px rgba(0,0,0,0.35);
    --accent: #ff6b6b;
  }
}

html { box-sizing: border-box; }
*, *:before, *:after { box-sizing: inherit; }

body {
  background: var(--bg);
  color: var(--fg);
  font: 16px/1.5 -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  margin: 0;
}

.error {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
}

.card {
  width: 100%;
  max-width: 640px;
  background: var(--card);
  color: var(--fg);
  border-radius: 12px;
  padding: 24px 24px 18px;
  box-shadow: var(--shadow);
}

.icon { color: var(--accent); margin-bottom: 12px; }

h1 {
  margin: 0 0 8px;
  font-size: 22px;
}

.message {
  margin: 0;
  font-size: 16px;
}

.footnote {
  margin: 18px 0 0;
  color: var(--muted);
  font-size: 14px;
}
