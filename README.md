# Görev Yönetimi Uygulaması

Bu uygulama, görevlerinizi kolayca yönetebilmeniz için geliştirilmiş bir **Görev Yönetimi** uygulamasıdır. Görevlerinizi oluşturabilir, düzenleyebilir, tamamlanmış olarak işaretleyebilir ve silebilirsiniz.

## Özellikler

-   Kullanıcı kaydı ve giriş
-   Görev oluşturma, düzenleme ve silme
-   Görev sıralama ve filtreleme (öncelik, durum, tarih)
-   Sayfalama (5 görev/sayfa)
-   Dashboard: Görev istatistikleri

## Kurulum

1. İndirilen `task_manager_main` klasörünü bir IDE'de açın.
2. Terminalde aşağıdaki komutları çalıştırarak gerekli bağımlılıkları yükleyin:
   composer install
   npm install
3. `.env.example` dosyasını `.env` olarak kopyalayın:
   cp .env.example .env
4. `.env` dosyasındaki `APP_KEY`'i güncellemek için şu komutu çalıştırın:
   php artisan key:generate

5. `.env` dosyasındaki veritabanı bilgilerini, NeonTech'te oluşturduğunuz PostgreSQL veritabanı bilgileriyle doldurun.
6. NeonTech'te tabloları oluşturmak için şu komutu çalıştırın:
   php artisan migrate
7. Uygulamayı başlatmak için önce aşağıdaki komutları çalıştırın:
   npm run dev
   php artisan serve

8. Tarayıcıda `http://localhost:8000` adresine giderek uygulamayı başlatın.
9. Kayıt olarak kullanıcı hesabı oluşturun.
10. Giriş yaparak uygulamayı kullanmaya başlayın.

## Lisans

MIT Lisansı altında sunulmuştur.
