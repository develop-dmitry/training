# 1. Начало работы
## 1.1. Создание .env
## 1.2. Запуск контейнера
```
$ docker-compose up -d --build
```
## 1.3. Сборка всех зависимостей
```
$ ./scripts/build.sh
```
## 1.4. Выполнение миграций
```
$ ./scripts/migrations.sh migrate
```