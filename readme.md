# 2025 Jedlik GT tozsde app
Local dev setup:

    git clone https://github.com/FolDoma/tozsde.git
    cd tozsde
    composer i
    npm i
    mv .env.example .env
    php artisan generate:key
    php artisan migrate
  In two seperate terminal:
  

    npm run dev
    php artisan serve
