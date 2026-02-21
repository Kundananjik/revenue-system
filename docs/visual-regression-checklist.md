# Visual Regression Checklist

Use this lightweight checklist before merging UI changes.

## Global
1. Header, sidebar, and footer render correctly across Admin, Collector, and User.
2. Layout spacing is consistent with the base layout container (`p-6`).
3. Buttons, alerts, badges, and tables use shared components consistently.

## Role Pages
1. Admin: dashboard, payments, items, categories, penalties, users.
2. Collector: dashboard, payments, items, penalties.
3. User: dashboard, payments, items, penalties, profile.

## Responsive
1. Sidebar toggle works on mobile.
2. Tables remain scrollable without overflow issues.
3. Header actions wrap without breaking layout.
