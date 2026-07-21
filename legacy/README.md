# Legacy PHP + MySQL site (historical)

This folder preserves the original SourceForge "Datarecoverfree" implementation:
a PHP 5 + MySQL web directory of data-recovery software, circa 2013.

- `Code/` — the PHP site (public pages plus an admin panel for managing
  categories, softwares, links, newsletter subscribers, and reviews).
- `Sql/stwoservices.sql` — the phpMyAdmin dump with the database schema
  (`admin_users`, `categories`, `links`, `newsletter`, `os`, `review`,
  `softwares`, `users`). The dump contains the structure only — almost no
  data rows.

This code is **not** used by the modern app and requires a PHP + MySQL server
to run. The current implementation is the 100% client-side static app in
`../web/`, whose JSON data model (`web/data/software.json`) is modeled on the
`softwares` / `categories` / `os` tables from this schema.

Kept for historical reference and license/heritage credit.
