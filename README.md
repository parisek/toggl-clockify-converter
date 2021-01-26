Convert Toggl export (json) to Clockify import (csv)
=======================
I'm working for company [PROFICIO](https://proficiodigital.com) which has 900 clients, 6 000 projects and 24 000 tasks in Toggl. We tried migration with API approach, but it failed. So we switched to native Toggl export and native Clockify import (we just need migrate clients, projects and tasks). This script will convert `JSON` to `CSV` format. I used `PHP` and `
SQLite` (allowing simple edit via Adminer) for migration.

## Installation
1. Clone repository
2. Download [Toggl Workspace Export](https://support.toggl.com/en/articles/2564936-exporting-data#exporting-workspace-data) (json) to `data` folder
3. Follow steps 1-4
4. Use [Clockify (workspace import)](https://clockify.me/help/projects/import-clients-projects)


## Useful Tools
- [Adminer - SQLite client](https://www.adminer.org/)  

