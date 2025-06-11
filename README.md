# 📚 Book API – Symfony Backend im Docker Container

Willkommen bei der Book API!\
Dieses Projekt ist ein Symfony-Backend, das komplett in Docker Containern läuft.\
Ideal für lokale Entwicklung, Tests oder als Grundlage für eigene Backend-Projekte.

---

## 🚀 Schnellstart

### Voraussetzungen

- [Docker Desktop](https://www.docker.com/products/docker-desktop) (inkl. Docker Compose)
- [Git](https://git-scm.com/) (optional, für das Klonen des Repos)

---

### 1. Repository klonen (optional)

```bash
git clone https://github.com/Dravock/Book-Api-Backend-Symfony-Usage-DEMO.git
cd book-api
```

---

### 2. Container starten

Im Projektverzeichnis ausführen:

```bash
docker compose up --build
```

Das startet alle nötigen Container (PHP/Symfony + MySQL-Datenbank).\
Die API ist dann erreichbar unter: [http://localhost:8000](http://localhost:8000)

> Wenn du die Logs nicht im Terminal sehen willst, kannst du stattdessen
>
> ```bash
> docker compose up -d
> ```
>
> verwenden (läuft dann im Hintergrund).

---

### 3. In den Container "reingehen"

Öffne ein neues Terminal im Projektverzeichnis und gib ein:

```bash
docker compose exec app bash
```

Du befindest dich dann **im Container** und kannst dort alle Symfony-Kommandos ausführen, zum Beispiel:

```bash
php bin/console make:entity
php bin/console doctrine:migrations:migrate
```

---

## 📦 Weitere Hinweise

- Die Datenbank ist standardmäßig auf **MySQL 8** konfiguriert (siehe `.env` und `docker-compose.yml`).
- Zugangsdaten und Ports können bei Bedarf in den Konfigurationsdateien angepasst werden.
- Für lokale Entwicklung werden Volumes genutzt, Änderungen am Code sind direkt im Container verfügbar.

---

## ✨ Features (in Kürze)

-

---

## 🛠️ Nützliche Befehle

```bash
# Container stoppen
docker compose down

# Container im Hintergrund starten
docker compose up -d

# Logs anzeigen
docker compose logs -f

# Composer im Container ausführen
docker compose exec app composer install
```

---

**Viel Spaß beim Entwickeln!**\
Wenn du Fragen hast, gerne ein Issue im Repo öffnen oder direkt hier nachfragen.

---

**Hinweis:** Diese README wird laufend erweitert, sobald neue Features ins Projekt kommen.

---

**Ende der Datei**.

